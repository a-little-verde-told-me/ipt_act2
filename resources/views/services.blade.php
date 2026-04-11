@extends('headerfooter')

@section('title', 'Services | FLEUR')

@section('content')
<div class="services-page">
    <section class="services-hero">
        <h1>Our Services</h1>
        <p>From curated bouquets to fully custom arrangements, we design florals that fit your story and budget.</p>
    </section>

    <div class="services-grid">
        <div class="service-card">
            <h3>Custom Bouquet Design</h3>
            <p>Choose flowers, colors, and style. We arrange a one-of-a-kind bouquet just for you.</p>
        </div>
        <div class="service-card">
            <h3>Event Styling</h3>
            <p>Weddings, birthdays, corporate events — we handle full floral styling and venue setup.</p>
        </div>
        <div class="service-card">
            <h3>Same-Day Orders</h3>
            <p>Need flowers today? Ask about same-day delivery in selected areas.</p>
        </div>
        <div class="service-card">
            <h3>Seasonal Collections</h3>
            <p>Hand-picked flowers for holidays and special occasions, refreshed every season.</p>
        </div>
        <div class="service-card">
            <h3>Gift Add-ons</h3>
            <p>Include handwritten cards, ribbons, or chocolates to complete the gift.</p>
        </div>
        <div class="service-card">
            <h3>Corporate Arrangements</h3>
            <p>Weekly office refresh or lobby arrangements with flexible plans.</p>
        </div>
    </div>

    <div class="customize-cta">
        <div>
            <h2>Ready to customize?</h2>
            <p>Tell us your preferred flowers, colors, and budget. We’ll send recommendations.</p>
        </div>
        <a href="{{ route('customize') }}" class="cta-button">Start Customizing</a>
    </div>
</div>
@endsection
