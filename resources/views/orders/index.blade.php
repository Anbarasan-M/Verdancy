@extends('layouts.common_layout')

@section('title', 'Orders List')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h2 class="mb-0">Orders</h2>
                    <form action="{{ route('orders') }}" method="GET" class="d-flex">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search by Order ID or Customer" value="{{ request('search') }}">
                            <button type="submit" class="btn btn-light">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>Order ID</th>
                                    @if (auth()->user()->role_id != 4)
                                        <th>Customer Name</th>
                                    @endif
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td><strong>#{{ $order->id }}</strong></td>
                                        @if (auth()->user()->role_id != 4)
                                            <td>{{ $order->user->name }}</td>
                                        @endif
                                        <td>
                                            <span class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'pending' ? 'warning' : ($order->status === 'shipped' ? 'info' : 'danger')) }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td>${{ number_format($order->total_amount, 2) }}</td>
                                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary" title="View Order">
                                                    <i class="bi bi-eye"></i> View
                                                </a>

                                                @if (auth()->user()->role_id == 2)
                                                    <form action="{{ route('orders.deliver', $order->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm {{ $order->status === 'shipped' ? 'btn-outline-success' : 'btn-outline-secondary' }}" {{ $order->status === 'shipped' ? '' : 'disabled' }} title="Mark as Delivered">
                                                            <i class="bi bi-check-circle"></i> Deliver
                                                        </button>
                                                    </form>
                                                @elseif (auth()->user()->role_id == 3)
                                                    <form action="{{ route('orders.ship', $order->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm {{ $order->status === 'pending' ? 'btn-outline-info' : 'btn-outline-secondary' }}" {{ $order->status === 'pending' ? '' : 'disabled' }} title="Mark as Shipped">
                                                            <i class="bi bi-truck"></i> Ship
                                                        </button>
                                                    </form>
                                                @elseif (auth()->user()->role_id == 4)
                                                    <form action="{{ route('orders.cancel', $order->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm {{ $order->status !== 'completed' ? 'btn-outline-danger' : 'btn-outline-secondary' }}" {{ $order->status !== 'completed' ? '' : 'disabled' }} title="Cancel Order">
                                                            <i class="bi bi-x-circle"></i> Cancel
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $orders->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,.12), 0 4px 8px rgba(0,0,0,.06);
}

.btn-group {
    gap: 5px; /* Creates space between buttons */
}

.btn {
    padding: 6px 12px; /* Adjusts padding for consistent sizing */
    font-size: 0.875rem; /* Slightly smaller font size for compact buttons */
    transition: background-color 0.3s ease, transform 0.2s ease; /* Adds smooth transition effects */
}

.btn:hover {
    transform: scale(1.05); /* Adds subtle scaling effect on hover */
}

</style>
@endpush
