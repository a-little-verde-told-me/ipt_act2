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
                    'image' => 'slide1.png',
                    'slug' => 'rustic-wedding',
                ],
                [
                    'name' => '18th Birthday',
                    'category' => 'Birthdays',
                    'image' => 'slide2.png',
                    'slug' => '18th-birthday',
                ],
                [
                    'name' => 'Corporate Gala',
                    'category' => 'Others',
                    'image' => 'slide3.png',
                    'slug' => 'corporate-gala',
                ],
                [
                    'name' => 'Garden Wedding',
                    'category' => 'Weddings',
                    'image' => 'slide4.png',
                    'slug' => 'garden-wedding',
                ],
                [
                    'name' => 'Debut Celebration',
                    'category' => 'Birthdays',
                    'image' => 'slide5.png',
                    'slug' => 'debut-celebration',
                ],
                [
                    'name' => 'Anniversary Party',
                    'category' => 'Others',
                    'image' => 'slide6.png',
                    'slug' => 'anniversary-party',
                ],
            ];
        @endphp

        @foreach($events as $event)
            <div class="event-card" data-category="{{ $event['category'] }}" data-name="{{ strtolower($event['name']) }}">
                <img class="event-image" src="{{ asset('images/'.$event['image']) }}" alt="{{ $event['name'] }}">
                <div class="event-info">
                    <h3>{{ $event['name'] }}</h3>
                    <a href="{{ route('gallery.view', ['event' => $event['slug']]) }}" class="view-gallery-btn">View Gallery</a>
                </div>
            </div>
        @endforeach
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
</script>
@endsection
