@extends('headerfooter')

@section('title', 'Our Flowers | FLEUR')

@section('content')
<div class="products-page" data-all-flowers="{{ json_encode($allFlowers) }}">
    <h1 class="page-title">FLOWERS</h1>

    <div class="search-section">
        <div class="search-bar">
            <span class="search-icon" aria-hidden="true"><i class="fa-solid fa-magnifying-glass"></i></span>
            <input type="text" placeholder="Search flowers..." id="flowerSearch">
        </div>
    </div>

    <div class="filter-sort-section">
        <div class="filter-group">
            <label for="colorFilter">Color:</label>
            <select id="colorFilter" class="filter-select">
                <option value="">All Colors</option>
                <option value="red">Red</option>
                <option value="pink">Pink</option>
                <option value="white">White</option>
                <option value="yellow">Yellow</option>
                <option value="purple">Purple</option>
                <option value="orange">Orange</option>
                <option value="blue">Blue</option>
                <option value="green">Green</option>
            </select>
        </div>
        <div class="sort-group">
            <label for="sortBy">Sort:</label>
            <select id="sortBy" class="sort-select">
                <option value="featured">Featured</option>
                <option value="name-asc">A - Z</option>
                <option value="name-desc">Z - A</option>
            </select>
        </div>
        <div class="reset-group">
            <button type="button" id="resetFilters" class="reset-btn">Reset</button>
        </div>
    </div>

    <div class="products-grid" id="flowersGrid">
        @foreach($flowers as $flower)
            <div class="product-card" data-name="{{ strtolower($flower['name']) }}">
                <button class="flower-link" type="button" data-image="{{ asset('images/'.$flower['image']) }}" data-title="{{ $flower['name'] }}">
                    <div class="product-image">
                        <img class="flower-image" src="{{ asset('images/'.$flower['image']) }}" alt="{{ $flower['name'] }}">
                    </div>
                </button>
                <div class="product-info">
                    <h3>{{ $flower['name'] }}</h3>
                </div>
            </div>
        @endforeach
    </div>

    @if ($flowers->hasPages())
        <div class="pagination-wrapper">
            {{ $flowers->links('pagination::custom') }}
        </div>
    @endif
</div>

<div class="lightbox" id="flowerLightbox" aria-hidden="true">
    <div class="lightbox-content" role="dialog" aria-modal="true">
        <button class="lightbox-close" type="button" aria-label="Close">&times;</button>
        <img id="flowerLightboxImage" src="" alt="">
        <p id="flowerLightboxTitle"></p>
    </div>
</div>

<script>
    const searchInput = document.getElementById('flowerSearch');
    const colorFilter = document.getElementById('colorFilter');
    const sortBy = document.getElementById('sortBy');
    const resetButton = document.getElementById('resetFilters');
    const flowersGrid = document.getElementById('flowersGrid');
    const pageContainer = document.querySelector('.products-page');
    const paginationWrapper = document.querySelector('.pagination-wrapper');

    // Get all flowers from data attribute
    let allFlowers = [];
    try {
        const flowersData = pageContainer.dataset.allFlowers;
        if (flowersData) {
            allFlowers = JSON.parse(flowersData);
        }
    } catch (e) {
        console.error('Error parsing flowers data:', e);
    }

    const flowerColors = {
        'pink': ['cosmos', 'gerbera', 'gomphrena', 'snapdragon', 'strawflower', 'zinnia', 'verbena', 'torenia', 'nicotiana'],
        'red': ['dahlia', 'indian paintbrush', 'nasturtium'],
        'orange': ['dahlia', 'gladiolus', 'ranunculus'],
        'purple': ['anemone', 'gomphrena', 'stock', 'wild bergamot', 'morning glory', 'lobelia', 'browallia'],
        'green': ['bells of ireland'],
        'yellow': ['celosia', 'chrysanthemum', 'craspedia', 'dahlia', 'snapdragon', 'sunflower', 'dusty miller', 'gazania'],
        'blue': ['bluebonnet', 'larkspur', 'nigella'],
        'white': ['snapdragon', 'sweet alyssum', 'torenia', 'alyssum']
    };

    const itemsPerPage = 10;
    let currentPage = 1;
    let filteredFlowers = [];

    function getFlowerColor(flowerName) {
        const nameLower = flowerName.toLowerCase();
        for (const [color, keywords] of Object.entries(flowerColors)) {
            if (keywords.some(keyword => nameLower.includes(keyword))) {
                return color;
            }
        }
        return '';
    }

    function createClientPagination(totalItems) {
        if (!paginationWrapper) return;

        const totalPages = Math.ceil(totalItems / itemsPerPage);

        if (totalPages <= 1) {
            paginationWrapper.innerHTML = '';
            return;
        }

        let html = '<nav class="pagination-nav" aria-label="Flower pagination"><ul class="pagination">';

        // Previous button
        html += `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}">`;
        html += `<button type="button" class="page-link" data-page="${Math.max(1, currentPage - 1)}" ${currentPage === 1 ? 'disabled' : ''}>← Previous</button>`;
        html += '</li>';

        for (let i = 1; i <= totalPages; i++) {
            html += `<li class="page-item ${i === currentPage ? 'active' : ''}">`;
            html += `<button type="button" class="page-link" data-page="${i}" ${i === currentPage ? 'aria-current="page"' : ''}>${i}</button>`;
            html += '</li>';
        }

        html += `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">`;
        html += `<button type="button" class="page-link" data-page="${Math.min(totalPages, currentPage + 1)}" ${currentPage === totalPages ? 'disabled' : ''}>Next →</button>`;
        html += '</li>';

        html += '</ul></nav>';
        paginationWrapper.innerHTML = html;

        paginationWrapper.querySelectorAll('button[data-page]').forEach(btn => {
            btn.addEventListener('click', () => {
                const requestedPage = parseInt(btn.dataset.page);
                if (!Number.isNaN(requestedPage) && requestedPage !== currentPage) {
                    currentPage = requestedPage;
                    renderPage();
                }
            });
        });
    }

    function renderPage() {
        const startIdx = (currentPage - 1) * itemsPerPage;
        const endIdx = startIdx + itemsPerPage;
        const flowersToDisplay = filteredFlowers.slice(startIdx, endIdx);

        flowersGrid.innerHTML = '';
        flowersToDisplay.forEach(flower => {
            const card = document.createElement('div');
            card.className = 'product-card';
            card.dataset.name = flower.name.toLowerCase();
            card.innerHTML = `
                <button class="flower-link" type="button" data-image="${flower.image ? '/images/' + flower.image : ''}" data-title="${flower.name}">
                    <div class="product-image">
                        <img class="flower-image" src="${flower.image ? '/images/' + flower.image : ''}" alt="${flower.name}">
                    </div>
                </button>
                <div class="product-info">
                    <h3>${flower.name}</h3>
                </div>
            `;
            flowersGrid.appendChild(card);

            const flowerLink = card.querySelector('.flower-link');
            flowerLink.addEventListener('click', () => {
                lightboxImage.src = flowerLink.dataset.image;
                lightboxImage.alt = flowerLink.dataset.title || 'Flower image';
                lightboxTitle.textContent = flowerLink.dataset.title || '';
                lightbox.classList.add('open');
                lightbox.setAttribute('aria-hidden', 'false');
            });
        });

        createClientPagination(filteredFlowers.length);
    }

    function filterAndSortFlowers() {
        const searchQuery = searchInput.value.trim().toLowerCase();
        const selectedColor = colorFilter.value;
        const sortOption = sortBy.value;

        filteredFlowers = allFlowers.filter(flower => {
            const flowerName = flower.name.toLowerCase();
            const flowerColor = getFlowerColor(flowerName);

            const matchesSearch = !searchQuery || flowerName.includes(searchQuery);
            const matchesColor = !selectedColor || flowerColor === selectedColor;

            return matchesSearch && matchesColor;
        });

        if (sortOption === 'name-asc') {
            filteredFlowers.sort((a, b) => a.name.localeCompare(b.name));
        } else if (sortOption === 'name-desc') {
            filteredFlowers.sort((a, b) => b.name.localeCompare(a.name));
        }

        currentPage = 1;
        renderPage();
    }

    searchInput.addEventListener('input', filterAndSortFlowers);
    colorFilter.addEventListener('change', filterAndSortFlowers);
    sortBy.addEventListener('change', filterAndSortFlowers);
    resetButton.addEventListener('click', () => {
        searchInput.value = '';
        colorFilter.value = '';
        sortBy.value = 'featured';
        filterAndSortFlowers();
    });

    const lightbox = document.getElementById('flowerLightbox');
    const lightboxImage = document.getElementById('flowerLightboxImage');
    const lightboxTitle = document.getElementById('flowerLightboxTitle');
    const closeBtn = lightbox.querySelector('.lightbox-close');

    function closeLightbox() {
        lightbox.classList.remove('open');
        lightbox.setAttribute('aria-hidden', 'true');
        lightboxImage.src = '';
    }

    closeBtn.addEventListener('click', closeLightbox);
    lightbox.addEventListener('click', (e) => {
        if (e.target === lightbox) closeLightbox();
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && lightbox.classList.contains('open')) {
            closeLightbox();
        }
    });

    // Initialize on page load
    filterAndSortFlowers();
</script>
@endsection
