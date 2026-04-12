@extends('headerfooter')

@section('title', 'Profile | FLEUR')

@section('content')
<div class="auth-page">
    <div class="auth-card">
        <h1 style="color: #8a3a45; font-size: 2.5rem;">My Profile</h1>

        @if(session('success'))
            <p class="form-success">{{ session('success') }}</p>
        @endif

        @auth
            <div class="profile-summary">
                <div class="profile-row"><span class="profile-label">Name</span><span class="profile-value">{{ auth()->user()->name }}</span></div>
                <div class="profile-row"><span class="profile-label">Username</span><span class="profile-value">{{ auth()->user()->username }}</span></div>
                <div class="profile-row"><span class="profile-label">Email</span><span class="profile-value">{{ auth()->user()->email }}</span></div>
                <div class="profile-row"><span class="profile-label">Age</span><span class="profile-value">{{ auth()->user()->age }}</span></div>
                <div class="profile-row"><span class="profile-label">Gender</span><span class="profile-value">{{ auth()->user()->gender }}</span></div>
                <div class="profile-row"><span class="profile-label">Civil Status</span><span class="profile-value">{{ auth()->user()->civil_status }}</span></div>
                <div class="profile-row"><span class="profile-label">Mobile</span><span class="profile-value">{{ auth()->user()->mobile }}</span></div>
                <div class="profile-row"><span class="profile-label">Address</span><span class="profile-value">{{ auth()->user()->address }}</span></div>
                <div class="profile-row"><span class="profile-label">ZIP Code</span><span class="profile-value">{{ auth()->user()->zip }}</span></div>
            </div>
            <div class="profile-actions">
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" class="logout-btn">Log Out</button>
                </form>
                <a href="{{ route('home') }}" class="secondary-link">Return to Home</a>
            </div>
        @else
            <p class="form-error">You are not logged in. Please <a href="{{ route('login') }}">sign in</a> or <a href="{{ route('registration') }}">register</a>.</p>
        @endauth
    </div>
</div>
@endsection
