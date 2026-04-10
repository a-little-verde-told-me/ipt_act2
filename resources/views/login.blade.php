@extends('headerfooter')

@section('title', 'Login | FLEUR')

@section('content')
<div class="auth-page">
    <div class="auth-card">
        <h1>Login</h1>
        <form class="auth-form" action="{{ route('login.submit') }}" method="post" novalidate>
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
            <input id="loginIdentifier" type="text" name="login" value="{{ old('login') }}" required minlength="5" maxlength="50"
                   pattern="(^[A-Za-z][A-Za-z0-9_]{4,14}$)|(^[^\s@]+@[^\s@]+\.[^\s@]+$)"
                   title="Enter a valid email address or username (5-15 chars, start with a letter, letters/numbers/underscore only).">
            @error('login') <p class="field-error">{{ $message }}</p> @enderror

            <label for="loginPassword">Password</label>
            <input id="loginPassword" type="password" name="password" required minlength="8" maxlength="20"
                   title="Enter your password. Admin may use admin123.">
            @error('password') <p class="field-error">{{ $message }}</p> @enderror

            <div class="flex justify-center">
                <button type="submit" class="submit-btn mx-auto">Sign In</button>
            </div>
            <p class="text-center mt-4 text-sm text-gray-700">
                Don't have an account yet? <a href="{{ route('registration') }}" class="text-rose-700 hover:underline">Register here</a>
            </p>
        </form>

        <div class="form-notes">
            <h3>Login Notes</h3>
            <ul>
                <li>Email is required and must be valid, or use your username.</li>
                <li>Username: 5-15 chars, starts with letter, letters/numbers/underscore only.</li>
                <li>Password: 8-20 chars for regular members. Admin may use <strong>admin123</strong>.</li>
                <li>Admin account: <strong>admin@gmail.com</strong> / <strong>admin123</strong>.</li>
            </ul>
        </div>
    </div>
</div>

<script>
    const loginForm = document.querySelector('.auth-form');
    loginForm.addEventListener('submit', (e) => {
        if (!loginForm.reportValidity()) {
            e.preventDefault();
        }
    });
</script>
@endsection
