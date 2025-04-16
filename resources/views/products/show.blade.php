@extends('layouts.common_layout')

@section('title', 'Product Details')

@section('content')
<div class="container my-5">
    <div class="row g-5">
        <div class="col-lg-6">
            <div class="position-sticky" style="top: 2rem;">
                <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}" class="img-fluid rounded-3 shadow-lg" style="width: 600px; height: 400px; object-fit: cover;">
            </div>
        </div>
        <div class="col-lg-6">
            <h1 class="display-4 fw-bold text-success mb-4">{{ $product->name }}</h1>
            <p class="lead mb-4">{{ $product->description }}</p>
            
            <div class="bg-light p-4 rounded-3 shadow-sm mb-4">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <h5 class="fw-bold">Price</h5>
                        <p class="h3 text-primary">₹{{ number_format($product->price, 2) }}</p>
                    </div>
                    <div class="col-sm-6">
                        <h5 class="fw-bold">Category</h5>
                        <p class="h5">{{ $product->category->name ?? 'N/A' }}</p>
                    </div>

                    <!-- <div class="col-sm-6">
                        <h5 class="fw-bold">Light Requirements</h5>
                        <p>{{ $product->light_requirements }}</p>
                    </div>
                    <div class="col-sm-6">
                        <h5 class="fw-bold">Watering Frequency</h5>
                        <p>{{ $product->watering_frequency }}</p>
                    </div> -->
                </div>
            </div>
            
            <div class="d-grid gap-3 d-sm-flex justify-content-sm-start">
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit" class="btn btn-warning btn-lg px-4 me-sm-3">
                        <i class="fas fa-shopping-cart me-2"></i> Add to Cart
                    </button>
                </form>
                <a href="{{ route('users.shop') }}" class="btn btn-secondary btn-lg px-4">
                    <i class="fas fa-arrow-left me-2"></i> Keep Exploring
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    body {
        background-color: #f8f9fa;
    }
    .btn-lg {
        font-size: 1.1rem;
    }
</style>
@endpush
