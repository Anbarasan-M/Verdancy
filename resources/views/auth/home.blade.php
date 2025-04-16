@extends('layouts.login_register')

@section('title', 'Verdancy - Your Green Oasis')

@section('content')
<div class="container mt-4">
    <!-- Hero Section -->
    <div class="row align-items-center mb-5">
        <div class="col-md-6">
            <h1 class="display-4 fw-bold text-success">Welcome to Verdancy</h1>
            <p class="lead text-muted">Bring nature indoors with our curated collection of lush, vibrant plants.</p>
            <a href="{{ route('users.shop') }}" class="btn btn-success btn-lg mt-3">Explore Our Garden</a>
        </div>
        <div class="col-md-6">
            <img src="{{ asset('images/plant_home.jpg') }}" alt="Beautiful plants" class="img-fluid rounded-lg shadow-lg">
        </div>
    </div>

    <!-- Featured Plants Section -->
    <section id="featured-plants" class="mb-5">
        <h2 class="text-center mb-4 text-success">Our Green Treasures</h2>
        <div class="row">
            @for ($i = 1; $i <= 4; $i++)
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow-sm border-0 rounded-lg overflow-hidden">
                    <img src="https://source.unsplash.com/random/300x200?plant{{ $i }}" class="card-img-top" alt="Plant {{ $i }}">
                    <div class="card-body">
                        <h5 class="card-title text-success">Emerald Beauty {{ $i }}</h5>
                        <p class="card-text text-muted">A stunning addition to your indoor jungle, perfect for purifying the air and adding a touch of serenity.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 mb-0 text-success">$29.99</span>
                            <a href="#" class="btn btn-outline-success">Add to Cart</a>
                        </div>
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </section>

    <!-- Categories Section -->
    <section class="mb-5">
        <h2 class="text-center mb-4 text-success">Explore Our Green World</h2>
        <div class="row">
            @foreach(['Indoor Oasis', 'Outdoor Paradise', 'Succulent Haven', 'Herb Garden'] as $category)
            <div class="col-md-3 mb-4">
                <div class="card bg-light border-0 rounded-lg shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title text-success">{{ $category }}</h5>
                        <a href="#" class="btn btn-sm btn-success">Discover More</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="mb-5 bg-light py-5 rounded-lg">
        <h2 class="text-center mb-4 text-success">Why Choose Verdancy?</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 bg-white rounded-lg shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-leaf fa-3x mb-3 text-success"></i>
                        <h5 class="card-title text-success">Premium Quality Plants</h5>
                        <p class="card-text text-muted">We handpick the healthiest and most vibrant plants for your home.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 bg-white rounded-lg shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-truck fa-3x mb-3 text-success"></i>
                        <h5 class="card-title text-success">Careful Delivery</h5>
                        <p class="card-text text-muted">Your green friends are lovingly packaged and delivered to your doorstep.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 bg-white rounded-lg shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-hands-helping fa-3x mb-3 text-success"></i>
                        <h5 class="card-title text-success">Expert Plant Care Support</h5>
                        <p class="card-text text-muted">Our plant whisperers are always ready to help with care tips and advice.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="bg-success p-5 rounded-lg text-white">
        <h2 class="text-center mb-4">Join Our Verdant Community</h2>
        <p class="text-center mb-4">Subscribe for exclusive plant care tips, special offers, and green inspiration!</p>
        <form class="row justify-content-center">
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="Enter your email" aria-label="Email" aria-describedby="button-addon2">
                    <button class="btn btn-light text-success" type="button" id="button-addon2">Subscribe</button>
                </div>
            </div>
        </form>
    </section>
</div>
@endsection

