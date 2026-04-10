<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FLEUR')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>

    <header>
    <a href="{{ route('home') }}" class="logo">
        <img src="{{ asset('images/fleur_logo.png') }}" alt="FLEUR logo" class="logo-img">
        <span>FLEUR</span>
    </a>
    <nav class="nav-links">
         <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active-link' : '' }}">Home</a>
            <a href="{{ route('flowers') }}" class="{{ request()->routeIs('flowers') ? 'active-link' : '' }}">Flowers</a>
            <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active-link' : '' }}">About</a>
            <a href="{{ route('gallery') }}" class="{{ request()->routeIs('gallery') ? 'active-link' : '' }}">Gallery</a>
            <a href="{{ route('product') }}" class="{{ request()->routeIs('product') ? 'active-link' : '' }}">Products</a>
            <a href="{{ route('cart') }}" class="{{ request()->routeIs('cart') ? 'active-link' : '' }}">Cart</a>
            <!-- <a href="{{ route('search') }}" class="{{ request()->routeIs('search') ? 'active-link' : '' }}">Search</a> -->
            <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active-link' : '' }}">Contact Us</a>
            <!-- <a href="{{ route('filter') }}" class="{{ request()->routeIs('filter') ? 'active-link' : '' }}">Filter</a> -->
            <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'active-link' : '' }}">Login</a>
    </nav>
     
  </header>


    <main>
        {{-- This is where the Home or About content will be injected --}}
        @yield('content')
    </main>

    {{-- You can add a footer here later --}}
    <footer>
        <p>&copy; 2026 FLEUR Flower Shop</p>
    </footer>

</body>
</html>
