@extends('layouts.login_register')

@section('content')
<div class="container-fluid py-5" style="background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%); min-height: 100vh;">
    <div class="card mx-auto" style="max-width: 800px; background-color: white; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); overflow: hidden;">
        <div class="row g-0">
            <div class="col-md-5 d-none d-md-block">
                <img src="{{ asset('images/user_register_image.jpg') }}" alt="Plants" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <div class="col-md-7 p-4">
                <h2 class="text-center mb-4" style="color: #2e7d32; font-weight: 700;">Join Our Green Community</h2>
                
                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateUserForm()">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                        <span id="name_error" class="text-danger"></span>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
                        <span id="email_error" class="text-danger"></span>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <label for="phone_number" class="form-label">Phone Number</label>
                            <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ old('phone_number') }}">
                            <span id="phone_number_error" class="text-danger"></span>
                        </div>
                        <div class="col">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" name="address" id="address" class="form-control" value="{{ old('address') }}">
                            <span id="address_error" class="text-danger"></span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control">
                            <span id="password_error" class="text-danger"></span>
                        </div>
                        <div class="col">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                            <span id="confirm_password_error" class="text-danger"></span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="profile_image" class="form-label">Profile Image</label>
                        <input type="file" name="profile_image" id="profile_image" class="form-control">
                    </div>

                    <input type="hidden" name="role_id" value="4">
                    <input type="hidden" name="activity_status" value="active">
                    <input type="hidden" name="approval_status" value="approved">

                    <!-- Google reCAPTCHA -->
                    <div class="mb-3">
                        <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_SITE_KEY') }}"></div>
                        @if ($errors->has('captcha'))
                            <span class="text-danger">{{ $errors->first('captcha') }}</span>
                        @endif
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success" style="background-color: #4caf50; border: none;">Start Your Green Journey</button>
                    </div>
                </form>

                <p class="mt-3 text-center">Already have an account? <a href="{{ route('login') }}" style="color: #4caf50; text-decoration: none;">Log in</a></p>
            </div>
        </div>
    </div>
</div>

<!-- Google reCAPTCHA Script -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<script>
    function validateUserForm() {
        let valid = true;
        const errors = document.querySelectorAll('.text-danger');
        errors.forEach(error => error.textContent = '');

        const validators = {
            'name': {
                condition: (value) => value.length >= 2 && value.length <= 50,
                message: "Full name must be between 2 and 50 characters."
            },
            'email': {
                condition: (value) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value),
                message: "Please enter a valid email address."
            },
            'phone_number': {
                condition: (value) => /^[0-9]{10}$/.test(value),
                message: "Please enter a valid 10-digit phone number."
            },
            'address': {
                condition: (value) => value.length <= 255,
                message: "Address should not exceed 255 characters."
            },
            'password': {
                condition: (value) => value.length >= 8,
                message: "Password must be at least 8 characters."
            },
            'password_confirmation': {
                condition: (value) => value === document.getElementById('password').value,
                message: "Passwords do not match."
            },
        };

        for (let field in validators) {
            const inputValue = document.getElementById(field).value;
            if (!validators[field].condition(inputValue)) {
                document.getElementById(`${field}_error`).textContent = validators[field].message;
                valid = false;
            }
        }

        return valid;
    }
</script>
@endsection
