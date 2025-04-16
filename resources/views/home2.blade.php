@extends('layouts.login_register')

@section('title', 'Verdancy - Your Green Oasis')

@section('content')
<div class="container mt-5">
    <!-- Hero Section -->
    <div class="row align-items-center mb-6">
        <div class="col-md-6">
            <h1 class="display-4 fw-bold text-dark">Welcome to <span class="text-success">Verdancy</span></h1>
            <p class="lead text-muted">Bring nature indoors with our curated collection of lush, vibrant plants.</p>
            <a href="{{ route('login') }}" class="btn btn-success btn-lg mt-3 rounded-pill">Login To Explore our Gardern</a>
        </div>
        <div class="col-md-6">
            <img src="{{ asset('images/plant_home.jpg') }}" alt="Beautiful plants" class="img-fluid rounded-lg shadow-lg">
        </div>
    </div>

    <!-- Featured Plants Section -->
    <section id="featured-plants" class="mb-6">
        <h2 class="text-center mb-5 text-dark">Our Green <span class="text-success">Treasures</span></h2>
        <div class="row">
            @foreach ($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow border-0 rounded-lg overflow-hidden">
                    <img src="{{ asset('storage/' . $product->image_url) }}" class="card-img-top" alt="{{ $product->name }}" style="width: 300px; height: 150px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title text-dark">{{ $product->name }}</h5>
                        <p class="card-text text-muted flex-grow-1">{{ Str::words($product->description, 6, '...') }}</p>
                        <!-- <p class="card-text text-muted">{{ Str::limit($product->description, 45) }}</p> -->
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 mb-0 text-success">₹{{ $product->price }}</span>
                            <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="category_id" value="{{ $product->category_id }}">
                                <button type="submit" class="btn btn-warning rounded-pill">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

<!-- Categories Section -->
<section class="mb-6">
    <h2 class="text-center mb-5 text-dark">Explore Our <span class="text-success">Green World</span></h2>
    <div class="row">
        @foreach ($categories as $category)
        <div class="col-md-3 mb-4">
            <div class="card bg-light border-0 rounded-lg shadow-sm h-100">
                <div class="card-body text-center d-flex flex-column justify-content-between">
                    <!-- Circular category image -->
                    @if ($category->firstProduct && $category->firstProduct->image_url)
                        <div class="category-image-container mb-3">
                            <img src="{{ asset('storage/' . $category->firstProduct->image_url) }}" alt="{{ $category->name }}" class="category-image" style="width:300px; height: 300px; object-fit: cover; border-radius: 50px;">
                        </div>
                    @else
                        <div class="category-image-placeholder mb-3">
                            <i class="fas fa-leaf"></i>
                        </div>
                    @endif

                    <h5 class="card-title text-dark">{{ $category->name }}</h5>
                    <a href="{{ route('productBasedOnCategories', $category->id) }}" class="btn btn-sm btn-success rounded-pill mt-3">Discover More</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>





    <!-- Why Choose Us Section -->
    <section class="mb-6 bg-light py-5 rounded-lg">
        <h2 class="text-center mb-5 text-dark">Why Choose <span class="text-success">Verdancy</span>?</h2>
        <div class="row">
            @foreach([
                ['icon' => 'leaf', 'title' => 'Premium Quality Plants', 'description' => 'We handpick the healthiest and most vibrant plants for your home.'],
                ['icon' => 'truck', 'title' => 'Careful Delivery', 'description' => 'Your green friends are lovingly packaged and delivered to your doorstep.'],
                ['icon' => 'hands-helping', 'title' => 'Expert Plant Care Support', 'description' => 'Our plant whisperers are always ready to help with care tips and advice.']
            ] as $feature)
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 bg-white rounded-lg shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-{{ $feature['icon'] }} fa-3x mb-3 text-success"></i>
                        <h5 class="card-title text-dark">{{ $feature['title'] }}</h5>
                        <p class="card-text text-muted">{{ $feature['description'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="bg-success p-5 rounded-lg text-white">
        <h2 class="text-center mb-4">Join Our Verdant Community</h2>
        <p class="text-center mb-4">Subscribe for exclusive plant care tips, special offers, and green inspiration!</p>
        <form class="row justify-content-center" method="POST" action="{{ route('subscribe.submit') }}">
            @csrf <!-- CSRF Token for security -->
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control rounded-pill rounded-end" placeholder="Enter your email" aria-label="Email" aria-describedby="button-addon2" required>
                    <button class="btn btn-light text-success rounded-pill rounded-start" type="submit" id="button-addon2">Subscribe</button>
                </div>
            </div>
        </form>
    </section>

</div>

@endsection

@push('styles')
<!-- CSS for circular image and placeholder -->
<style>
    .category-image-container {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        overflow: hidden;
        margin: 0 auto;
        background: #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .category-image {
        width: 200px;
        height: 200px;
        object-fit: cover;
        border-radius: 50%;
    }

    .category-image-placeholder {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background-color: #e0e0e0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: #aaa;
    }
</style>
@endpush
