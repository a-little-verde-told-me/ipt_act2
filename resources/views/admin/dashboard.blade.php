@extends('admin.layout')

@section('title', 'Admin Dashboard | FLEUR')

@section('content')
<div class="admin-page">
    <div class="admin-header">
        <div>
            <h1>Admin Dashboard</h1>
            <p class="admin-page-header">Access product, flower, and event management tools from a simplified dashboard designed for admin workflow.</p>
        </div>
    </div>

    <div class="admin-dashboard-grid">
        <a href="{{ route('admin.products.index') }}" class="admin-card">
            <h2>Products</h2>
            <p>Manage your product catalog: add, edit, and remove products quickly.</p>
        </a>
        <a href="{{ route('admin.flowers.index') }}" class="admin-card">
            <h2>Flowers</h2>
            <p>Keep your flower inventory updated with new arrivals and fresh images.</p>
        </a>
        <a href="{{ route('admin.events.index') }}" class="admin-card">
            <h2>Events</h2>
            <p>Control event entries and update event visuals from one place.</p>
        </a>
    </div>
</div>
@endsection
