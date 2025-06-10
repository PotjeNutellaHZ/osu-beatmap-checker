<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\Beatmap;

class OsuApiService
{
    private $baseUrl = 'https://osu.ppy.sh/api/v2';
    private $token;

    public function __construct()
    {
        $this->authenticate();
    }

    private function authenticate()
    {
        $this->token = Cache::remember('osu_token', 3600, function () {
            $response = Http::post('https://osu.ppy.sh/oauth/token', [
                'client_id' => config('services.osu.client_id'),
                'client_secret' => config('services.osu.client_secret'),
                'grant_type' => 'client_credentials',
                'scope' => 'public'
            ]);

            return $response->json()['access_token'] ?? null;
        });
    }

    public function searchBeatmaps($query = '', $mode = null, $status = null)
    {
        $params = [
            'q' => $query,
            's' => $status,
            'm' => $this->getModeId($mode)
        ];

        $response = Http::withToken($this->token)
            ->get($this->baseUrl . '/beatmapsets/search', array_filter($params));

        if ($response->successful()) {
            $beatmapSets = $response->json()['beatmapsets'] ?? [];

            return collect($beatmapSets)->map(function ($set) {
                // Geef de volledige beatmapset door
                return new Beatmap([
                    'id' => $set['beatmaps'][0]['id'] ?? null,
                    'title' => $set['title'] ?? '',
                    'artist' => $set['artist'] ?? '',
                    'creator' => $set['creator'] ?? '',
                    'difficulty_rating' => $set['beatmaps'][0]['difficulty_rating'] ?? 0,
                    'mode' => $set['beatmaps'][0]['mode'] ?? '',
                    'status' => $set['status'] ?? '',
                    'cover_url' => $set['covers']['cover'] ?? '',
                    'playcount' => $set['play_count'] ?? 0,
                    'favourite_count' => $set['favourite_count'] ?? 0,
                ]);
            });
        }

        return collect();
    }

    public function getBeatmap($id)
    {
        $response = Http::withToken($this->token)
            ->get($this->baseUrl . "/beatmaps/{$id}");

        if (!$response->successful()) {
            return null;
        }

        $beatmapData = $response->json();

        // Haal de set-informatie op
        $setId = $beatmapData['beatmapset']['id'] ?? $beatmapData['beatmapset_id'];
        $setResponse = Http::withToken($this->token)
            ->get($this->baseUrl . "/beatmapsets/{$setId}");

        $setData = $setResponse->successful() ? $setResponse->json() : [];

        return new Beatmap([
            'id' => $beatmapData['id'],
            'title' => $setData['title'] ?? '',
            'artist' => $setData['artist'] ?? '',
            'creator' => $setData['creator'] ?? '',
            'difficulty_rating' => $beatmapData['difficulty_rating'] ?? 0,
            'mode' => $beatmapData['mode'] ?? '',
            'status' => $setData['status'] ?? '',
            'cover_url' => $setData['covers']['cover'] ?? '',
            'playcount' => $setData['play_count'] ?? 0,
            'favourite_count' => $setData['favourite_count'] ?? 0,
        ]);
    }

    private function getModeId($mode)
    {
        $modes = [
            'osu' => 0,
            'taiko' => 1,
            'fruits' => 2,
            'mania' => 3
        ];

        return $modes[$mode] ?? null;
    }
}
