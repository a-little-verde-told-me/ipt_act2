@extends('headerfooter')

@section('title', 'Profile | FLEUR')

@section('content')
<div class="auth-page">
    <div class="auth-card">
<<<<<<< HEAD
        <h1>Profile</h1>

        @auth
            <p style="margin-bottom:10px;"><strong>Name:</strong> {{ auth()->user()->name }}</p>
            <p style="margin-bottom:10px;"><strong>Username:</strong> {{ auth()->user()->username }}</p>
            <p style="margin-bottom:10px;"><strong>Email:</strong> {{ auth()->user()->email }}</p>
        @else
            <p style="margin-bottom:10px;">Please log in to view your profile.</p>
            <a href="{{ route('login') }}" class="submit-btn">Go to Login</a>
=======
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
>>>>>>> e4a410a73bc82e8585405de66b0db980670780d3
        @endauth
    </div>
</div>
@endsection
