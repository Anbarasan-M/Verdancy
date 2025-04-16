@extends('layouts.common_layout')

@section('content')
<div class="container py-4">
    <h1 class="mb-4 text-center">Leave Requests</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h2 class="h5 mb-0">Pending Leave Requests</h2>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Service Provider</th>
                            <th>Leave Date</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingLeaves as $leave)
                        <tr>
                            <td>{{ $leave->id }}</td>
                            <td>{{ $leave->serviceProvider->name }}</td>
                            <td>{{ $leave->leave_date }}</td>
                            <td>{{ $leave->reason }}</td>
                            <td><span class="badge bg-warning text-dark">Pending</span></td>
                            <td>
                                <form action="{{ route('admin.leaves.approve', $leave->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-success btn-sm">Approve</button>
                                </form>
                                <form action="{{ route('admin.leaves.reject', $leave->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm">Reject</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-success text-white">
            <h2 class="h5 mb-0">Approved Leave Requests</h2>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Service Provider</th>
                            <th>Leave Date</th>
                            <th>Reason</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($approvedLeaves as $leave)
                        <tr>
                            <td>{{ $leave->id }}</td>
                            <td>{{ $leave->serviceProvider->name }}</td>
                            <td>{{ $leave->leave_date }}</td>
                            <td>{{ $leave->reason }}</td>
                            <td><span class="badge bg-success">Approved</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-danger text-white">
            <h2 class="h5 mb-0">Rejected Leave Requests</h2>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Service Provider</th>
                            <th>Leave Date</th>
                            <th>Reason</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rejectedLeaves as $leave)
                        <tr>
                            <td>{{ $leave->id }}</td>
                            <td>{{ $leave->serviceProvider->name }}</td>
                            <td>{{ $leave->leave_date }}</td>
                            <td>{{ $leave->reason }}</td>
                            <td><span class="badge bg-danger">Rejected</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
