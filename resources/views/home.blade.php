@extends('layouts.home')

@section('content')
<div class="container-fluid p-0">
    <!-- Hero Section -->
    <section class="hero bg-light py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold">Welcome to GreenThumb</h1>
                    <p class="lead">Discover the perfect plants for your home and garden.</p>
                    <a href="#" class="btn btn-success btn-lg">Shop Now</a>
                </div>
                <div class="col-lg-6">
                    <img src="{{ asset('images/hero-plant.jpg') }}" alt="Beautiful plant" class="img-fluid rounded-3 shadow">
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">About Us</h2>
            <div class="row">
                <div class="col-md-6">
                    <p>GreenThumb is your one-stop shop for all things plants. We're passionate about bringing nature into your home and helping you create your own urban jungle.</p>
                </div>
                <div class="col-md-6">
                    <p>With a wide selection of indoor and outdoor plants, plus expert advice on plant care, we're here to help you grow your green family.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="bg-light py-5">
        <div class="container">
            <h2 class="text-center mb-4">Our Services</h2>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Plant Selection</h5>
                            <p class="card-text">Find the perfect plants for your space and lifestyle.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Care Guides</h5>
                            <p class="card-text">Expert advice on how to keep your plants thriving.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Delivery</h5>
                            <p class="card-text">Fast and careful delivery of your new green friends.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section id="featured" class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Featured Plants</h2>
            <div class="row">
                @for ($i = 1; $i <= 4; $i++)
                <div class="col-md-3 mb-3">
                    <div class="card">
                        <img src="{{ asset('images/plant-' . $i . '.jpg') }}" class="card-img-top" alt="Plant {{ $i }}">
                        <div class="card-body">
                            <h5 class="card-title">Plant {{ $i }}</h5>
                            <p class="card-text">$19.99</p>
                            <a href="#" class="btn btn-outline-success">Add to Cart</a>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script>
    // Add any custom JavaScript here
</script>
@endsection
