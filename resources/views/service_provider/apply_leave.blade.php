@extends('layouts.common_layout')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Leave Management</h2>

    <div class="row">
        {{-- Apply for Leave Form Card --}}
        <div class="col-md-6">
            <div class="card shadow-sm border-light mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Apply for Leave</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('serviceProvider.leave.apply') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="leave_date">Leave Date</label>
                            <input type="date" class="form-control" id="leave_date" name="leave_date" required min="{{ \Carbon\Carbon::today()->toDateString() }}">
                        </div>
                        <div class="form-group">
                            <label for="leave_reason">Reason for Leave</label>
                            <textarea class="form-control" id="leave_reason" name="leave_reason" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger mt-3">Submit Leave Request</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Leave Requests Card --}}
        <div class="col-md-6">
            <div class="card shadow-sm border-light mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Your Leave Requests</h5>
                </div>
                <div class="card-body">
                    @if($leaveRequests->isEmpty())
                        <p class="text-center">You have no leave requests.</p>
                    @else
                        <table class="table table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($leaveRequests as $leave)
                                    <tr>
                                        <td>{{ $leave->leave_date }}</td>
                                        <td>{{ $leave->reason }}</td>
                                        <td>
                                            @if ($leave->status == 0)
                                                <span class="badge bg-warning text-dark">
                                                    <i class="fas fa-hourglass-half"></i> Pending
                                                </span>
                                            @elseif ($leave->status == 1)
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check-circle"></i> Approved
                                                </span>
                                            @elseif ($leave->status == 2)
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-times-circle"></i> Rejected
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">Unknown</span>
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
    
    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }
</style>
@endsection
