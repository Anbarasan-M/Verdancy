@extends('layouts.common_layout')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Your Bookings</h2>

    {{-- All Bookings --}}
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm border-light">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Booking List</h5>
                </div>
                <div class="card-body">
                    @if($bookings->isEmpty())
                        <p class="text-center">You have no bookings yet.</p>
                    @else
                        <table class="table table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Customer</th>
                                    <th>Service</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $booking)
                                    <tr>
                                        <td>{{ $booking->user->name }}</td>
                                        <td>{{ $booking->service->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($booking->booking_time)->format('h:i A') }}</td>
                                        <td>
                                            @if ($booking->status == 'pending')
                                                <span class="badge bg-warning text-dark">
                                                    <i class="fas fa-hourglass-half"></i> Pending
                                                </span>
                                            @elseif ($booking->status == 'confirmed')
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check-circle"></i> Approved
                                                </span>
                                            @elseif ($booking->status == 'cancelled')
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-times-circle"></i> Cancelled
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">Completed</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($booking->status == 'pending')
                                                {{-- Confirm Booking --}}
                                                <form action="{{ route('bookings.confirm', $booking->id) }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-success btn-sm"
                                                            onclick="return confirm('Are you sure you want to confirm this booking?');">
                                                        Confirm
                                                    </button>
                                                </form>
                                                
                                                {{-- Cancel Booking --}}
                                                <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Are you sure you want to cancel this booking?');">
                                                        Cancel
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom Styles */
    .card {
        border-radius: 15px;
    }
    
    .card-header {
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }
    
    .badge {
        border-radius: 12px;
    }

    .table-hover tbody tr:hover {
        background-color: #f8f9fa; /* Change the hover color */
    }
</style>
@endsection
