@extends('headerfooter')

@section('title', 'Registration | FLEUR')

@section('content')
<div class="auth-page">
    <div class="auth-card">
        <h1>Registration</h1>
        <form class="auth-form" id="registrationForm" action="#" method="post" novalidate>
            <h3>Personal Information</h3>

            <label for="fullName">Full Name</label>
            <input id="fullName" type="text" name="full_name" required minlength="2"
                   pattern="^[A-Za-z ]+$" title="Letters and spaces only">

            <label for="regEmail">Email</label>
            <input id="regEmail" type="email" name="email" required>

            <label for="regPassword">Password</label>
            <input id="regPassword" type="password" name="password" required minlength="8" maxlength="20"
                   pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[^\s'\"]{8,20}$"
                   title="8-20 chars, at least 1 uppercase, 1 lowercase, 1 number, no spaces, no quotes">

            <label for="confirmPassword">Confirm Password</label>
            <input id="confirmPassword" type="password" name="confirm_password" required minlength="8" maxlength="20">

            <label for="age">Age</label>
            <input id="age" type="number" name="age" min="18" max="60" required>

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
                   pattern="^09\d{9}$" title="Philippine format: 11 digits starting with 09">

            <label for="address">Address</label>
            <textarea id="address" name="address" rows="3" minlength="50" required></textarea>

            <label for="zip">ZIP Code</label>
            <input id="zip" type="text" name="zip" required pattern="^\d{4}$" title="4-digit ZIP code">

            <button type="submit" class="submit-btn">Create Account</button>
        </form>

        <div class="form-notes">
            <h3>Validation Rules</h3>
            <ul>
                <li>Full name: letters and spaces only.</li>
                <li>Password: 8-20 chars, at least 1 uppercase, 1 lowercase, 1 number, no spaces, no quotes.</li>
                <li>Confirm password must match.</li>
                <li>Age: 18-60 only.</li>
                <li>Mobile: 11 digits starting with 09.</li>
                <li>Address: minimum 50 characters.</li>
                <li>ZIP: 4 digits.</li>
            </ul>
        </div>
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
        e.preventDefault();
        validatePasswordMatch();
        if (!regForm.reportValidity()) return;
        alert('Registration submitted.');
        regForm.reset();
    });
</script>
@endsection
