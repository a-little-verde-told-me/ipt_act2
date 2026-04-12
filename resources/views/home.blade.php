@extends('headerfooter')

@section('title', 'Home | FLEUR')

@section('content')
 <section class="hero-section">
  <button class="slider-arrow left" type="button" aria-label="Previous">&lsaquo;</button>

  <div class="hero-content">
    <div class="slide active">
      <img src="{{ asset('images/slide1.jpg') }}" alt="Vibrant Mixed Bouquet">
    </div>
    <div class="slide">
      <img src="{{ asset('images/slide2.jpg') }}" alt="Romantic Rose Bouquet">
    </div>
    <div class="slide">
      <img src="{{ asset('images/slide3.jpg') }}" alt="Spring Mixed Flowers">
    </div>
    <div class="slide">
      <img src="{{ asset('images/slide4.jpg') }}" alt="Luxury Floral Arrangement">
    </div>
    <div class="slide">
      <img src="{{ asset('images/slide5.jpg') }}" alt="Pastel Garden Bouquet">
    </div>
    <div class="slide">
      <img src="{{ asset('images/slide6.jpg') }}" alt="Sunrise Tulip Bundle">
    </div>
  </div>

  <!-- Dark Overlay -->
  <div class="hero-overlay"></div>

  <!-- Welcome Text -->
  <div class="hero-text">
    <h1 style="color: #fff;">Welcome to FLEUR</h1>
    <p>Discover the beauty of fresh flowers and exquisite bouquets</p>
    <a href="{{ route('product') }}" class="hero-cta">Shop Now</a>
  </div>

  <button class="slider-arrow right" type="button" aria-label="Next">&rsaquo;</button>

  <div class="indicators">
    <span class="indicator active"></span>
    <span class="indicator"></span>
    <span class="indicator"></span>
    <span class="indicator"></span>
    <span class="indicator"></span>
    <span class="indicator"></span>
  </div>
</section>


  <section class="featured-section">
    <div class="featured-header">
      <h2 class="featured-title">FEATURED BOUQUETS</h2>
      <p class="featured-subtitle">Handpicked selections for every occasion</p>
    </div>
    <div class="bouquet-grid">
      @forelse($featuredProducts ?? [] as $product)
        <div class="bouquet-card">
          <div class="bouquet-card-inner">
            <div class="bouquet-image-wrapper">
              <img class="bouquet-img" 
                   src="{{ $product->image_url ? asset('images/' . $product->image_url) : asset('images/placeholder.jpg') }}" 
                   alt="{{ $product->name }}">
              <div class="bouquet-overlay">
                <a href="{{ route('product') }}" class="bouquet-cta">View Details</a>
              </div>
            </div>
            <div class="bouquet-info">
              <h3 class="bouquet-name">{{ $product->name }}</h3>
              <p class="bouquet-category">{{ $product->category }}</p>
              <div class="bouquet-footer">
                <span class="bouquet-price">₱{{ number_format($product->price, 2) }}</span>
              </div>
            </div>
          </div>
        </div>
      @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 40px 20px; color: var(--text-muted);">
          <p>Featured bouquets coming soon!</p>
        </div>
      @endforelse
    </div>
  </section>

  <script>
const slides = document.querySelectorAll('.slide');
const indicators = document.querySelectorAll('.indicator');
let currentIndex = 0;

function showSlide(index) {
  slides.forEach((s, i) => s.classList.toggle('active', i === index));
  indicators.forEach((dot, i) => dot.classList.toggle('active', i === index));
}

function nextSlide() {
  currentIndex = (currentIndex + 1) % slides.length;
  showSlide(currentIndex);
}

function prevSlide() {
  currentIndex = (currentIndex - 1 + slides.length) % slides.length;
  showSlide(currentIndex);
}

const autoplayDelay = 2000;
let autoplayTimer = setInterval(nextSlide, autoplayDelay);

const sliderLeft = document.querySelector('.slider-arrow.left');
const sliderRight = document.querySelector('.slider-arrow.right');

if (sliderLeft) {
  sliderLeft.addEventListener('click', () => {
    prevSlide();
    clearInterval(autoplayTimer);
    autoplayTimer = setInterval(nextSlide, autoplayDelay);
  });
}

if (sliderRight) {
  sliderRight.addEventListener('click', () => {
    nextSlide();
    clearInterval(autoplayTimer);
    autoplayTimer = setInterval(nextSlide, autoplayDelay);
  });
}

</script>
@endsection
