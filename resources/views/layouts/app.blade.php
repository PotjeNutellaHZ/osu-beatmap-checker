<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>osu! Beatmap Checker</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-osu-dark text-white min-h-screen">
<!-- Navigation -->
<nav class="bg-osu-pink p-4">
    <div class="container mx-auto flex justify-between items-center">
        <h1 class="text-xl font-bold text-black">osu! Beatmap Checker</h1>
        <button id="menu-toggle" class="block sm">
            <div class="w-6 h-0.5 bg-black mb-1"></div>
            <div class="w-6 h-0.5 bg-black mb-1"></div>
            <div class="w-6 h-0.5 bg-black"></div>
        </button>
    </div>

    <!-- Dropdown Menu -->
    <div id="dropdown-menu" class="hidden absolute top-16 left-0 right-0 bg-osu-pink p-4 z-50">
        <div class="container mx-auto">
            <button class="block w-full text-left py-2 text-black font-semibold" data-filter="all">All Beatmaps</button>
            <button class="block w-full text-left py-2 text-black" data-filter="ranked">Ranked</button>
            <button class="block w-full text-left py-2 text-black" data-filter="loved">Loved</button>
            <div class="border-t border-black mt-2 pt-2">
                <button class="block w-full text-left py-2 text-black" data-mode="osu">osu!standard</button>
                <button class="block w-full text-left py-2 text-black" data-mode="taiko">osu!taiko</button>
                <button class="block w-full text-left py-2 text-black" data-mode="mania">osu!mania</button>
                <button class="block w-full text-left py-2 text-black" data-mode="fruits">osu!catch</button>
            </div>
        </div>
    </div>
</nav>

<main class="container mx-auto p-4">
    @yield('content')
</main>
</body>
</html>
