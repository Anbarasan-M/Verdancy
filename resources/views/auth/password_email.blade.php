@extends('layouts.login_register')

@section('title', 'Forgot Password')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <h2 class="card-title text-center mb-4">Forgot Password</h2>
                    <p class="text-center mb-4 text-muted">Enter your email address and we’ll send you a link to reset your password.</p>
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="mb-4">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required autofocus placeholder="Enter your email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Send Reset Link</button>
                        </div>
                    </form>

                    @if(session('status'))
                        <div class="alert alert-success mt-3" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="text-center mt-4">
                        <a href="{{ route('login') }}" class="text-decoration-none">Back to Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
