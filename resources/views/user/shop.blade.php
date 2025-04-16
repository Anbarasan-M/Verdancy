@extends('layouts.common_layout')

@section('title', 'Verdancy - Our Green Collection')

@section('content')
<div class="container mt-5">
    <h1 class="text-success mb-4 text-center">Our Green Collection</h1>

    <div class="row mb-4">
        <div class="col-md-6 mb-3 mb-md-0">
            <form action="{{ route('users.shop') }}" method="GET" class="d-flex">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search plants..." value="{{ request('search') }}">
                    <select name="category" class="form-select w-auto ms-2">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-success ms-2">Apply</button>
                </div>
            </form>
        </div>
        <div class="col-md-6">
            <div class="d-flex justify-content-md-end">
                <form action="{{ route('users.shop') }}" method="GET" class="d-flex">
                    <select name="sort" id="sort" class="form-select w-auto" onchange="this.form.submit()">
                        <option value="">Sort by</option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price (Low to High)</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price (High to Low)</option>
                    </select>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        @foreach($products as $product)
        <div class="col-md-4 col-lg-3 mb-4">
            <div class="card h-100 shadow-sm border-0 rounded-lg overflow-hidden product-card">
                <div class="position-relative">
                    <img src="{{ asset('storage/' . $product->image_url) }}" class="card-img-top" alt="{{ $product->name }}" style="width: 300px; height: 150px; object-fit: cover;">
                </div>

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-success">{{ Str::limit($product->name, 15, '...') }}</h5>
                    <p class="card-text text-muted flex-grow-1">{{ Str::words($product->description, 6, '...') }}</p>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="h5 mb-0 text-success">₹{{ number_format($product->price, 2) }}</span>
                        <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="btn btn-sm btn-warning add-to-cart">Add to Cart</button>
                        </form>
                        <!-- <button class="btn btn-sm btn-outline-primary view-info" data-bs-toggle="modal" data-bs-target="#productModal" data-product-id="{{ $product->id }}">
                            <i class="fas fa-info-circle"></i>
                        </button> -->
                        <a href="{{ route('product.show', ['id' => $product->id]) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-info-circle"></i>
                        </a>
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
                <form action="{{ route('cart.add') }}" method="POST" class="d-inline" id="modal-cart-form">
                    @csrf
                    <input type="hidden" name="product_id" id="modal-product-id">
                    <button type="submit" class="btn btn-warning">Add to Cart</button>
                </form>
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
            const modalContent = document.getElementById('product-details-content');

            // Show loading spinner
            modalContent.innerHTML = '<div class="text-center"><div class="spinner-border text-success" role="status"><span class="visually-hidden">Loading...</span></div></div>';

            // AJAX request to fetch product details
            fetch(`/api/products/${productId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    modalContent.innerHTML = `
                        <h4 class="text-success mb-3">${data.name}</h4>
                        <img src="${data.image_url}" alt="${data.name}" class="img-fluid mb-3">
                        <p>${data.description}</p>
                        <p><strong>Price:</strong> ₹${data.price.toFixed(2)}</p>
                        <p><strong>Care Level:</strong> ${data.care_level}</p>
                        <p><strong>Light Requirements:</strong> ${data.light_requirements}</p>
                        <p><strong>Watering Frequency:</strong> ${data.watering_frequency}</p>
                    `;
                    document.getElementById('modal-product-id').value = data.id;
                })
                .catch(error => {
                    console.error('Error fetching product details:', error);
                    modalContent.innerHTML = '<p class="text-danger">Error loading product details. Please try again.</p>';
                });
        });
    });
</script>
@endpush
