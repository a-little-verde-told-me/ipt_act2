@extends('headerfooter')

@section('title', 'Profile | FLEUR')

@section('content')
<div class="auth-page">
    <div class="auth-card">
        <h1>Profile</h1>

        @auth
            <p style="margin-bottom:10px;"><strong>Name:</strong> {{ auth()->user()->name }}</p>
            <p style="margin-bottom:10px;"><strong>Username:</strong> {{ auth()->user()->username }}</p>
            <p style="margin-bottom:10px;"><strong>Email:</strong> {{ auth()->user()->email }}</p>
        @else
            <p style="margin-bottom:10px;">Please log in to view your profile.</p>
            <a href="{{ route('login') }}" class="submit-btn">Go to Login</a>
        @endauth
    </div>
</div>
@endsection
