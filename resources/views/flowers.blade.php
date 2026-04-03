@extends('headerfooter')

@section('title', 'Our Flowers | FLEUR')

@section('content')
<div class="flowers-container">
    <h1 class="page-title">FLOWERS</h1>

    <div class="search-section">
        <div class="search-bar">
            <span class="search-icon" aria-hidden="true"><i class="fa-solid fa-magnifying-glass"></i></span>
            <input type="text" placeholder="Search">
        </div>
    </div>

    <div class="flowers-grid">
        @php
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
            </div>
        @endforeach
    </div>
</div>
@endsection
