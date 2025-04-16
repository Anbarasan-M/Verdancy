@extends('layouts.common_layout')

@section('content')
<div class="container my-5">
    <h1 class="mb-4 text-center">Order Details</h1>

    <div class="card shadow-lg mb-5">
        <div class="card-header bg-primary text-white py-3">
            <h3 class="mb-0">Order #{{ $order->id }}</h3>
        </div>
        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="bg-light p-4 rounded h-100">
                        <h5 class="card-title text-primary mb-3">Customer Information</h5>
                        <p class="mb-2"><i class="fas fa-user me-2"></i><strong>Name:</strong> {{ $order->user->name }}</p>
                        <p class="mb-0"><i class="fas fa-envelope me-2"></i><strong>Email:</strong> {{ $order->user->email }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="bg-light p-4 rounded h-100">
                        <h5 class="card-title text-primary mb-3">Order Information</h5>
                        <p class="mb-2">
                            <i class="fas fa-info-circle me-2"></i><strong>Status:</strong> 
                            <span class="badge bg-{{ $order->status === 'completed' ? 'success' : 'warning' }} px-3 py-2">{{ ucfirst($order->status) }}</span>
                        </p>
                        <p class="mb-0"><i class="fas fa-dollar-sign me-2"></i><strong>Total Amount:</strong> ₹{{ number_format($order->total_amount, 2) }}</p>
                    </div>
                </div>
            </div>

            @if($order->payment)
            <div class="row mt-4">
                <div class="col-12">
                    <div class="bg-light p-4 rounded">
                        <h5 class="card-title text-primary mb-3">Payment Information</h5>
                        <p class="mb-2"><i class="fas fa-credit-card me-2"></i><strong>Payment ID:</strong> {{ $order->payment->razorpay_payment_id ?? 'N/A' }}</p>
                        <p class="mb-2"><i class="fas fa-money-bill-wave me-2"></i><strong>Payment Method:</strong> {{ ucfirst($order->payment->payment_method) }}</p>
                        <p class="mb-0"><i class="fas fa-check-circle me-2"></i><strong>Payment Status:</strong> {{ ucfirst($order->payment->status) }}</p>
                    </div>
                </div>
            </div>
            @else
            <div class="alert alert-warning mt-4" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>No payment information available for this order.
            </div>
            @endif
        </div>
    </div>

    <h3 class="mb-4 text-primary">Order Items</h3>

    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead class="table-primary">
                <tr>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('storage/' . $item->product->image_url) }}" alt="{{ $item->product->name }}" class="img-thumbnail me-3" style="width: 60px; height: 60px; object-fit: cover;">
                            <span>{{ $item->product->name }}</span>
                        </div>
                    </td>
                    <td>{{ $item->category->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>₹{{ number_format($item->price, 2) }}</td>
                    <td>₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-5 d-flex justify-content-between">
        <a href="{{ route('orders') }}" class="btn btn-outline-primary btn-lg">
            <i class="fas fa-arrow-left me-2"></i>Back to Orders
        </a>
        <a href="{{ route('order.pdf', $order->id) }}" class="btn btn-primary btn-lg">
            <i class="fas fa-file-pdf me-2"></i>Download PDF
        </a>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table th, .table td {
        vertical-align: middle;
    }
    .card {
        border: none;
        transition: all 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .badge {
        font-size: 0.9rem;
    }
    .btn-lg {
        padding: 0.75rem 1.5rem;
    }
</style>
@endpush
