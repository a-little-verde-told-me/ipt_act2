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
        <form class="customize-form" action="{{ route('customize.submit') }}" method="post">
            @csrf
            @if ($errors->any())
                <div class="form-error">Please fill in all required fields. Missing fields are highlighted below.</div>
            @endif
            <div class="customize-grid">
                <label class="{{ $errors->has('occasion') ? 'invalid' : '' }}">
                    <span>Occasion</span>
                    <select id="occasion" name="occasion" required>
                        <option value="" {{ old('occasion') ? '' : 'selected' }}>Select an occasion</option>
                        <option value="Birthday" {{ old('occasion') == 'Birthday' ? 'selected' : '' }}>Birthday</option>
                        <option value="Anniversary" {{ old('occasion') == 'Anniversary' ? 'selected' : '' }}>Anniversary</option>
                        <option value="Wedding" {{ old('occasion') == 'Wedding' ? 'selected' : '' }}>Wedding</option>
                        <option value="Graduation" {{ old('occasion') == 'Graduation' ? 'selected' : '' }}>Graduation</option>
                        <option value="Just Because" {{ old('occasion') == 'Just Because' ? 'selected' : '' }}>Just Because</option>
                    </select>
                    @error('occasion')<span class="field-error">{{ $message }}</span>@enderror
                </label>
                <label class="{{ $errors->has('budget') ? 'invalid' : '' }}">
                    <span>Budget Range (PHP)</span>
                    <select id="budget" name="budget" required>
                        <option value="" {{ old('budget') ? '' : 'selected' }}>Choose budget</option>
                        <option value="1000-2000" {{ old('budget') == '1000-2000' ? 'selected' : '' }}>₱1,000 - ₱2,000</option>
                        <option value="2000-3500" {{ old('budget') == '2000-3500' ? 'selected' : '' }}>₱2,000 - ₱3,500</option>
                        <option value="3500-5000" {{ old('budget') == '3500-5000' ? 'selected' : '' }}>₱3,500 - ₱5,000</option>
                        <option value="5000+" {{ old('budget') == '5000+' ? 'selected' : '' }}>₱5,000+</option>
                    </select>
                    @error('budget')<span class="field-error">{{ $message }}</span>@enderror
                </label>
            </div>

            <div class="customize-grid">
                <label class="{{ $errors->has('flowers') ? 'invalid' : '' }}">
                    <span>Preferred Flowers</span>
                    <input id="flowers" type="text" name="flowers" placeholder="Rose, tulips, sunflower" value="{{ old('flowers') }}" required>
                    @error('flowers')<span class="field-error">{{ $message }}</span>@enderror
                </label>
                <label class="{{ $errors->has('colors') ? 'invalid' : '' }}">
                    <span>Color Palette</span>
                    <input id="colors" type="text" name="colors" placeholder="Blush, white, sage" value="{{ old('colors') }}" required>
                    @error('colors')<span class="field-error">{{ $message }}</span>@enderror
                </label>
            </div>

            <label class="{{ $errors->has('notes') ? 'invalid' : '' }}">
                <span>Notes / Theme</span>
                <textarea id="notes" name="notes" rows="4" placeholder="Describe the style you want">{{ old('notes') }}</textarea>
                @error('notes')<span class="field-error">{{ $message }}</span>@enderror
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

    <div class="login-required-overlay" id="loginRequiredOverlay" style="display: none;">
        <div class="login-required-card">
            <div class="login-required-icon">🔒</div>
            <h2>Login Required</h2>
            <p>Please login to send a custom request.</p>
            <div class="login-required-actions">
                <a href="{{ route('login') }}" class="login-required-btn btn-primary">Login</a>
                <button type="button" class="login-required-btn btn-secondary" id="cancelLoginBtn">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
    const customizeSuccess = {{ json_encode(!empty($success)) }};
    const loginRequired = {{ json_encode(session('customize_login_required', false)) }};
    const isAuthenticated = {{ auth()->check() ? 'true' : 'false' }};
    const overlay = document.getElementById('customizeOverlay');
    const overlayClose = document.getElementById('overlayClose');
    const overlayCloseBtn = document.getElementById('overlayCloseBtn');
    const loginOverlay = document.getElementById('loginRequiredOverlay');
    const cancelLoginBtn = document.getElementById('cancelLoginBtn');
    const customizeForm = document.querySelector('.customize-form');

    function closeOverlay() {
        overlay.classList.remove('open');
        overlay.setAttribute('aria-hidden', 'true');
    }

    function showLoginOverlay() {
        if (loginOverlay) {
            loginOverlay.style.display = 'flex';
        }
    }

    function hideLoginOverlay() {
        if (loginOverlay) {
            loginOverlay.style.display = 'none';
        }
    }

    if (customizeSuccess && overlay) {
        overlay.classList.add('open');
        overlay.setAttribute('aria-hidden', 'false');
    }

    if (loginRequired && !isAuthenticated) {
        showLoginOverlay();
    }

    if (customizeForm) {
        customizeForm.addEventListener('submit', (event) => {
            if (!isAuthenticated) {
                event.preventDefault();
                showLoginOverlay();
            }
        });
    }

    if (overlayClose) overlayClose.addEventListener('click', closeOverlay);
    if (overlayCloseBtn) overlayCloseBtn.addEventListener('click', closeOverlay);
    if (cancelLoginBtn) cancelLoginBtn.addEventListener('click', hideLoginOverlay);
    if (overlay) overlay.addEventListener('click', (e) => {
        if (e.target === overlay) closeOverlay();
    });
    if (loginOverlay) loginOverlay.addEventListener('click', (e) => {
        if (e.target === loginOverlay) hideLoginOverlay();
    });
</script>
@endsection
