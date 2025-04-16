@extends('layouts.common_layout')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h2 mb-0">Service Provider Approval</h1>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="{{ route('admin.addServiceProvider') }}" class="btn btn-outline-primary">
                <i class="bi bi-plus-circle me-2"></i>Add Provider
            </a>
            <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#importModal">
                <i class="bi bi-upload me-2"></i>Import Providers
            </button>
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
                <table class="table table-hover align-middle">
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
                        @foreach ($serviceProviders as $index => $provider)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $provider->name }}</td>
                                <td>{{ $provider->email }}</td>
                                <td>{{ $provider->license_number ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-{{ $provider->approval_status === 'approved' ? 'success' : ($provider->approval_status === 'rejected' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($provider->approval_status) }}
                                    </span>
                                </td>
                                <td>
                                    @if ($provider->approval_status === 'pending')
                                        <div class="btn-group" role="group">
                                            <form action="{{ route('serviceProviders.approve', $provider->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-success">
                                                    <i class="bi bi-check-circle me-1"></i>Approve
                                                </button>
                                            </form>
                                            <form action="{{ route('serviceProviders.reject', $provider->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="bi bi-x-circle me-1"></i>Reject
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <button class="btn btn-sm btn-secondary" disabled>
                                            {{ ucfirst($provider->approval_status) }}
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
    
    <div class="text-center mt-4">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-success">
            <i class="bi bi-arrow-left-circle me-2"></i>Back to Dashboard
        </a>
    </div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import Service Providers</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('serviceProviders.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="file" class="form-label">Upload Excel File</label>
                        <input type="file" name="file" class="form-control" id="file" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>
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
    .btn-group .btn {
        border-radius: 0;
    }
    .btn-group .btn:first-child {
        border-top-left-radius: 0.25rem;
        border-bottom-left-radius: 0.25rem;
    }
    .btn-group .btn:last-child {
        border-top-right-radius: 0.25rem;
        border-bottom-right-radius: 0.25rem;
    }
</style>
@endpush
