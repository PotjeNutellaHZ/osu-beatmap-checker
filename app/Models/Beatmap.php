<?php

namespace App\Models;

class Beatmap
{
    public $id, $title, $artist, $creator, $difficulty_rating, $mode, $status, $cover_url, $playcount, $favourite_count;

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->title = $data['title'] ?? '';
        $this->artist = $data['artist'] ?? '';
        $this->creator = $data['creator'] ?? '';
        $this->difficulty_rating = $data['difficulty_rating'] ?? 0;
        $this->mode = $data['mode'] ?? '';
        $this->status = $data['status'] ?? '';
        $this->cover_url = $data['cover_url'] ?? '';
        $this->playcount = $data['playcount'] ?? 0;
        $this->favourite_count = $data['favourite_count'] ?? 0;
    }
}
