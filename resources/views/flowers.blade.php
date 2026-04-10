@extends('headerfooter')

@section('title', 'Our Flowers | FLEUR')

@section('content')
<div class="products-page">
    <h1 class="page-title">FLOWERS</h1>

    <div class="search-section">
        <div class="search-bar">
            <span class="search-icon" aria-hidden="true"><i class="fa-solid fa-magnifying-glass"></i></span>
            <input type="text" placeholder="Search flowers..." id="flowerSearch">
        </div>
    </div>

    <div class="products-grid">
        @php
            // Replace the filenames with your images in public/images
            $flowers = [ 
                ['image' => 'flower1.jpg', 'name' => 'Cosmos'],
                ['image' => 'flower2.jpg', 'name' => 'Indian Paintbrush'],
                ['image' => 'flower3.jpg', 'name' => 'Bluebonnet'],
                ['image' => 'flower4.jpg', 'name' => 'Wild Bergamot'],
                ['image' => 'flower5.jpg', 'name' => 'Dahlia'],
                ['image' => 'flower6.jpg', 'name' => 'Zinnia'],
                ['image' => 'flower7.jpg', 'name' => 'Ranunculus'],
                ['image' => 'flower8.jpg', 'name' => 'Larkspur'],
                ['image' => 'flower9.jpg', 'name' => 'Chrysanthemum'],
                ['image' => 'flower10.jpg', 'name' => 'Anemone'],
                ['image' => 'flower11.jpg', 'name' => 'Celosia'],
                ['image' => 'flower12.jpg', 'name' => 'Gladiolus'],
                ['image' => 'flower13.jpg', 'name' => 'Gomphrena'],
                ['image' => 'flower14.jpg', 'name' => 'Sunflower'],
                ['image' => 'flower15.jpg', 'name' => 'Craspedia'],
                ['image' => 'flower16.jpg', 'name' => 'Gerbera Daisy'],
                ['image' => 'flower17.jpg', 'name' => 'Snapdragon'],
                ['image' => 'flower18.jpg', 'name' => 'Bells of Ireland'],
                ['image' => 'flower19.jpg', 'name' => 'Stock'],
                ['image' => 'flower20.jpg', 'name' => 'Strawflower'],
                ['image' => 'flower21.jpg', 'name' => 'Nigella'],
                ['image' => 'flower22.jpg', 'name' => 'Morning Glory'],
                ['image' => 'flower23.jpg', 'name' => 'Lobelia'],
                ['image' => 'flower24.jpg', 'name' => 'Verbena'],
                ['image' => 'flower25.jpg', 'name' => 'Dusty Miller'],
                ['image' => 'flower26.jpg', 'name' => 'Sweet Alyssum'],
                ['image' => 'flower27.jpg', 'name' => 'Browallia'],
                ['image' => 'flower28.jpg', 'name' => 'Torenia'],
                ['image' => 'flower29.jpg', 'name' => 'Gazania'],
                ['image' => 'flower30.jpg', 'name' => 'Nicotiana'],
                ['image' => 'flower31.jpg', 'name' => 'Nasturtium'],
                ['image' => 'flower32.jpg', 'name' => 'Alyssum'],
            ];
        @endphp

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
    const flowerCards = document.querySelectorAll('.product-card');

    function filterFlowers(query) {
        const q = query.trim().toLowerCase();
        flowerCards.forEach(card => {
            const name = card.dataset.name || '';
            card.style.display = name.includes(q) ? 'block' : 'none';
        });
    }

    searchInput.addEventListener('input', () => {
        filterFlowers(searchInput.value);
    });

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
