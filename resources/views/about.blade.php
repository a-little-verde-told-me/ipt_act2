@extends('headerfooter')

@section('title', 'About Us | FLEUR')

@section('content')
<div class="about-page">
    <div class="about-hero">
        <div class="about-hero-text">
            <h1>ABOUT FLEUR</h1>
            <p>FLEUR is a startup flower shop specializing in curated bouquets, event styling, and thoughtful gifts. We blend modern floral design with warm, local service to make every celebration bloom.</p>
        </div>
        <div class="about-hero-image">
            <img src="{{ asset('images/founder.jpg') }}" alt="Founder">
        </div>
    </div>

    <div class="about-section">
        <h2>The Heart Behind Fleur</h2>
        <p>We didn't just want to build another website; we wanted to create a place where emotions actually get delivered. Fleur started as a small idea between friends who realized that sending flowers often feels like a cold, automated transaction. We believe that when you send a bouquet, you're sending a piece of your heart, so we built this startup to make that connection feel a lot more personal and a lot less like a chore.</p>
    </div>

    <div class="about-section">
        <h2>Why "Fleur"?</h2>
        <p>People often ask us why we went with such a simple name. In French, Fleur just means flower. We chose it because we didn't want to hide behind a flashy brand name. We wanted the focus to stay on the raw, natural beauty of the blooms themselves. It's a nod to classic elegance, but with a modern twist that fits right into our digital world.</p>
    </div>

    <div class="about-section">
        <h2>Our Promise to You</h2>
        <p>As a startup, we're obsessed with the details. Whether it's the way we validate your order form to make sure your message is perfect, or the way we source our flowers to ensure they last, we put our souls into every part of this system. We're here to help you celebrate the big wins, the "just because" moments, and everything in between.</p>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const aboutZoomTrigger = document.getElementById('aboutZoomTrigger');
        const aboutZoomOverlay = document.getElementById('aboutZoomOverlay');
        const aboutZoomClose = aboutZoomOverlay?.querySelector('.zoom-close');

        if (aboutZoomTrigger && aboutZoomOverlay) {
            aboutZoomTrigger.addEventListener('click', () => {
                aboutZoomOverlay.classList.add('open');
                aboutZoomOverlay.setAttribute('aria-hidden', 'false');
            });

            const closeOverlay = () => {
                aboutZoomOverlay.classList.remove('open');
                aboutZoomOverlay.setAttribute('aria-hidden', 'true');
            };

            aboutZoomClose?.addEventListener('click', closeOverlay);
            aboutZoomOverlay.addEventListener('click', (event) => {
                if (event.target === aboutZoomOverlay) closeOverlay();
            });
            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && aboutZoomOverlay.classList.contains('open')) {
                    closeOverlay();
                }
            });
        }
    });
</script>
@endsection
