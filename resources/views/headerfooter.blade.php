<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FLEUR')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>

    <header>
        <nav class="navbar">
            <div class="logo">FLEUR</div>
            <ul class="nav-links">
                {{-- Laravel checks the current route to apply your 10% Rose accent color --}}
                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active-link' : '' }}">Home</a></li>
                <li><a href="{{ route('flowers') }}" class="{{ request()->routeIs('flowers') ? 'active-link' : '' }}">Flowers</a></li>
                <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active-link' : '' }}">About</a></li>
                <li><a href="{{ route('gallery') }}" class="{{ request()->routeIs('gallery') ? 'active-link' : '' }}">Gallery</a></li>
                <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active-link' : '' }}">Contact Us</a></li>
            </ul>
            <button class="login-btn">Login</button>
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