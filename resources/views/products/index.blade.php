@extends('layouts.common_layout')

@section('title', 'Verdancy - Our Green Collection')

@section('content')
<div class="container mt-5">
    <h1 class="text-success mb-4 text-center">Our Green Collection</h1>

    <div class="row mb-4">
        <div class="col-md-6 mb-3 mb-md-0">
            <form action="{{ route('products.index') }}" method="GET" class="d-flex">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search plants..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
        <div class="col-md-6">
            <div class="d-flex justify-content-md-end">
                <select name="sort" id="sort" class="form-select w-auto" onchange="this.form.submit()">
                    <option value="">Sort by</option>
                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price (Low to High)</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price (High to Low)</option>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        @foreach($products as $product)
        <div class="col-md-4 col-lg-3 mb-4">
            <div class="card h-100 shadow-sm border-0 rounded-lg overflow-hidden product-card">
                <div class="position-relative">
                    <img src="{{ asset('storage/' . $product->image_url) }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-img-overlay d-flex justify-content-end align-items-start">
                        <button class="btn btn-sm btn-warning rounded-circle add-to-cart" data-product-id="{{ $product->id }}">
                            <i class="fas fa-cart-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-success">{{ $product->name }}</h5>
                    <p class="card-text text-muted flex-grow-1">{{ Str::limit($product->description, 80) }}</p>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="h5 mb-0 text-success">${{ number_format($product->price, 2) }}</span>
                        <button class="btn btn-sm btn-outline-success buy-now" data-product-id="{{ $product->id }}">Buy</button>
                        <button class="btn btn-sm btn-outline-secondary view-info" data-bs-toggle="modal" data-bs-target="#productModal" data-product-id="{{ $product->id }}">
                            <i class="fas fa-info-circle"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $products->links('pagination::bootstrap-4') }}
    </div>
</div>

<!-- Product Info Modal -->
<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-success" id="productModalLabel">Product Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="product-details-content"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .product-card .card-title {
    color: black;
    }

    .product-card .card-text {
        color: black;
    }

    .product-card .text-success {
        color: black !important;
    }

    .product-card {
        transition: all 0.3s ease;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    .card-img-overlay {
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .product-card:hover .card-img-overlay {
        opacity: 1;
    }
    .add-to-cart, .buy-now, .view-info {
        width: 40px;
        height: 40px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .pagination {
        justify-content: center;
    }
    .page-item.active .page-link {
        background-color: #2c3e50;
        border-color: #2c3e50;
    }
    .page-link {
        color: #2c3e50;
    }
    .page-link:hover {
        color: #1e2828;
    }
</style>
@endpush

@push('scripts')
<script>
    // View Info button logic
    document.querySelectorAll('.view-info').forEach(button => {
        button.addEventListener('click', function(e) {
            const productId = this.getAttribute('data-product-id');
            const modal = document.getElementById('productModal');
            const modalContent = document.getElementById('product-details-content');

            // Show loading spinner
            modalContent.innerHTML = '<div class="text-center"><div class="spinner-border text-success" role="status"><span class="visually-hidden">Loading...</span></div></div>';

            // AJAX request to fetch product details
            fetch(`/api/products/${productId}`)
                .then(response => response.json())
                .then(data => {
                    modalContent.innerHTML = `
                        <h4 class="text-success mb-3">${data.name}</h4>
                        <img src="${data.image_url}" alt="${data.name}" class="img-fluid mb-3">
                        <p>${data.description}</p>
                        <p><strong>Price:</strong> $${data.price.toFixed(2)}</p>
                        <p><strong>Care Level:</strong> ${data.care_level}</p>
                        <p><strong>Light Requirements:</strong> ${data.light_requirements}</p>
                        <p><strong>Watering Frequency:</strong> ${data.watering_frequency}</p>
                    `;
                })
                .catch(error => {
                    console.error('Error fetching product details:', error);
                    modalContent.innerHTML = '<p class="text-danger">Error loading product details. Please try again.</p>';
                });
        });
    });

    // Add to Cart button logic
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.getAttribute('data-product-id');
            // Add your cart logic here
            Swal.fire({
                title: 'Success!',
                text: 'Product added to cart',
                icon: 'success',
                confirmButtonText: 'OK',
                confirmButtonColor: '#2c3e50'
            });
        });
    });

    // Buy Now button logic
    document.querySelectorAll('.buy-now').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.getAttribute('data-product-id');
            // Add your buy logic here (e.g., redirect to checkout page)
            Swal.fire({
                title: 'Purchase Successful!',
                text: 'Thank you for buying this product!',
                icon: 'success',
                confirmButtonText: 'OK',
                confirmButtonColor: '#2c3e50'
            });
        });
    });

    // View Info button logic
    document.querySelectorAll('.view-info').forEach(button => {
        button.addEventListener('click', function(e) {
            const productId = this.getAttribute('data-product-id');
            // AJAX request to fetch product details (use fetch API or jQuery's $.ajax)
            fetch(`/products/${productId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('product-details-content').innerHTML = `
                        <h5>${data.name}</h5>
                        <p>${data.description}</p>
                        <p><strong>Price:</strong> $${data.price}</p>
                    `;
                })
                .catch(error => console.error('Error fetching product details:', error));
        });
    });
</script>
@endpush
