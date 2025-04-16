@extends('layouts.common_layout')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-5 text-success">Your Bookings</h1>

    @if($bookings->isEmpty())
        <div class="alert alert-info text-center" role="alert">
            <i class="fas fa-info-circle me-2"></i>No bookings found.
        </div>
    @else
        <div class="list-group">
            @foreach($bookings as $booking)
                <div class="list-group-item p-4 mb-3 shadow-sm border-0">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5>{{ $booking->service->name }}</h5>
                            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</p>
                            <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($booking->booking_time)->format('h:i A') }}</p>
                            
                            {{-- Booking Status --}}
                            <p>
                                <strong>Status:</strong>
                                @if ($booking->status == 'pending')
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-hourglass-half"></i> Pending
                                    </span>
                                @elseif ($booking->status == 'confirmed')
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle"></i> Confirmed
                                    </span>
                                @elseif ($booking->status == 'cancelled')
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times-circle"></i> Cancelled
                                    </span>
                                @elseif ($booking->status == 'completed')
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-check-circle"></i> Completed
                                    </span>
                                @endif
                            </p>
                        </div>

                        {{-- Action Buttons (Cancel and Mark as Completed) --}}
                        <div class="d-flex flex-column align-items-end">
                            {{-- Cancel Button --}}
                            @if($booking->status == 'pending')
                                <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST" class="mb-2">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-outline-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to cancel this booking?');">
                                        Cancel Booking
                                    </button>
                                </form>
                            @endif

                            {{-- Mark as Completed Button --}}
                            @if($booking->status == 'confirmed')
                                <form action="{{ route('bookings.complete', $booking->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-success btn-sm"
                                            onclick="return confirm('Are you sure you want to mark this booking as completed?');">
                                        Mark as Completed
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
