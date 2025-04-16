<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4CAF50;
            --secondary-color: #2E7D32;
            --accent-color: #66BB6A;
            --background-color: #f5f5f5;
            --text-color: #333;
        }

        body, html {
            background-image: url('{{ asset('images/login_bg.jpg') }}');
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
        }

        .page-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .login-card {
            background-color: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 1000px;
            max-width: 100%;
            display: flex;
            min-height: 600px;
        }

        .login-form, .register-form {
            padding: 40px;
            width: 50%;
        }

        .register-form {
            background-color: #f9f9f9;
            border-left: 1px solid #eee;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-control {
            border-radius: 50px;
            padding: 12px 20px;
            border: 1px solid #ddd;
        }

        .btn {
            border-radius: 50px;
            padding: 12px 20px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .btn-outline-success {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-outline-success:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .social-buttons .btn {
            margin-bottom: 15px;
            background-color: white;
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
        }

        .social-buttons .btn:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .form-group label {
            font-weight: bold;
            margin-bottom: 8px;
            color: var(--text-color);
        }

        .input-group-text {
            border-radius: 50px 0 0 50px;
            background-color: #f9f9f9;
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 20px 0;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #ddd;
        }

        .divider span {
            padding: 0 10px;
            color: var(--primary-color);
            font-size: 0.9rem;
        }

        .welcome-text {
            text-align: center;
            margin-bottom: 30px;
        }

        .welcome-text h1 {
            color: var(--primary-color);
        }

        .alert {
            border-radius: 15px;
        }
    </style>
</head>
<body>
    <div class="page-container">
        <div class="login-card">
            <div class="login-form">
                <div class="welcome-text">
                    <h1 class="fw-bold">Welcome Back</h1>
                    <p class="lead text-muted">Please login to your account</p>
                </div>
                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    <div class="form-group mb-4">
                        <label for="email">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" class="form-control" id="email" name="email" placeholder="Enter your username or email" required>
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <label for="password">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>
                        <a href="{{ route('password.request') }}" class="text-decoration-none" style="color: var(--primary-color);">Forgot password?</a>
                    </div>
                    <div class="d-grid mb-4">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                    <!-- <div class="divider">
                        <span>or login with</span>
                    </div> -->
                    <!-- <div class="d-flex justify-content-center">
                        <a href="#" class="btn btn-outline-success me-2"><i class="fab fa-google"></i></a>
                        <a href="#" class="btn btn-outline-success me-2"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="btn btn-outline-success"><i class="fab fa-twitter"></i></a>
                    </div> -->
                </form>
            </div>
            <div class="register-form">
                <h2 class="fw-bold mb-4">New Here?</h2>
                <p class="text-muted mb-4">Sign up and discover great opportunities</p>
                <div class="social-buttons">
                    <a href="{{ route('users.create') }}" class="btn w-100 mb-3">
                        <i class="fas fa-user me-2"></i> Register as a User
                    </a>
                    <a href="{{ route('sellers.create') }}" class="btn w-100 mb-3">
                        <i class="fas fa-user me-2"></i> Register as Seller
                    </a>
                    <a href="{{ route('serviceProvider.create') }}" class="btn w-100 mb-3">
                        <i class="fas fa-user me-2"></i> Register as a Service Provider
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger position-fixed bottom-0 end-0 m-3">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
