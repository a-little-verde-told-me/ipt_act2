@extends('headerfooter')

@section('title', 'Registration | FLEUR')

@section('content')
<div class="auth-page">
    <div class="auth-card">
        <h1>Registration</h1>
        <form class="auth-form" id="registrationForm" action="{{ route('registration.submit') }}" method="post" novalidate>
            @csrf
            @if($errors->any())
                <p style="color:#a64452; font-weight:600; margin-bottom:10px;">{{ $errors->first() }}</p>
            @endif
            <h3>Personal Information</h3>

            <label for="fullName">Full Name</label>
            <input id="fullName" type="text" name="full_name" required minlength="2"
                   pattern="^[A-Za-z ]+$" title="Letters and spaces only"
                   placeholder="Example: Fleur Santos Ramos">
            <small style="display:block; margin-top:6px; color:#666; font-size:0.85rem;">
                Letters and spaces only (no dots, no numbers, no symbols).
            </small>

            <label for="regEmail">Email</label>
            <input id="regEmail" type="email" name="email" required
                   placeholder="Example: fleur@gmail.com">

            <label for="regUsername">Username</label>
            <input id="regUsername" type="text" name="username" required minlength="5" maxlength="15"
                   pattern="^[A-Za-z][A-Za-z0-9_]{4,14}$"
                   title="5-15 chars, start with a letter, letters/numbers/underscore only"
                   placeholder="Example: Fleur_01">

            <label for="regPassword">Password</label>
            <input id="regPassword" type="password" name="password" required minlength="8" maxlength="20"
                   pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*\\d)(?=.*[^A-Za-z0-9\\s;'&quot;/\\\\])[^\\s;'&quot;/\\\\]{8,20}$"
                   title="8-20 chars, at least 1 uppercase, 1 lowercase, 1 number, 1 special, no spaces, no ; ' / \"
                   placeholder="Example: Fleur@2026">
            <small style="display:block; margin-top:6px; color:#666; font-size:0.85rem;">
                Password must be 8–20 chars, include 1 uppercase, 1 lowercase, 1 number, 1 special, and no spaces or ; ' / \.
            </small>

            <label for="confirmPassword">Confirm Password</label>
            <input id="confirmPassword" type="password" name="password_confirmation" required minlength="8" maxlength="20"
                   placeholder="Re-type your password">

            <label for="age">Age</label>
            <input id="age" type="number" name="age" min="18" max="60" required
                   placeholder="Example: 22">

            <label>Gender</label>
            <div class="radio-group">
                <label><input type="radio" name="gender" value="Male" required> Male</label>
                <label><input type="radio" name="gender" value="Female" required> Female</label>
                <label><input type="radio" name="gender" value="Other" required> Other</label>
            </div>

            <label for="civilStatus">Civil Status</label>
            <select id="civilStatus" name="civil_status" required>
                <option value="">Select</option>
                <option value="Single">Single</option>
                <option value="Married">Married</option>
                <option value="Separated">Separated</option>
                <option value="Widowed">Widowed</option>
            </select>

            <h3>Contact Information</h3>

            <label for="mobile">Mobile Number</label>
            <input id="mobile" type="text" name="mobile" required
                   pattern="^09\d{9}$" title="Philippine format: 11 digits starting with 09"
                   placeholder="Example: 09123456789">

            <label for="address">Address</label>
            <textarea id="address" name="address" rows="3" minlength="50" required
                      placeholder="Example: 123 Mabini St, Brgy. Poblacion, Lingayen, Pangasinan 2401"></textarea>

            <label for="zip">ZIP Code</label>
            <input id="zip" type="text" name="zip" required pattern="^\d{4}$" title="4-digit ZIP code"
                   placeholder="Example: 2401">

            <button type="submit" class="submit-btn">Create Account</button>
        </form>

        <div class="form-notes">
            <h3>Validation Rules</h3>
            <ul>
                <li>Full name: letters and spaces only.</li>
                <li>Username: 5-15 chars, starts with letter, letters/numbers/underscore only.</li>
                <li>Password: 8-20 chars, at least 1 uppercase, 1 lowercase, 1 number, 1 special, no spaces, no ; ' / \</li>
                <li>Confirm password must match.</li>
                <li>Age: 18-60 only.</li>
                <li>Mobile: 11 digits starting with 09.</li>
                <li>Address: minimum 50 characters.</li>
                <li>ZIP: 4 digits.</li>
            </ul>
        </div>
    </div>
</div>

@endsection
