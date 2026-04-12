@extends('headerfooter')

@section('title', 'Customize Bouquet | FLEUR')

@section('content')
<div class="customize-page">
    <section class="customize-hero">
        <div class="customize-hero-copy">
            <h1>Customize Your Bouquet</h1>
            <p>Customize your bouquet to match your unique style and preferences.</p>
        </div>
    </section>

    <div class="customize-card">
        <form class="customize-form" action="{{ route('customize.submit') }}" method="post" novalidate>
            @csrf
            <div class="customize-grid">
                <label>
                    <span>Occasion</span>
                    <select id="occasion" name="occasion" required>
                        <option value="">Select an occasion</option>
                        <option value="Birthday">Birthday</option>
                        <option value="Anniversary">Anniversary</option>
                        <option value="Wedding">Wedding</option>
                        <option value="Graduation">Graduation</option>
                        <option value="Just Because">Just Because</option>
                    </select>
                </label>
                <label>
                    <span>Budget Range (PHP)</span>
                    <select id="budget" name="budget" required>
                        <option value="">Choose budget</option>
                        <option value="1000-2000">₱1,000 - ₱2,000</option>
                        <option value="2000-3500">₱2,000 - ₱3,500</option>
                        <option value="3500-5000">₱3,500 - ₱5,000</option>
                        <option value="5000+">₱5,000+</option>
                    </select>
                </label>
            </div>

            <div class="customize-grid">
                <label>
                    <span>Preferred Flowers</span>
                    <input id="flowers" type="text" name="flowers" placeholder="Rose, tulips, sunflower">
                </label>
                <label>
                    <span>Color Palette</span>
                    <input id="colors" type="text" name="colors" placeholder="Blush, white, sage">
                </label>
            </div>

            <label>
                <span>Notes / Theme</span>
                <textarea id="notes" name="notes" rows="4" placeholder="Describe the style you want"></textarea>
            </label>

            <button type="submit" class="submit-btn">Send Custom Request</button>
        </form>
    </div>

    <div class="customize-overlay" id="customizeOverlay" aria-hidden="true">
        <div class="customize-overlay-card" role="alertdialog" aria-modal="true" aria-labelledby="overlayTitle" aria-describedby="overlayDescription">
            <button type="button" class="overlay-close" id="overlayClose" aria-label="Close overlay">×</button>
            <div class="overlay-icon">✓</div>
            <h2 id="overlayTitle">Request Sent</h2>
            <p id="overlayDescription">Your custom bouquet request has been submitted. We’ll review it and get back to you soon.</p>
            <button type="button" class="submit-btn overlay-close-btn" id="overlayCloseBtn">Got it</button>
        </div>
    </div>
</div>

<script>
    const customizeSuccess = {{ json_encode(!empty($success)) }};
    const overlay = document.getElementById('customizeOverlay');
    const overlayClose = document.getElementById('overlayClose');
    const overlayCloseBtn = document.getElementById('overlayCloseBtn');

    function closeOverlay() {
        overlay.classList.remove('open');
        overlay.setAttribute('aria-hidden', 'true');
    }

    if (customizeSuccess && overlay) {
        overlay.classList.add('open');
        overlay.setAttribute('aria-hidden', 'false');
    }

    if (overlayClose) overlayClose.addEventListener('click', closeOverlay);
    if (overlayCloseBtn) overlayCloseBtn.addEventListener('click', closeOverlay);
    if (overlay) overlay.addEventListener('click', (e) => {
        if (e.target === overlay) closeOverlay();
    });
</script>
@endsection
