@extends('headerfooter')

@section('title', 'FLEUR | Elegant Bouquets')

@section('content')
    <section class="hero-slider">
        <div class="slider-container">
            <button class="arrow prev">&#10094;</button>
            <div class="slide-content">
                <h1>Nature's Finest Elegance</h1>
                <p>Hand-picked bouquets for your special moments.</p>
            </div>
            <button class="arrow next">&#10095;</button>
        </div>
        <div class="dots">
            <span class="dot active"></span>
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
        </div>
    </section>

    <section class="featured">
        <h2>FEATURED BOUQUETS</h2>
        <div class="product-grid">
            {{-- Eventually, you will replace these with a @foreach loop --}}
            @php
                $products = ['Midnight Rose', 'Summer Peony', 'Wild Lavender', 'Pure Lily'];
            @endphp

            @foreach($products as $name)
            <div class="product-card">
                <div class="product-img-placeholder">Product Image</div>
                <p class="product-name">{{ $name }}</p>
            </div>
            @endforeach
        </div>
        <button class="shop-now-btn">Shop Now</button>
    </section>
@endsection