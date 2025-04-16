@extends('layouts.common_layout')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-5 text-success">Our Services</h1>

    @if($services->isEmpty())
        <div class="alert alert-info text-center" role="alert">
            <i class="fas fa-info-circle me-2"></i>No services available at the moment. Check back soon!
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-4 g-4"> <!-- Updated to show 4 services per row -->
            @foreach($services as $service)
                <div class="col">
                    <div class="card h-100 shadow-sm border-0 service-card">
                        <img src="{{ asset('storage/' . $service->image) }}" class="card-img-top" alt="{{ $service->name }}">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-success">{{ $service->name }}</h5>
                            <p class="card-text flex-grow-1">{{ Str::limit($service->description, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="price-tag" style="color: #383242;">₹{{ number_format($service->price, 2) }}</span>
                            <a href="{{ route('book.service', $service->id) }}" class="btn btn-warning">Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    body {
        background-color: #f8f9fa;
    }
    .service-card {
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        border-radius: 15px;
        overflow: hidden;
    }
    .service-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .service-card .card-img-top {
        height: 200px;
        object-fit: cover;
    }
    .card-title {
        font-size: 1.25rem;
        font-weight: 600;
    }
    .price-tag {
        font-size: 1.25rem;
        font-weight: bold;
        color: #28a745;
    }
    .btn-outline-success {
        border-width: 2px;
        border-radius: 25px;
        padding: 0.375rem 1.5rem;
    }
    .btn-outline-success:hover {
        background-color: #28a745;
        color: white;
    }
</style>
@endpush
