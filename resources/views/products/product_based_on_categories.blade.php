@extends('layouts.common_layout')

@section('title', 'Category - ' . $category->name)

@section('content')
<div class="container mt-5">
    <h1 class="text-center text-dark mb-4">{{ $category->name }}</h1>
    <p class="text-center text-muted mb-5">Browse through our {{ $category->name }} collection.</p>

    <div class="row">
        @if ($products->count() > 0)
            @foreach ($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow border-0 rounded-lg overflow-hidden">
                <img src="{{ asset('storage/' . $product->image_url) }}" class="card-img-top" alt="{{ $product->name }}" style="width: 300px; height: 150px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title text-dark">{{ $product->name }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($product->description, 45) }}</p>
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
        @else
            <div class="col-12 text-center">
                <p class="text-muted">No products available in this category.</p>
            </div>
        @endif
    </div>
</div>
@endsection
