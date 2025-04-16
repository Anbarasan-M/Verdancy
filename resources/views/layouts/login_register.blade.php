<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <style>
        :root {
            --primary-color: #8BC34A;
            --secondary-color: #689F38;
            --accent-color: #DCEDC8;
            --text-color: #333;
            --background-color: #F5F5F5;
        }

        body {
            background-color: var(--background-color);
            color: var(--text-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand, .nav-link {
            color: var(--text-color) !important;
            font-weight: 500;
        }

        .nav-link {
            margin-right: 20px;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: #fff;
        }

        .card {
            transition: box-shadow 0.3s ease, transform 0.3s ease;
            border: none;
            border-radius: 10px;
            overflow: hidden;
        }

        .card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            transform: translateY(-5px);
        }

        .card-title {
            color: var(--primary-color);
        }

        footer {
            background-color: #fff;
            color: var(--text-color);
            padding: 20px;
            text-align: center;
            box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.1);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(139, 195, 74, 0.25);
        }
    </style>
</head>
<body>


    @yield('content')

<footer class="mt-5">
    <div class="container">
        <p>&copy; 2023 Verdancy. All rights reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
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
    @endif
</script>
</body>
</html>
