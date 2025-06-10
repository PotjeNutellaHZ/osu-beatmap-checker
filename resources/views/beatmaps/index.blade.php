@extends('layouts.app')

@section('content')
    <section class="space-y-6">
        <!-- Search Section -->
        <section class="bg-gray-800 p-4 sm:p-6 rounded-lg">
            <div class="flex items-center space-x-4 mb-4">
                <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center">
                    <span class="text-black font-bold">🔍</span>
                </div>
                <h2 class="text-xl sm:text-2xl font-bold">Search beatmaps</h2>
            </div>
            <input type="text" id="search-input" placeholder="Search for beatmaps..."
                   class="w-full p-3 rounded bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-osu-pink">
        </section>

        <!-- Random Beatmap Section -->
        <section class="bg-gray-800 p-4 sm:p-6 rounded-lg">
            <div class="flex items-center space-x-4 mb-4">
                <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center">
                    <span class="text-black font-bold">?</span>
                </div>
                <h2 class="text-xl sm:text-2xl font-bold">Random beatmap</h2>
            </div>
            <button id="random-btn" class="bg-osu-pink text-black px-6 py-2 rounded font-semibold hover:bg-pink-400 transition-colors">
                Get Random Beatmap
            </button>
        </section>

        <!-- Most Popular Today -->
        <section class="bg-gray-800 p-4 sm:p-6 rounded-lg">
            <div class="flex items-center space-x-4 mb-6">
                <div class="w-8 h-8 bg-osu-pink rounded-full flex items-center justify-center">
                    <span class="text-black font-bold text-xs">osu!</span>
                </div>
                <h2 class="text-xl sm:text-2xl font-bold">Most recent ranked beatmaps</h2>
            </div>

            <div id="beatmap-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                <!-- Beatmaps will be loaded here -->
            </div>

            <div id="loading" class="text-center py-8 hidden">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-osu-pink"></div>
            </div>
        </section>
    </section>
@endsection
