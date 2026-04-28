<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'FLEUR Admin')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body class="admin-body">
    <div class="admin-shell">
        <header class="admin-topbar">
            <div class="admin-brand">
                <a href="{{ route('admin.dashboard') }}">FLEUR Admin</a>
            </div>
            <nav class="admin-nav">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active-link' : '' }}">Dashboard</a>
                <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active-link' : '' }}">Products</a>
                <a href="{{ route('admin.flowers.index') }}" class="{{ request()->routeIs('admin.flowers.*') ? 'active-link' : '' }}">Flowers</a>
                <a href="{{ route('admin.events.index') }}" class="{{ request()->routeIs('admin.events.*') ? 'active-link' : '' }}">Events</a>
                <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active-link' : '' }}">Orders</a>
            </nav>
            <div class="admin-actions">
                <form action="{{ route('logout') }}" method="post" class="inline-form">
                    @csrf
                    <button type="submit" class="btn btn-secondary">Logout</button>
                </form>
            </div>
        </header>

        <main class="admin-main">
            @yield('content')
        </main>
    </div>
</body>
</html>
