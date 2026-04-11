 <DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FLEUR “ Fresh Flowers for Everyone</title>
  <link rel="stylesheet" href="/css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
  <header>
    <a href="{{ route('home') }}" class="logo">
        <img src="{{ asset('images/fleur_logo.png') }}" alt="FLEUR logo" class="logo-img">
        <span style="font-family: 'Playfair Display', serif; font-weight: 700; color: var(--accent-rose);">FLEUR</span>
    </a>
    <nav class="nav-links">
         <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active-link' : '' }}">Home</a>
            <a href="{{ route('flowers') }}" class="{{ request()->routeIs('flowers') ? 'active-link' : '' }}">Flowers</a>
            <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active-link' : '' }}">About</a>
            <a href="{{ route('gallery') }}" class="{{ request()->routeIs('gallery') ? 'active-link' : '' }}">Gallery</a>
            <a href="{{ route('product') }}" class="{{ request()->routeIs('product') ? 'active-link' : '' }}">Products</a>
            <a href="{{ route('cart') }}" class="{{ request()->routeIs('cart') ? 'active-link' : '' }}">Cart</a>
            <a href="{{ route('search') }}" class="{{ request()->routeIs('search') ? 'active-link' : '' }}">Search</a>
            <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active-link' : '' }}">Contact Us</a>
            <a href="{{ route('filter') }}" class="{{ request()->routeIs('filter') ? 'active-link' : '' }}">Filter</a>
            <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'active-link' : '' }}">Login</a>
    </nav>
     
  </header>

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
    <div class="featured-title">FEATURED BOUQUETS</div>
    <div class="bouquet-grid">
      <div class="bouquet-card"><img class="bouquet-img" src="{{ asset('images/pink_delight.jpg') }}" alt="Product Image"><div class="bouquet-name">Pink Delight</div></div>
      <div class="bouquet-card"><img class="bouquet-img" src="{{ asset('images/white_rose.jpg') }}" alt="Product Image"><div class="bouquet-name">White Rose</div></div>
      <div class="bouquet-card"><img class="bouquet-img" src="{{ asset('images/rosy_charm.jpg') }}" alt="Product Image"><div class="bouquet-name">Rosy Charm</div></div>
      <div class="bouquet-card"><img class="bouquet-img" src="{{ asset('images/sweet_petals.jpg') }}" alt="Product Image"><div class="bouquet-name">Sweet Petals Bouquet</div></div>
    </div>
    <a href="{{ route('product') }}" class="shop-now">Shop Now</a>
  </section>

  <footer>&copy; 2026 Fleur. All rights reserved.</footer>

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

document.querySelector('.slider-arrow.left').addEventListener('click', () => {
  prevSlide();
});

document.querySelector('.slider-arrow.right').addEventListener('click', () => {
  nextSlide();
});

</script>

</body>
</html>
