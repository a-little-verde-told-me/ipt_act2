@extends('headerfooter')

@section('title', 'Photo Gallery | FLEUR')

@section('content')
<div class="gallery-container">
    <h1 class="page-title">PHOTO GALLERY</h1>

    <div class="search-section">
        <div class="search-bar">
            <span class="search-icon">🔍</span>
            <input type="text" placeholder="Search events...">
            <span class="filter-icon">⚙️</span>
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
                ['name' => 'Rustic Wedding', 'category' => 'Weddings'],
                ['name' => '18th Birthday', 'category' => 'Birthdays'],
                ['name' => 'Corporate Gala', 'category' => 'Others'],
                ['name' => 'Garden Wedding', 'category' => 'Weddings'],
                ['name' => 'Debut Celebration', 'category' => 'Birthdays'],
                ['name' => 'Anniversary Party', 'category' => 'Others'],
            ];
        @endphp

        @foreach($events as $event)
            <div class="event-card">
                <div class="event-image-placeholder">
                    <span>Image</span>
                </div>
                <div class="event-info">
                    <h3>{{ $event['name'] }}</h3>
                    <a href="{{ route('gallery.view') }}" class="view-gallery-btn">View Gallery</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection