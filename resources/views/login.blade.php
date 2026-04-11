@extends('headerfooter')

@section('title', 'Login | FLEUR')

@section('content')
<div class="auth-page auth-page-login">
    <div class="auth-card">
        <h1>Login</h1>
        <form class="auth-form auth-form-single" action="{{ route('login.submit') }}" method="post" novalidate autocomplete="off">
            @csrf

            @if(session('error'))
                <p class="form-error">{{ session('error') }}</p>
            @endif
            @if(session('success'))
                <p class="form-success">{{ session('success') }}</p>
            @endif
            @if($errors->any())
                <div class="form-error">Please fix the errors below.</div>
            @endif

            <label for="loginIdentifier">Email or Username</label>
            <input id="loginIdentifier" type="text" name="login" value="{{ old('login') }}" autocomplete="off" required minlength="5" maxlength="50"
                   pattern="(^[A-Za-z][A-Za-z0-9_]{4,14}$)|(^[^\s@]+@[^\s@]+\.[^\s@]+$)"
                   title="Enter a valid email address or username (5-15 chars, start with a letter, letters/numbers/underscore only).">
            @error('login') <p class="field-error">{{ $message }}</p> @enderror

            <label for="loginPassword">Password</label>
            <div class="password-field">
                <input id="loginPassword" type="password" name="password" autocomplete="off" required minlength="8" maxlength="20"
                       title="Enter your password. Admin may use admin123.">
                <button type="button" class="password-toggle" data-target="loginPassword" aria-label="Show password">
                </button>
            </div>
            @error('password') <p class="field-error">{{ $message }}</p> @enderror

            <div class="full-width-actions login-actions">
                <button type="submit" class="submit-btn" style="display: block; margin-right: auto; margin-left: 0; width: fit-content;">Sign In</button>
                <p class="auth-switch">Don't have an account yet? <a href="{{ route('registration') }}">Register here</a></p>
            </div>
        </form>
    </div>
</div>

<script>
    const loginForm = document.querySelector('.auth-form');
    loginForm.addEventListener('submit', (e) => {
        if (!loginForm.reportValidity()) {
            e.preventDefault();
        }
    });

    function initLoginPasswordToggle() {
        const eyeOpenSvg = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">' +
            '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>' +
            '<circle cx="12" cy="12" r="3"/>' +
            '</svg>';
        const eyeClosedSvg = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">' +
            '<path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8 1.16-2.5 2.84-4.71 4.86-6.37"/>' +
            '<path d="M1 1l22 22"/>' +
            '<path d="M9.88 9.88a3 3 0 0 0 4.24 4.24"/>' +
            '</svg>';

        document.querySelectorAll('.password-toggle').forEach(button => {
            button.addEventListener('click', () => {
                const target = document.getElementById(button.dataset.target);
                if (!target) return;
                const isPassword = target.type === 'password';
                target.type = isPassword ? 'text' : 'password';
                button.setAttribute('aria-label', isPassword ? 'Hide password' : 'Show password');
                button.innerHTML = isPassword ? eyeClosedSvg : eyeOpenSvg;
            });
        });
    }

    initLoginPasswordToggle();
</script>
@endsection
