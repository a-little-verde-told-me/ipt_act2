@extends('headerfooter')

@section('title', 'Login | FLEUR')

@section('content')
<div class="auth-page">
    <div class="auth-card">
        <h1>Login</h1>
        <form class="auth-form" action="{{ route('login.submit') }}" method="post" novalidate>
            @csrf
            @if($errors->any())
                <p style="color:#a64452; font-weight:600; margin-bottom:10px;">{{ $errors->first() }}</p>
            @endif
            <label for="loginEmail">Email</label>
            <input id="loginEmail" type="email" name="email" required>

            <label for="loginUsername">Username</label>
            <input id="loginUsername" type="text" name="username" required minlength="5" maxlength="15"
                   pattern="^[A-Za-z][A-Za-z0-9_]{4,14}$"
                   title="5-15 chars, start with a letter, letters/numbers/underscore only">

            <label for="loginPassword">Password</label>
            <input id="loginPassword" type="password" name="password" required minlength="8" maxlength="20"
                   pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*\\d)(?=.*[^A-Za-z0-9\\s;'&quot;/\\\\])[^\\s;'&quot;/\\\\]{8,20}$"
                   title="8-20 chars, at least 1 uppercase, 1 lowercase, 1 number, 1 special, no spaces, no ; ' / \">

            <div class="flex justify-center">
                <button type="submit" class="submit-btn mx-auto">Sign In</button>
            </div>
            <p class="text-center mt-4 text-sm text-gray-700">
                Don't have an account yet? <a href="{{ route('registration') }}" class="text-rose-700 hover:underline">Register here</a>
            </p>
        </form>

        <div class="form-notes">
            <h3>Login Validation Rules</h3>
            <ul>
                <li>Email is required and must be valid.</li>
                <li>Username: 5-15 chars, starts with letter, letters/numbers/underscore only.</li>
                <li>Password: 8-20 chars, at least 1 uppercase, 1 lowercase, 1 number, 1 special, no spaces, no ; ' / \</li>
            </ul>
        </div>
    </div>
</div>

@endsection
