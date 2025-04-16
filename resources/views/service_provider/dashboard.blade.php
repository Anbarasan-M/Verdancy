@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Service Provider Dashboard</h2>

    {{-- Today's Bookings Count --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">Today's Bookings</h5>
                    <h2 class="card-text">{{ $todayBookingsCount }}</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- Links to Bookings and Apply Leave --}}
    <div class="row">
        <div class="col-md-6">
            <a href="{{ route('service_provider.bookings') }}" class="btn btn-primary btn-lg btn-block">
                View All Bookings
            </a>
        </div>
        <div class="col-md-6">
            <a href="{{ route('service_provider.leave') }}" class="btn btn-danger btn-lg btn-block">
                Apply for Leave
            </a>
        </div>
    </div>
</div>
@endsection
