@extends('headerfooter')

@section('title', 'Profile | FLEUR')

@section('content')
<div class="auth-page">
    <div class="auth-card">
        <h1>My Profile</h1>

        @if(session('success'))
            <p class="form-success">{{ session('success') }}</p>
        @endif

        @auth
            <div class="profile-summary">
                <p><strong>Name:</strong> {{ auth()->user()->name }}</p>
                <p><strong>Username:</strong> {{ auth()->user()->username }}</p>
                <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                <p><strong>Age:</strong> {{ auth()->user()->age }}</p>
                <p><strong>Gender:</strong> {{ auth()->user()->gender }}</p>
                <p><strong>Civil Status:</strong> {{ auth()->user()->civil_status }}</p>
                <p><strong>Mobile:</strong> {{ auth()->user()->mobile }}</p>
                <p><strong>Address:</strong> {{ auth()->user()->address }}</p>
                <p><strong>ZIP Code:</strong> {{ auth()->user()->zip }}</p>
            </div>
            <div class="profile-actions">
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" class="logout-btn">Log Out</button>
                </form>
                <a href="{{ route('home') }}" class="text-rose-700 hover:underline">Return to Home</a>
            </div>
        @else
            <p class="form-error">You are not logged in. Please <a href="{{ route('login') }}">sign in</a> or <a href="{{ route('registration') }}">register</a>.</p>
        @endauth
    </div>
</div>
@endsection
