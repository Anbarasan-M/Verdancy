@extends('layouts.common_layout')

@section('title', 'Your Cart')

@section('content')
<div class="container my-5">
    <h1 class="text-primary mb-4 font-weight-bold">Your Shopping Cart</h1>

    @if($cartItems->isEmpty())
        <div class="alert alert-info" role="alert">
            <i class="fas fa-shopping-cart mr-2"></i> Your cart is empty. <a href="{{ route('users.shop') }}" class="alert-link">Start shopping now!</a>
        </div>
    @else
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th scope="col">Product</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Price</th>
                                <th scope="col">Total</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('storage/' . $item->product->image_url) }}" alt="{{ $item->product->name }}" class="img-thumbnail mr-3" style="width: 80px;">
                                        <span>{{ $item->product->name }}</span>
                                    </div>
                                </td>
                                <td>{{ $item->quantity }}</td>
                                <td>${{ number_format($item->product->price, 2) }}</td>
                                <td>${{ number_format($item->quantity * $item->product->price, 2) }}</td>
                                <td>
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                            <i class="fas fa-trash-alt"></i> Remove
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="text-right mt-4">
                    <h4 class="mb-3">Grand Total: <span class="text-primary">₹{{ number_format($total, 2) }}</span></h4>
                    <a href="{{ route('payment.form', ['amount' => $total * 100]) }}" class="btn btn-warning btn-lg">
                        <i class="fas fa-credit-card mr-2"></i> Proceed to Pay
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .table th {
        font-weight: 600;
    }
    .btn-outline-danger:hover {
        color: #fff;
    }
    .btn-warning {
        color: #000;
        background-color: #ffc107;
        border-color: #ffc107;
    }
    .btn-warning:hover {
        color: #000;
        background-color: #ffca2c;
        border-color: #ffc720;
    }
</style>
@endpush
