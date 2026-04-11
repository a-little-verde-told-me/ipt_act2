@extends('headerfooter')

@section('title', 'Registration | FLEUR')

@section('content')
<div class="auth-page">
    <div class="auth-card">
        <h1>Registration</h1>

        <form class="auth-form form-grid" id="registrationForm" action="{{ route('registration.submit') }}" method="post" novalidate>
            @csrf

            @if(session('error'))
                <p class="form-error">{{ session('error') }}</p>
            @endif
            @if(session('success'))
                <p class="form-success">{{ session('success') }}</p>
            @endif

            <div class="form-column">
                <h2>Personal Information</h2>

                    <label for="fullName">Full Name</label>
                    <input id="fullName" type="text" name="name" value="{{ old('name') }}" required minlength="2"
                           pattern="^[A-Za-z ]+$" title="Letters and spaces only">
                    @error('name') <p class="field-error">{{ $message }}</p> @enderror

                <label for="username">Username</label>
                <input id="username" type="text" name="username" value="{{ old('username') }}" required minlength="5" maxlength="15"
                       pattern="^[A-Za-z][A-Za-z0-9_]{4,14}$"
                       title="5-15 chars, start with a letter, letters/numbers/underscore only">
                @error('username') <p class="field-error">{{ $message }}</p> @enderror

                <label for="regEmail">Email</label>
                <input id="regEmail" type="email" name="email" value="{{ old('email') }}" required>
                @error('email') <p class="field-error">{{ $message }}</p> @enderror

                <label for="regPassword">Password</label>
                <div class="password-field">
                    <input id="regPassword" type="password" name="password" autocomplete="off" required minlength="8" maxlength="20"
                           pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[^\s'\"]{8,20}$"
                           title="8-20 chars, at least 1 uppercase, 1 lowercase, 1 number, no spaces, no quotes">
                    <button type="button" class="password-toggle" data-target="regPassword" aria-label="Show password">
                    </button>
                </div>
                @error('password') <p class="field-error">{{ $message }}</p> @enderror

                <label for="confirmPassword">Confirm Password</label>
                <div class="password-field">
                    <input id="confirmPassword" type="password" name="confirm_password" autocomplete="off" required minlength="8" maxlength="20">
                    <button type="button" class="password-toggle" data-target="confirmPassword" aria-label="Show password">
                    </button>
                </div>
                @error('confirm_password') <p class="field-error">{{ $message }}</p> @enderror

                <label for="age">Age</label>
                <input id="age" type="number" name="age" min="18" max="60" value="{{ old('age') }}" required>
                @error('age') <p class="field-error">{{ $message }}</p> @enderror

                
            </div>

            <div class="form-column">

            <label>Gender</label>
                <div class="radio-group">
                    <label><input type="radio" name="gender" value="Male" {{ old('gender') === 'Male' ? 'checked' : '' }} required> Male</label>
                    <label><input type="radio" name="gender" value="Female" {{ old('gender') === 'Female' ? 'checked' : '' }} required> Female</label>
                    <label><input type="radio" name="gender" value="Other" {{ old('gender') === 'Other' ? 'checked' : '' }} required> Other</label>
                </div>
                @error('gender') <p class="field-error">{{ $message }}</p> @enderror

                <label for="civilStatus">Civil Status</label>
                <select id="civilStatus" name="civil_status" required>
                    <option value="">Select</option>
                    <option value="Single" {{ old('civil_status') === 'Single' ? 'selected' : '' }}>Single</option>
                    <option value="Married" {{ old('civil_status') === 'Married' ? 'selected' : '' }}>Married</option>
                    <option value="Separated" {{ old('civil_status') === 'Separated' ? 'selected' : '' }}>Separated</option>
                    <option value="Widowed" {{ old('civil_status') === 'Widowed' ? 'selected' : '' }}>Widowed</option>
                </select>
                @error('civil_status') <p class="field-error">{{ $message }}</p> @enderror
                <h2>Contact Information</h2>
                <label for="mobile">Mobile Number</label>
                <input id="mobile" type="text" name="mobile" value="{{ old('mobile') }}" required
                       pattern="^09\d{9}$" title="Philippine format: 11 digits starting with 09">
                @error('mobile') <p class="field-error">{{ $message }}</p> @enderror

                <label for="address">Address</label>
                <textarea id="address" name="address" rows="3" minlength="50" required>{{ old('address') }}</textarea>
                @error('address') <p class="field-error">{{ $message }}</p> @enderror

                <label for="zip">ZIP Code</label>
                <input id="zip" type="text" name="zip" value="{{ old('zip') }}" required pattern="^\d{4}$" title="4-digit ZIP code">
                @error('zip') <p class="field-error">{{ $message }}</p> @enderror

                <div class="full-width-actions">
                <button type="submit" class="submit-btn">Create Account</button>
                <p class="auth-switch">Already have an account? <a href="{{ route('login') }}">Login here</a></p>
            </div>
            </div>

            
        </form>
    </div>
</div>

<script>
    const regPassword = document.getElementById('regPassword');
    const confirmPassword = document.getElementById('confirmPassword');

    function validatePasswordMatch() {
        if (confirmPassword.value && regPassword.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity('Passwords do not match');
        } else {
            confirmPassword.setCustomValidity('');
        }
    }

    regPassword.addEventListener('input', validatePasswordMatch);
    confirmPassword.addEventListener('input', validatePasswordMatch);

    const regForm = document.getElementById('registrationForm');
    regForm.addEventListener('submit', (e) => {
        validatePasswordMatch();
        if (!regForm.reportValidity()) {
            e.preventDefault();
        }
    });

    function initPasswordToggles() {
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

    initPasswordToggles();
</script>
@endsection
