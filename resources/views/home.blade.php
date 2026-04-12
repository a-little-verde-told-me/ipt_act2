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
    <h1>Welcome to FLEUR</h1>
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
    <div class="featured-title" style="font-family: 'Playfair Display', serif; font-weight: 700; color: var(--accent-rose);">FEATURED BOUQUETS</div>
    <div class="bouquet-grid">
      <div class="bouquet-card"><img class="bouquet-img" src="{{ asset('images/products/pink-delight-bouquet.jpg') }}" alt="Product Image"><div class="bouquet-name">Pink Delight Bouquet</div></div>
      <div class="bouquet-card"><img class="bouquet-img" src="{{ asset('images/products/white-rose-bouquet.jpg') }}" alt="Product Image"><div class="bouquet-name">White Rose Bouquet</div></div>
      <div class="bouquet-card"><img class="bouquet-img" src="{{ asset('images/products/rosy-charm-bouquet.jpg') }}" alt="Product Image"><div class="bouquet-name">Rosy Charm Bouquet</div></div>
      <div class="bouquet-card"><img class="bouquet-img" src="{{ asset('images/products/sweet-petals-bouquet.jpg') }}" alt="Product Image"><div class="bouquet-name">Sweet Petals Bouquet</div></div>

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
