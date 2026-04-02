@extends('headerfooter')

@section('title', 'Our Flowers | FLEUR')

@section('content')
<div class="flowers-container">
    <h1 class="page-title">FLOWERS</h1>

    <div class="search-section">
        <div class="search-bar">
            <span class="search-icon">🔍</span>
            <input type="text" placeholder="Search">
            <span class="filter-icon">⚙️</span>
        </div>
    </div>

    <div class="flowers-grid">
        @php
            // This simulates data coming from a database
            $flowers = [
                'Classic Red Rose', 'White Casablanca', 'Pink Peony', 'Sun-kissed Tulip',
                'Wild Lavender', 'Blue Hydrangea', 'Golden Sunflower', 'Orchid Delight'
            ];
        @endphp

        @foreach($flowers as $name)
            <div class="flower-card">
                <div class="flower-image-placeholder">
                    <span>Image</span>
                </div>
                <p class="flower-name">{{ $name }}</p>
            </div>
        @endforeach
    </div>
</div>
@endsection