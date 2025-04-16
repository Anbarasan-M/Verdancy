@extends('layouts.common_layout')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="profile-image-container">
                            @if ($user->profile_image)
                                <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile Image" class="profile-image">
                            @else
                                <div class="profile-image-placeholder">
                                    <i class="fas fa-user"></i>
                                </div>
                            @endif
                        </div>
                        <h2 class="ms-3 mb-0">{{ $user->name }}</h2>
                    </div>

                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="needs-validation" novalidate>
    @csrf
    @method('PUT')

    <div class="mb-3 row">
        <div class="col-md-6">
            <label for="name" class="form-label fw-bold">Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <label for="email" class="form-label fw-bold">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="mb-3 row">
        <div class="col-md-6">
            <label for="phone_number" class="form-label fw-bold">Phone</label>
            <input type="tel" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}">
            @error('phone_number')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <label for="address" class="form-label fw-bold">Address</label>
            <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="2">{{ old('address', $user->address) }}</textarea>
            @error('address')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="mb-3 row">
        <div class="col-md-6">
            <label for="password" class="form-label fw-bold">New Password</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Leave blank to keep current password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <label for="password_confirmation" class="form-label fw-bold">Confirm Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm new password">
        </div>
    </div>

    <div class="mb-3 row">
        <div class="col-md-6">
            <label for="image" class="form-label fw-bold">Update Profile Image</label>
            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="d-grid">
        <button type="submit" class="btn btn-primary">Update Profile</button>
    </div>
</form>


                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    .form-control {
        background: rgba(255, 255, 255, 0.5);
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
    }
    .form-control:focus {
        background: rgba(255, 255, 255, 0.8);
        box-shadow: 0 0 15px rgba(0, 123, 255, 0.3);
    }
    .btn-primary {
        background: linear-gradient(45deg, #007bff, #00c6ff);
        border: none;
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.4);
    }
    .profile-image-container {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        overflow: hidden;
        background: #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .profile-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .profile-image-placeholder {
        font-size: 2rem;
        color: #aaa;
    }
</style>

<script>
    // Enable Bootstrap form validation
    (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
    })()
</script>
@endsection
