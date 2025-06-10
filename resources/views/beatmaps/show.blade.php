@extends('layouts.app')

@section('content')
    <section class="max-w-4xl mx-auto">
        <div class="bg-gray-800 rounded-lg overflow-hidden">
            <!-- Header Image -->
            <div class="relative h-48 sm:h-64 bg-gradient-to-r from-blue-900 to-purple-900">
                <img src="{{ $beatmap->cover_url }}" alt="Beatmap cover"
                     class="w-full h-full object-cover"
                     onerror="this.style.display='none'">
                <div class="absolute inset-0 bg-black bg-opacity-30 flex items-end">
                    <div class="p-4 sm:p-6 text-white">
                        <h1 class="text-2xl sm:text-3xl font-bold">{{ $beatmap->title }}</h1>
                        <p class="text-lg opacity-90">{{ $beatmap->artist }}</p>
                        <p class="text-sm opacity-75">Mapped by {{ $beatmap->creator }}</p>
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Description -->
                <section>
                    <h3 class="text-xl font-bold mb-4">Description</h3>
                    <div class="bg-gray-700 p-4 rounded text-gray-300 space-y-2">
                        <p><strong>Status:</strong> {{ ucfirst($beatmap->status) }}</p>
                        <p><strong>Game Mode:</strong> {{ ucfirst($beatmap->mode) }}</p>
                        <p><strong>Difficulty:</strong> {{ number_format($beatmap->difficulty_rating, 2) }}★</p>
                        <p><strong>Creator:</strong> {{ $beatmap->creator }}</p>
                    </div>
                </section>

                <!-- Stats -->
                <section>
                    <h3 class="text-xl font-bold mb-4">Stats</h3>
                    <div class="bg-gray-700 p-4 rounded text-gray-300 space-y-2">
                        <p><strong>Play Count:</strong> {{ number_format($beatmap->playcount) }}</p>
                        <p><strong>Favourites:</strong> {{ number_format($beatmap->favourite_count) }}</p>
                        <p><strong>Beatmap ID:</strong> {{ $beatmap->id }}</p>
                    </div>
                </section>
            </div>
        </div>
    </section>
@endsection
