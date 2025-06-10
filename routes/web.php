<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeatmapController;

Route::get('/', [BeatmapController::class, 'index'])->name('beatmaps.index');
Route::get('/search', [BeatmapController::class, 'search'])->name('beatmaps.search');
Route::get('/beatmap/{id}', [BeatmapController::class, 'show'])->name('beatmaps.show');
Route::get('/api/beatmap/{id}', [BeatmapController::class, 'api'])->name('beatmaps.api');
Route::get('/beatmaps/random', [BeatmapController::class, 'random']);
