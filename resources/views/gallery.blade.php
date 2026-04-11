@extends('headerfooter')

@section('title', 'Photo Gallery | FLEUR')

@section('content')
<div class="gallery-container">
    <h1 class="page-title">PHOTO GALLERY</h1>

    <div class="search-section">
        <div class="search-bar">
            <span class="search-icon" aria-hidden="true"><i class="fa-solid fa-magnifying-glass"></i></span>
            <input type="text" placeholder="Search events..." id="searchInput">
        </div>
    </div>

    <div class="filter-sort-section">
        <div class="filter-group">
            <label for="categorySelect">Category:</label>
            <select id="categorySelect" class="filter-select">
                <option value="">All Events</option>
                <option value="Weddings">Weddings</option>
                <option value="Birthdays">Birthdays</option>
                <option value="Others">Others</option>
            </select>
        </div>
        <div class="sort-group">
            <label for="sortSelect">Sort:</label>
            <select id="sortSelect" class="sort-select">
                <option value="featured">Featured</option>
                <option value="name-asc">A - Z</option>
                <option value="name-desc">Z - A</option>
            </select>
        </div>
        <div class="reset-group">
            <button type="button" id="resetFilters" class="reset-btn">Reset</button>
        </div>
    </div>

    <div class="gallery-grid">
        @foreach($events as $event)
            <div class="event-card" data-category="{{ $event['category'] }}" data-name="{{ strtolower($event['name']) }}">
                <button class="event-link" type="button" data-image="{{ asset('images/'.$event['image']) }}" data-title="{{ $event['name'] }}">
                    <img class="event-image" src="{{ asset('images/'.$event['image']) }}" alt="{{ $event['name'] }}">
                </button>
                <div class="event-info">
                    <h3>{{ $event['name'] }}</h3>
                    <a href="{{ route('gallery.view', ['event' => $event['slug']]) }}" class="view-gallery-btn">View Gallery</a>
                </div>
            </div>
        @endforeach
    </div>

    @if ($events->hasPages())
        <div class="pagination-wrapper">
            {{ $events->links('pagination::custom') }}
        </div>
    @endif
</div>

<div class="lightbox" id="galleryLightbox" aria-hidden="true">
    <div class="lightbox-content" role="dialog" aria-modal="true">
        <button class="lightbox-close" type="button" aria-label="Close">&times;</button>
        <img id="galleryLightboxImage" src="" alt="">
        <p id="galleryLightboxTitle"></p>
    </div>
</div>

<script>
    const searchInput = document.getElementById('searchInput');
    const categorySelect = document.getElementById('categorySelect');
    const sortSelect = document.getElementById('sortSelect');
    const resetButton = document.getElementById('resetFilters');
    const eventCards = document.querySelectorAll('.event-card');

    function filterGallery(category, query) {
        eventCards.forEach(card => {
            const cardCategory = card.dataset.category;
            const cardName = card.dataset.name;
            const categoryMatch = !category || category === 'All' || cardCategory === category;
            const searchMatch = !query || cardName.includes(query.toLowerCase());
            card.style.display = (categoryMatch && searchMatch) ? 'block' : 'none';
        });
    }

    function sortGallery(order) {
        const cards = Array.from(eventCards);
        const container = document.querySelector('.gallery-grid');

        if (!container) return;

        cards.sort((a, b) => {
            const nameA = a.dataset.name || '';
            const nameB = b.dataset.name || '';
            if (order === 'name-asc') return nameA.localeCompare(nameB);
            if (order === 'name-desc') return nameB.localeCompare(nameA);
            return 0;
        });

        cards.forEach(card => container.appendChild(card));
    }

    function applyGalleryFilters() {
        const category = categorySelect.value;
        const query = searchInput.value.trim();
        filterGallery(category, query);
        sortGallery(sortSelect.value);
    }

    searchInput.addEventListener('input', applyGalleryFilters);
    categorySelect.addEventListener('change', applyGalleryFilters);
    sortSelect.addEventListener('change', applyGalleryFilters);
    resetButton.addEventListener('click', () => {
        searchInput.value = '';
        categorySelect.value = '';
        sortSelect.value = 'featured';
        applyGalleryFilters();
    });

    applyGalleryFilters();

    const lightbox = document.getElementById('galleryLightbox');
    const lightboxImage = document.getElementById('galleryLightboxImage');
    const lightboxTitle = document.getElementById('galleryLightboxTitle');
    const closeBtn = lightbox.querySelector('.lightbox-close');

    document.querySelectorAll('.event-link').forEach(btn => {
        btn.addEventListener('click', () => {
            lightboxImage.src = btn.dataset.image;
            lightboxImage.alt = btn.dataset.title || 'Event image';
            lightboxTitle.textContent = btn.dataset.title || '';
            lightbox.classList.add('open');
            lightbox.setAttribute('aria-hidden', 'false');
        });
    });

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
</script>
@endsection
