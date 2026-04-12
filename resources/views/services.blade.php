@extends('headerfooter')

@section('title', 'Services | FLEUR')

@section('content')
<div class="services-page">
    <h1 style="color: #8a3a45; font-size: 2.5rem;">SERVICES</h1>

    <div class="services-grid">
        <!-- Flower Delivery Service -->
        <div class="service-card">
            <div class="service-image">
                <img src="{{ asset('images/services/flower-delivery.jpg') }}" alt="Flower Delivery Service">
            </div>
            <div class="service-content">
                <h2>Flower Delivery</h2>
                <p>Experience the joy of receiving fresh, beautiful flowers right at your doorstep. Our reliable delivery service ensures your floral arrangements arrive on time, every time.</p>
                <ul class="service-features">
                    <li>Same-day delivery available</li>
                    <li>Nationwide coverage</li>
                    <li>Real-time tracking</li>
                    <li>Careful handling guaranteed</li>
                </ul>
                <div class="service-price">
                    <span>Starting from ₱150</span>
                </div>
            </div>
        </div>

        <!-- Customized Flower Bouquet Service -->
        <div class="service-card">
            <div class="service-image">
                <img src="{{ asset('images/services/customized-bouquets.jpg') }}" alt="Customized Flower Bouquet">
            </div>
            <div class="service-content">
                <h2>Customized Flower Bouquet</h2>
                <p>Create a one-of-a-kind floral masterpiece tailored to your special occasion. Our expert florists work with you to design the perfect arrangement using premium flowers and your personal preferences.</p>
                <ul class="service-features">
                    <li>Personal consultation</li>
                    <li>Wide variety of flowers</li>
                    <li>Custom color schemes</li>
                    <li>Size and style options</li>
                </ul>
                <div class="service-price">
                    <span>Starting from ₱500</span>
                </div>
            </div>
        </div>

        <!-- Event Arrangements Service -->
        <div class="service-card">
            <div class="service-image">
                <img src="{{ asset('images/services/event-arrangement.jpg') }}" alt="Event Flower Arrangements">
            </div>
            <div class="service-content">
                <h2>Event Arrangements</h2>
                <p>Transform any occasion into a memorable experience with our professional event floral services. From intimate gatherings to grand celebrations, we provide complete floral styling and setup.</p>
                <ul class="service-features">
                    <li>Weddings and ceremonies</li>
                    <li>Birthday parties</li>
                    <li>Corporate functions</li>
                    <li>Professional setup and teardown</li>
                </ul>
                <div class="service-price">
                    <span>Contact for quote</span>
                </div>
            </div>
        </div>
    </div>

    <div class="services-cta">
        <h2>Ready to Get Started?</h2>
        <p>Contact us today to discuss your floral needs and create something beautiful together.</p>
        <a href="{{ route('contact') }}" class="cta-btn">Get in Touch</a>
    </div>
</div>

<style>
    .services-page {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .services-page h1 {
        text-align: center;
        font-size: 2.5rem;
        color: var(--text-dark);
        margin-bottom: 40px;
        font-family: 'Playfair Display', serif;
    }

    .services-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-bottom: 60px;
    }

    .service-card {
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .service-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
    }

    .service-image {
        height: 200px;
        overflow: hidden;
    }

    .service-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .service-card:hover .service-image img {
        transform: scale(1.05);
    }

    .service-content {
        padding: 24px;
    }

    .service-content h2 {
        font-size: 1.5rem;
        color: var(--accent-rose);
        margin-bottom: 12px;
        font-family: 'Playfair Display', serif;
    }

    .service-content p {
        color: var(--text-muted);
        line-height: 1.6;
        margin-bottom: 16px;
    }

    .service-features {
        list-style: none;
        padding: 0;
        margin-bottom: 20px;
    }

    .service-features li {
        color: var(--text-dark);
        margin-bottom: 6px;
        padding-left: 20px;
        position: relative;
    }

    .service-features li::before {
        content: '✓';
        color: var(--accent-rose);
        font-weight: bold;
        position: absolute;
        left: 0;
    }

    .service-price {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--accent-rose);
    }

    .services-cta {
        text-align: center;
        background: linear-gradient(135deg, #f8f5f2 0%, #f0ece9 100%);
        padding: 40px 20px;
        border-radius: 16px;
        margin-top: 40px;
    }

    .services-cta h2 {
        font-size: 2rem;
        color: var(--text-dark);
        margin-bottom: 12px;
        font-family: 'Playfair Display', serif;
    }

    .services-cta p {
        color: var(--text-muted);
        margin-bottom: 24px;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
    }

    .cta-btn {
        display: inline-block;
        background: var(--accent-rose);
        color: #fff;
        padding: 14px 28px;
        border-radius: 999px;
        text-decoration: none;
        font-weight: 600;
        transition: background 0.3s ease, transform 0.3s ease;
    }

    .cta-btn:hover {
        background: #8a3a45;
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .services-grid {
            grid-template-columns: 1fr;
        }

        .services-page h1 {
            font-size: 2rem;
        }

        .service-content h2 {
            font-size: 1.3rem;
        }
    }
</style>
@endsection
