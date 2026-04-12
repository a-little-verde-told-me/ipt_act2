<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'FLEUR')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
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
            <a href="{{ route('gallery') }}" class="{{ request()->routeIs('gallery') ? 'active-link' : '' }}">Gallery</a>
            <a href="{{ route('product') }}" class="{{ request()->routeIs('product') ? 'active-link' : '' }}">Products</a>
            <a href="{{ route('services') }}" class="{{ request()->routeIs('services') ? 'active-link' : '' }}">Services</a>
            <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active-link' : '' }}">About</a>
            <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active-link' : '' }}">Contact Us</a>
            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.*') ? 'active-link' : '' }}">Admin</a>
                @endif
            @endauth
    </nav>
    <div class="header-actions">
        <a href="{{ route('cart') }}" class="cart-icon" title="Cart">
            <i class="fa-solid fa-shopping-cart"></i>
            <span class="cart-badge" id="cartCount">0</span>
        </a>
        @auth
            <a href="{{ route('profile') }}" class="profile-icon" title="Profile">
                <i class="fa-solid fa-user"></i>
            </a>
        @else
            <a href="{{ route('login') }}" class="login-btn {{ request()->routeIs('login') ? 'active-link' : '' }}">Login</a>
        @endauth
    </div>
  </header>


    <main>
        {{-- This is where the Home or About content will be injected --}}
        @yield('content')
    </main>

    {{-- You can add a footer here later --}}
    <footer>
        <p>&copy; 2026 FLEUR Flower Shop</p>
    </footer>

<script>
    const clearCartOnLogout = "{{ session('clear_cart', false) }}" === "1";
    const isAuthenticated = "{{ Auth::check() }}" === "1";

    function initCartHeader() {
        function getCartCount() {
            if (!isAuthenticated) return 0;

            fetch('{{ route("api.cart.count") }}', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                updateCartBadge(data.count || 0);
            })
            .catch(error => {
                console.error('Error getting cart count:', error);
                updateCartBadge(0);
            });
            return 0;
        }

        function updateCartBadge(count) {
            const badge = document.getElementById('cartCount');
            if (!badge) return;
            badge.textContent = count;
            badge.style.display = count > 0 ? 'inline-flex' : 'none';
        }

        window.updateCartBadge = updateCartBadge;
        window.refreshCartCount = getCartCount;

        getCartCount();
        setTimeout(getCartCount, 100);
        setTimeout(getCartCount, 400);
        setTimeout(getCartCount, 800);
        window.addEventListener('load', getCartCount);
        window.addEventListener('DOMContentLoaded', getCartCount);
        window.addEventListener('cart-updated', getCartCount);

        if (clearCartOnLogout) {
            updateCartBadge(0);
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCartHeader);
    } else {
        initCartHeader();
    }
</script>
</body>
</html>
