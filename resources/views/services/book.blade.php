@extends('layouts.common_layout')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm">
                <div class="row g-0">
                    <div class="col-md-6 service-image-container">
                        @if($service->image)
                            <img src="{{ asset('storage/' . $service->image) }}" class="img-fluid service-image" alt="{{ $service->name }}">
                        @endif
                    </div>
                    <div class="col-md-6">
                        <div class="card-body p-4">
                            <h1 class="card-title h3 mb-4">{{ $service->name }}</h1>
                            <p class="text-muted mb-4">{{ $service->description }}</p>
                            <p class="fs-4 fw-bold text-primary mb-4">${{ number_format($service->price, 2) }}</p>
                            <form action="{{ route('book.service.submit', $service->id) }}" method="POST" id="bookingForm">
                                @csrf
                                <div class="mb-3">
                                    <label for="booking_date" class="form-label">Booking Date</label>
                                    <input type="date" name="booking_date" class="form-control" required id="booking_date" placeholder="Select Date" min="{{ \Carbon\Carbon::today()->toDateString() }}">
                                </div>
                                <div class="mb-3">
                                    <label for="booking_time" class="form-label">Booking Time</label>
                                    <input type="time" class="form-control" id="booking_time" name="booking_time" required placeholder="Select Time" aria-label="Select Time">
                                </div>
                                <div class="mb-4">
                                    <label for="worker_id" class="form-label">Select Worker</label>
                                    <select name="worker_id" class="form-select" required id="worker_id">
                                        <option value="" disabled selected>Select Worker</option>
                                        @foreach($workers as $worker)
                                            <option value="{{ $worker->id }}">{{ $worker->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                                    <a href="{{ route('services') }}" class="btn btn-secondary">Back</a>
                                    <button type="submit" class="btn btn-primary">Book Now</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('bookingForm').addEventListener('submit', function(event) {
        const bookingDate = document.getElementById('booking_date').value;
        const selectedDate = new Date(bookingDate);
        const today = new Date();
        today.setHours(0, 0, 0, 0); // Set time to midnight for comparison
        if (selectedDate < today) {
            alert('Please select today or a future date.');
            event.preventDefault(); // Prevent form submission
        }
    });
</script>
@endpush

@push('styles')
<style>
    body {
        background-color: #f8f9fa;
    }
    .card {
        border-radius: 8px;
        overflow: hidden;
    }
    .service-image-container {
        height: 100%;
        overflow: hidden;
    }
    .service-image {
        width: 450px;
        height: 550px;
        object-fit: cover;
    }
    .card-title {
        color: #333;
    }
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }
    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }
    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }
    .form-control, .form-select {
        border-radius: 4px;
    }
</style>
@endpush