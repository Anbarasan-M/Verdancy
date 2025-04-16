<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    @stack('styles')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }

        .navbar {
            background-color: #006b00;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 0.5rem 1rem;
        }

        .navbar-brand {
            font-weight: 600;
            color: #ffffff !important;
        }

        .navbar .doctor-image {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .nav-link {
            color: #ffffff !important;
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
            border-radius: 20px;
            margin: 0 5px;
        }

        .nav-link:hover, .nav-link.active {
            background-color: #27ae60;
            color: #ffffff !important;
        }

        .navbar-toggler {
            border: none;
            padding: 0;
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255, 255, 255, 0.75)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .dropdown-item {
            padding: 10px 20px;
            transition: all 0.3s ease;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
            color: #2ecc71;
        }

        .logout-btn {
            background-color: #e74c3c;
            color: #fff !important;
            border-radius: 20px;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background-color: #c0392b;
        }

        @media (max-width: 991.98px) {
            .navbar-nav {
                padding-top: 1rem;
            }
            .nav-link {
                padding: 0.5rem 0;
            }
        }

        .profile-section {
            display: flex;
            align-items: center;
            margin-left: 1rem;
        }

        .profile-name {
            margin-left: 0.5rem;
            font-weight: 500;
            color: #ffffff;
        }

        @media (max-width: 991.98px) {
            .profile-section {
                margin-top: 1rem;
                justify-content: center;
            }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="#">
            <i class="fas fa-leaf me-2"></i>
            Verdancy
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                                <li class="nav-item">
                    @if (Auth::user()->role_id == 1)
                        <a class="nav-link {{ Route::is('superadmin.dashboard') ? 'active' : '' }}" href="{{ route('superadmin.dashboard') }}"><i class="fas fa-home me-1"></i> Home</a>
                    @elseif (Auth::user()->role_id == 2)
                        <a class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="fas fa-home me-1"></i> Home</a>
                    @elseif (Auth::user()->role_id == 3)
                        <a class="nav-link {{ Route::is('orders') ? 'active' : '' }}" href="{{ route('orders') }}"><i class="fas fa-clipboard-list me-1"></i>Manage Orders</a>
                    @elseif (Auth::user()->role_id == 4)
                        <a class="nav-link {{ Route::is('user.dashboard') ? 'active' : '' }}" href="{{ route('user.dashboard') }}"><i class="fas fa-home me-1"></i> Home</a>
                    @elseif (Auth::user()->role_id == 5)
                        <a class="nav-link {{ Route::is('serviceProvider.bookings') ? 'active' : '' }}" href="{{ route('serviceProvider.bookings') }}"><i class="fas fa-home me-1"></i> Home</a>
                    @endif
                </li>

                @if (Auth::user()->role_id == 1)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-cog me-1"></i> Admin Tools
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('superAdmin.addAdmin') }}"><i class="fas fa-user-plus me-1"></i> Add Admin</a></li>
                            <li><a class="dropdown-item" href="{{ route('approveSeller') }}"><i class="fas fa-store me-1"></i> Add Seller</a></li>
                            <li><a class="dropdown-item" href="{{ route('approveServiceProvider') }}"><i class="fas fa-user-md me-1"></i> Add Service Provider</a></li>
                            <li><a class="dropdown-item" href="{{ route('stocks') }}"><i class="fas fa-boxes me-1"></i> Stocks</a></li>
                        </ul>
                    </li>
                @elseif (Auth::user()->role_id == 2)
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('admin.manageLeaves') ? 'active' : '' }}" href="{{ route('admin.manageLeaves') }}"><i class="fas fa-calendar-alt me-1"></i> Manage Leaves</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('orders') ? 'active' : '' }}" href="{{ route('orders') }}">
                            <i class="fas fa-clipboard-list me-1"></i>Manage Orders
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('transactions.index') ? 'active' : '' }}" href="{{ route('transactions.index') }}">
                            <i class="fas fa-clipboard-list me-1"></i>User Transactions
                        </a>
                    </li>
                @elseif (Auth::user()->role_id == 3)
                @elseif (Auth::user()->role_id == 4)
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('users.shop') ? 'active' : '' }}" href="{{ route('users.shop') }}"><i class="fas fa-shopping-bag me-1"></i> Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('services') ? 'active' : '' }}" href="{{ route('services') }}"><i class="fas fa-concierge-bell me-1"></i> Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('bookings.list') ? 'active' : '' }}" href="{{ route('bookings.list') }}"><i class="fas fa-calendar-check me-1"></i> Bookings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('cart.index') ? 'active' : '' }}" href="{{ route('cart.index') }}"><i class="fas fa-shopping-cart me-1"></i> Cart</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('orders') ? 'active' : '' }}" href="{{ route('orders') }}">
                            <i class="fas fa-clipboard-list me-1"></i> Orders
                        </a>
                    </li>
                @elseif (Auth::user()->role_id == 5)
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('serviceProvider.leave') ? 'active' : '' }}" href="{{ route('serviceProvider.leave') }}"><i class="fas fa-calendar-plus me-1"></i> Apply Leave</a>
                    </li>
                @endif

                <li class="nav-item ms-2">
                    <a class="nav-link logout-btn" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt me-1"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>

                <li class="nav-item profile-section">
                    <span class="profile-name d-none d-lg-inline" style="color: #cccc00;">
                        {{ strlen(Auth::user()->name) > 25 ? substr(Auth::user()->name, 0, 25) . '...' : Auth::user()->name }}
                    </span>
                    <!-- Make the profile image clickable to edit profile -->
                    <a href="{{ route('profile.edit') }}" class="ms-2">
                        <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="Profile" class="doctor-image">
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script>
    @if(session('leave_applied'))
        swal({
            title: "Success!",
            text: "{{ session('leave_applied') }}",
            icon: "success",
            button: "OK",
        });
    @endif
</script>
<script>
    @if(session('added_to_cart'))
        swal({
            title: "Item added to cart!",
            text: "{{ session('added_to_cart') }}",
            icon: "success",
            button: "OK",
        });
    @endif
</script>
<script>
    @if(session('service_booked'))
        swal({
            title: "Service booked!",
            text: "{{ session('service_booked') }}",
            icon: "success",
            button: "OK",
        });
    @endif
</script>
<script>
    @if(session('order_placed'))
        swal({
            title: "Order placed!",
            text: "{{ session('order_placed') }}",
            icon: "success",
            button: "OK",
        });
    @endif
</script>

<script>
    @if(session('registration_successful'))
        swal({
            title: "Registration Successful!",
            text: "{{ session('registration_successful') }}",
            icon: "success",
            button: "OK",
            }).then(function() {
                window.location.href = "{{ route('login') }}";
        });
    @endif   removed_from_cart
</script>

<script>
    @if(session('removed_from_cart'))
        swal({
            title: "Item removed from cart!",
            text: "{{ session('removed_from_cart') }}",
            icon: "success",
            button: "OK",
            }).then(function() {
                window.location.href = "{{ route('login') }}";
        });
    @endif   
</script>

</body>
</html>
