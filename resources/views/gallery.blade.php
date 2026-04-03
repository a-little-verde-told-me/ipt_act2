@extends('headerfooter')

@section('title', 'Photo Gallery | FLEUR')

@section('content')
<div class="gallery-container">
    <h1 class="page-title">PHOTO GALLERY</h1>

    <div class="search-section">
        <div class="search-bar">
            <span class="search-icon" aria-hidden="true"><i class="fa-solid fa-magnifying-glass"></i></span>
            <input type="text" placeholder="Search events...">
        </div>
    </div>

    <div class="filter-section">
        <button class="filter-btn active">All</button>
        <button class="filter-btn">Weddings</button>
        <button class="filter-btn">Birthdays</button>
        <button class="filter-btn">Others</button>
    </div>

    <div class="gallery-grid">
        @php
            $events = [
                [
                    'name' => 'Rustic Wedding',
                    'category' => 'Weddings',
                    'image' => 'rustic_wedding.jpg',
                    'slug' => 'rustic-wedding',
                ],
                [
                    'name' => '18th Birthday',
                    'category' => 'Birthdays',
                    'image' => '18th_birthday.jpg',
                    'slug' => '18th-birthday',
                ],
                [
                    'name' => 'Corporate Gala',
                    'category' => 'Others',
                    'image' => 'corporate_gala.jpg',
                    'slug' => 'corporate-gala',
                ],
                [
                    'name' => 'Garden Wedding',
                    'category' => 'Weddings',
                    'image' => 'garden_wedding.jpg',
                    'slug' => 'garden-wedding',
                ],
                [
                    'name' => 'Debut Celebration',
                    'category' => 'Birthdays',
                    'image' => 'debut_celebration.jpg',
                    'slug' => 'debut-celebration',
                ],
                [
                    'name' => 'Anniversary Party',
                    'category' => 'Others',
                    'image' => 'anniversary_party.jpg',
                    'slug' => 'anniversary-party',
                ],
            ];
        @endphp

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
</div>

<div class="lightbox" id="galleryLightbox" aria-hidden="true">
    <div class="lightbox-content" role="dialog" aria-modal="true">
        <button class="lightbox-close" type="button" aria-label="Close">&times;</button>
        <img id="galleryLightboxImage" src="" alt="">
        <p id="galleryLightboxTitle"></p>
    </div>
</div>

<script>
    const searchInput = document.querySelector('.search-bar input');
    const filterButtons = document.querySelectorAll('.filter-btn');
    const eventCards = document.querySelectorAll('.event-card');

    function filterGallery(category, query) {
        eventCards.forEach(card => {
            const cardCategory = card.dataset.category;
            const cardName = card.dataset.name;
            const categoryMatch = category === 'All' || cardCategory === category;
            const searchMatch = !query || cardName.includes(query.toLowerCase());
            card.style.display = (categoryMatch && searchMatch) ? 'block' : 'none';
        });
    }

    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            filterButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            filterGallery(btn.textContent.trim(), searchInput.value.trim());
        });
    });

    searchInput.addEventListener('input', () => {
        const active = document.querySelector('.filter-btn.active');
        filterGallery(active.textContent.trim(), searchInput.value.trim());
    });

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
