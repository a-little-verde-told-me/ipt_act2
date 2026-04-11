@extends('headerfooter')

@section('title', 'Home | FLEUR')

@section('content')
 <section class="hero-section">
  <button class="slider-arrow left" type="button" aria-label="Previous">&lsaquo;</button>

  <div class="hero-content">
    <div class="slide active">
      <img src="{{ asset('images/slide1.png') }}" alt="Vibrant Mixed Bouquet">
    </div>
    <div class="slide">
      <img src="{{ asset('images/slide2.png') }}" alt="Romantic Rose Bouquet">
    </div>
    <div class="slide">
      <img src="{{ asset('images/slide3.png') }}" alt="Spring Mixed Flowers">
    </div>
    <div class="slide">
      <img src="{{ asset('images/slide4.png') }}" alt="Luxury Floral Arrangement">
    </div>
    <div class="slide">
      <img src="{{ asset('images/slide5.png') }}" alt="Pastel Garden Bouquet">
    </div>
    <div class="slide">
      <img src="{{ asset('images/slide6.png') }}" alt="Sunrise Tulip Bundle">
    </div>
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
      <div class="bouquet-card"><img class="bouquet-img" src="images/pink_delight.jpg" alt="Product Image"><div class="bouquet-name">Pink Delight Bouquet</div></div>
      <div class="bouquet-card"><img class="bouquet-img" src="images/white_rose.jpg" alt="Product Image"><div class="bouquet-name">White Rose Bouquet</div></div>
      <div class="bouquet-card"><img class="bouquet-img" src="images/rosy_charm.jpg" alt="Product Image"><div class="bouquet-name">Rosy Charm Bouquet</div></div>
      <div class="bouquet-card"><img class="bouquet-img" src="images/sweet_petals.jpg" alt="Product Image"><div class="bouquet-name">Sweet Petals Bouquet</div></div>
    </div>
    <a href="{{ route('product') }}" class="shop-now">Shop Now</a>
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
