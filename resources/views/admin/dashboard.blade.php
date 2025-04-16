@extends('layouts.common_layout')

@section('content')
<div class="container-fluid py-5 bg-light">
    <div class="row row-cols-1 row-cols-md-2 g-4">
        <!-- Active Sellers Card -->
        <div class="col mb-4">
            <a href="{{ route('sellers.index') }}" class="text-decoration-none">
                <div class="card h-100 shadow-lg border-0 rounded-lg overflow-hidden">
                    <div class="card-body position-relative p-0">
                        <img src="{{ asset('images/sellers.jpg') }}" alt="Sellers" class="card-img-top" style="height: 250px; object-fit: cover;">
                        <div class="card-img-overlay d-flex flex-column justify-content-end bg-dark bg-opacity-50 text-white p-4">
                            <h5 class="card-title mb-0">Active Sellers</h5>
                            <p class="card-text display-4 fw-bold mb-2">{{ $activeSellers }}</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Active Service Providers Card -->
        <div class="col mb-4">
            <a href="{{ route('serviceProviders.index') }}" class="text-decoration-none">
                <div class="card h-100 shadow-lg border-0 rounded-lg overflow-hidden">
                    <div class="card-body position-relative p-0">
                        <img src="{{ asset('images/service-providers.jpg') }}" alt="Service Providers" class="card-img-top" style="height: 250px; object-fit: cover;">
                        <div class="card-img-overlay d-flex flex-column justify-content-end bg-dark bg-opacity-50 text-white p-4">
                            <h5 class="card-title mb-0">Active Service Providers</h5>
                            <p class="card-text display-4 fw-bold mb-2">{{ $activeServiceProviders }}</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Products Card -->
        <div class="col mb-4">
            <a href="{{ route('admin.stocks') }}" class="text-decoration-none">
                <div class="card h-100 shadow-lg border-0 rounded-lg overflow-hidden">
                    <div class="card-body position-relative p-0">
                        <img src="{{ asset('images/products.jpg') }}" alt="Products" class="card-img-top" style="height: 250px; object-fit: cover;">
                        <div class="card-img-overlay d-flex flex-column justify-content-end bg-dark bg-opacity-50 text-white p-4">
                            <h5 class="card-title mb-0">Products</h5>
                            <p class="card-text display-4 fw-bold mb-2">{{ $productsCount }}</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Services Card -->
        <div class="col mb-4">
            <a href="{{ route('admin.services') }}" class="text-decoration-none">
                <div class="card h-100 shadow-lg border-0 rounded-lg overflow-hidden">
                    <div class="card-body position-relative p-0">
                        <img src="{{ asset('images/services.jpg') }}" alt="Services" class="card-img-top" style="height: 250px; object-fit: cover;">
                        <div class="card-img-overlay d-flex flex-column justify-content-end bg-dark bg-opacity-50 text-white p-4">
                            <h5 class="card-title mb-0">Services</h5>
                            <p class="card-text display-4 fw-bold mb-2">{{ $servicesCount }}</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
