import './bootstrap';
import '../css/app.css';

class BeatmapApp {
    constructor() {
        this.currentMode = null;
        this.currentStatus = null;
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.loadPopularBeatmaps();
    }

    setupEventListeners() {
        // Menu toggle
        const menuToggle = document.getElementById('menu-toggle');
        const dropdownMenu = document.getElementById('dropdown-menu');

        if (menuToggle && dropdownMenu) {
            menuToggle.addEventListener('click', () => {
                dropdownMenu.classList.toggle('hidden');
            });

            // Close menu when clicking outside
            document.addEventListener('click', (e) => {
                if (!menuToggle.contains(e.target) && !dropdownMenu.contains(e.target)) {
                    dropdownMenu.classList.add('hidden');
                }
            });
        }

        // Filter buttons
        document.querySelectorAll('[data-filter]').forEach(btn => {
            btn.addEventListener('click', (e) => {
                this.currentStatus = e.target.dataset.filter === 'all' ? null : e.target.dataset.filter;
                this.searchBeatmaps();
                dropdownMenu?.classList.add('hidden');
            });
        });

        // Mode buttons
        document.querySelectorAll('[data-mode]').forEach(btn => {
            btn.addEventListener('click', (e) => {
                this.currentMode = e.target.dataset.mode;
                this.searchBeatmaps();
                dropdownMenu?.classList.add('hidden');
            });
        });

        // Search input
        const searchInput = document.getElementById('search-input');
        if (searchInput) {
            let timeout;
            searchInput.addEventListener('input', (e) => {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    this.searchBeatmaps(e.target.value);
                }, 300);
            });
        }

        // Random button
        const randomBtn = document.getElementById('random-btn');
        if (randomBtn) {
            randomBtn.addEventListener('click', () => {
                this.getRandomBeatmap();
            });
        }
    }

    async loadPopularBeatmaps() {
        this.showLoading(true);
        try {
            const response = await fetch('/search?status=ranked');
            const beatmaps = await response.json();
            this.renderBeatmaps(beatmaps);
        } catch (error) {
            console.error('Error loading beatmaps:', error);
            this.showError('Failed to load beatmaps');
        } finally {
            this.showLoading(false);
        }
    }

    async searchBeatmaps(query = '') {
        this.showLoading(true);
        try {
            const params = new URLSearchParams({
                q: query,
                ...(this.currentMode && { mode: this.currentMode }),
                ...(this.currentStatus && { status: this.currentStatus })
            });

            const response = await fetch(`/search?${params}`);
            const beatmaps = await response.json();
            this.renderBeatmaps(beatmaps);
        } catch (error) {
            console.error('Error searching beatmaps:', error);
            this.showError('Search failed');
        } finally {
            this.showLoading(false);
        }
    }

    async getRandomBeatmap() {
        try {
            // Get a random beatmap from current results or search
            const response = await fetch('/search?status=ranked');
            const beatmaps = await response.json();

            if (beatmaps.length > 0) {
                const randomBeatmap = beatmaps[Math.floor(Math.random() * beatmaps.length)];
                window.location.href = `/beatmap/${randomBeatmap.id}`;
            }
        } catch (error) {
            console.error('Error getting random beatmap:', error);
            this.showError('Failed to get random beatmap');
        }
    }

    renderBeatmaps(beatmaps) {
        const grid = document.getElementById('beatmap-grid');
        if (!grid) return;

        if (beatmaps.length === 0) {
            grid.innerHTML = '<p class="col-span-full text-center text-gray-400">No beatmaps found</p>';
            return;
        }

        grid.innerHTML = beatmaps.map(beatmap => `
            <article class="bg-gray-700 rounded-lg overflow-hidden hover:bg-gray-600 transition-colors cursor-pointer"
                     onclick="window.location.href='/beatmap/${beatmap.id}'">
                <div class="aspect-video bg-gradient-to-r from-blue-900 to-purple-900 relative">
                    <img src="${beatmap.cover_url}" alt="${beatmap.title}"
                         class="w-full h-full object-cover"
                         onerror="this.style.display='none'">
                    <div class="absolute top-2 right-2 bg-black bg-opacity-75 px-2 py-1 rounded text-xs">
                        ${beatmap.difficulty_rating?.toFixed(1)}★
                    </div>
                </div>
                <div class="p-3">
                    <h3 class="font-bold truncate">${beatmap.title}</h3>
                    <p class="text-sm text-gray-300 truncate">${beatmap.artist}</p>
                    <p class="text-xs text-gray-400">by ${beatmap.creator}</p>
                    <div class="flex justify-between mt-2 text-xs text-gray-400">
                        <span>${beatmap.playcount?.toLocaleString()} plays</span>
                        <span class="capitalize">${beatmap.status}</span>
                    </div>
                </div>
            </article>
        `).join('');
    }

    showLoading(show) {
        const loading = document.getElementById('loading');
        if (loading) {
            loading.classList.toggle('hidden', !show);
        }
    }

    showError(message) {
        // Simple error display - could be enhanced with a proper notification system
        const grid = document.getElementById('beatmap-grid');
        if (grid) {
            grid.innerHTML = `<p class="col-span-full text-center text-red-400">${message}</p>`;
        }
    }
}

// Initialize app when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new BeatmapApp();
});
