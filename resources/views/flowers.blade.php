@extends('headerfooter')

@section('title', 'Our Flowers | FLEUR')

@section('content')
<div class="products-page">
    <h1 class="page-title">FLOWERS</h1>

    <div class="search-section">
        <form method="GET" action="{{ route('flowers') }}" class="product-filters">
            <div class="product-search-row">
                <div class="search-bar">
                    <span class="search-icon" aria-hidden="true"><i class="fa-solid fa-magnifying-glass"></i></span>
                    <input type="text" name="search" placeholder="Search flowers..." value="{{ $activeSearch ?? '' }}">
                </div>
            </div>
            <div class="filters-row">
                <div class="filters-right">
                    <button type="submit" class="product-filter-btn">Search</button>
                    <a href="{{ route('flowers') }}" class="product-filter-reset">Reset</a>
                </div>
            </div>
        </form>
    </div>

    <div class="products-grid">
        @forelse($flowers as $flower)
            <div class="product-card" data-name="{{ strtolower($flower->name) }}">
                @php
                    $flowerImage = $flower->image_url
                        ? (str_starts_with($flower->image_url, 'http') ? $flower->image_url : asset('images/'.$flower->image_url))
                        : asset('images/placeholder.jpg');
                @endphp
                <button class="flower-link" type="button" data-image="{{ $flowerImage }}" data-title="{{ $flower->name }}">
                    <div class="product-image">
                        <img class="flower-image" src="{{ $flowerImage }}" alt="{{ $flower->name }}">
                    </div>
                </button>
                <div class="product-info">
                    <h3>{{ $flower->name }}</h3>
                    <p class="product-price">Available for custom bouquets</p>
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #666;">
                <p style="font-size: 1.1rem; margin: 0;">No flowers are listed yet.</p>
                <p style="font-size: 0.9rem; margin-top: 8px;">Add flower products in the database to show them here.</p>
            </div>
        @endforelse
    </div>

    <div class="customize-cta">
        <div>
            <h2>Want a personalized bouquet?</h2>
            <p>Mix and match from our available flowers and tell us your theme, colors, and budget.</p>
        </div>
        <a href="{{ route('customize') }}" class="cta-button">Customize Now</a>
    </div>
</div>

<div class="lightbox" id="flowerLightbox" aria-hidden="true">
    <div class="lightbox-content" role="dialog" aria-modal="true">
        <button class="lightbox-close" type="button" aria-label="Close">&times;</button>
        <img id="flowerLightboxImage" src="" alt="">
        <p id="flowerLightboxTitle"></p>
    </div>
</div>

<script>
    const lightbox = document.getElementById('flowerLightbox');
    const lightboxImage = document.getElementById('flowerLightboxImage');
    const lightboxTitle = document.getElementById('flowerLightboxTitle');
    const closeBtn = lightbox.querySelector('.lightbox-close');

    document.querySelectorAll('.flower-link').forEach(btn => {
        btn.addEventListener('click', () => {
            lightboxImage.src = btn.dataset.image;
            lightboxImage.alt = btn.dataset.title || 'Flower image';
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
