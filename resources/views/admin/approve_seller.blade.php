@extends('layouts.common_layout')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2">Seller Approval</h1>
        <div>
            <!-- First button to trigger the Add Seller modal -->
            <a href="{{ route('admin.addSeller') }}" class="btn btn-outline-primary">
                <i class="bi bi-plus-circle me-2"></i>Add Seller
            </a>

            <!-- Second button to export sellers -->
            <form action="{{ route('sellers.export') }}" method="GET" style="display: inline;">
                <button type="submit" class="btn btn-outline-primary">
                    <i class="bi bi-download me-2"></i>Export Sellers
                </button>
            </form>

        </div>

    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>S.No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>License Number</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sellers as $index => $seller)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $seller->name }}</td>
                                <td>{{ $seller->email }}</td>
                                <td>{{ $seller->license_number ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-{{ $seller->approval_status === 'approved' ? 'success' : ($seller->approval_status === 'rejected' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($seller->approval_status) }}
                                    </span>
                                </td>
                                <td>
                                    @if ($seller->approval_status === 'pending')
                                        <form action="{{ route('sellers.approve', $seller->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-success">
                                                <i class="bi bi-check-circle me-1"></i>Approve
                                            </button>
                                        </form>
                                        <form action="{{ route('sellers.reject', $seller->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-x-circle me-1"></i>Reject
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-sm btn-secondary" disabled>
                                            {{ ucfirst($seller->approval_status) }}
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Back Button -->
    <div class="d-flex justify-content-center mt-4">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-success">
            <i class="bi bi-arrow-left-circle me-2"></i>Back to Dashboard
        </a>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table th {
        font-weight: 600;
    }
    .badge {
        font-weight: 500;
    }
</style>
@endpush
