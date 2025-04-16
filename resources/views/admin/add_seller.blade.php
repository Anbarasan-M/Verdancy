@extends('layouts.common_layout')

@section('content')
<div class="container py-5">
    <div class="card mx-auto form-card">
        <div class="row g-0">
            <div class="col-md-5 d-none d-md-block">
                <img src="{{ asset('images/seller_register_image (2).jpg') }}" alt="Seller" class="img-fluid" style="height: 500px;">
            </div>
            <div class="col-md-7 p-4">                
                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateSellerForm()">
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
                            <label for="license_number" class="form-label">License Number</label>
                            <input type="text" name="license_number" id="license_number" class="form-control" value="{{ old('license_number') }}">
                            <span id="license_number_error" class="text-danger"></span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" name="address" id="address" class="form-control" value="{{ old('address') }}">
                        <span id="address_error" class="text-danger"></span>
                    </div>

                    <div class="row mb-3">
                        <input type="hidden" name="password" id="password" value="Verdancy@2025">
                        <input type="hidden" name="password_confirmation" id="password_confirmation" value="Verdancy@2025">
                    </div>

                    <div class="mb-3">
                        <label for="profile_image" class="form-label">Profile Image</label>
                        <input type="file" name="profile_image" id="profile_image" class="form-control">
                    </div>

                    <input type="hidden" name="role_id" value="3">
                    <input type="hidden" name="activity_status" value="active">
                    <input type="hidden" name="approval_status" value="approved">

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Add Seller</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center">
    <a href="{{ route('sellers.index') }}" class="btn btn-success">
        Back
    </a>
</div>


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
                condition: (value) => value.length >= 10 && value.length <= 255,
                message: "Address must be between 10 and 255 characters."
            },
            'password': {
                condition: (value) => value.length >= 8,
                message: "Password must be at least 8 characters."
            }
        };

        for (const [field, validator] of Object.entries(validators)) {
            const value = document.getElementById(field).value;
            if (!validator.condition(value)) {
                document.getElementById(`${field}_error`).textContent = validator.message;
                valid = false;
            }
        }

        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('password_confirmation').value;
        if (password !== confirmPassword) {
            document.getElementById('confirm_password_error').textContent = "Passwords do not match.";
            valid = false;
        }

        return valid;
    }
</script>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@endsection
