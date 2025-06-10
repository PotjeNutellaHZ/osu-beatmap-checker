<?php
// app/Http/Controllers/BeatmapController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OsuApiService;

class BeatmapController extends Controller
{
    private $osuApi;

    public function __construct(OsuApiService $osuApi)
    {
        $this->osuApi = $osuApi;
    }

    public function index()
    {
        return view('beatmaps.index');
    }

    public function search(Request $request)
    {
        $beatmaps = $this->osuApi->searchBeatmaps(
            $request->get('q', ''),
            $request->get('mode'),
            $request->get('status')
        );

        return response()->json($beatmaps);
    }

    public function show($id)
    {
        $beatmap = $this->osuApi->getBeatmap($id);

        if (!$beatmap) {
            abort(404);
        }

        return view('beatmaps.show', compact('beatmap'));
    }

    public function api($id)
    {
        $beatmap = $this->osuApi->getBeatmap($id);
        return response()->json($beatmap);
    }
}
