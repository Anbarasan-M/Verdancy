@extends('layouts.common_layout')

@section('content')
<div class="container">
    <h2>Order Placed Successfully!</h2>
    <p>Order ID: {{ $order->id }}</p>
    <p>Total Amount: ₹{{ number_format($order->total_amount) }}</p> <!-- Amount in INR -->
    <p>Payment ID: {{ session('payment_id') }}</p>

    <h3>Items in your Order:</h3>
    <ul>
        @foreach ($order->orderItems as $item)
            <li>{{ $item->product->name }} - Quantity: {{ $item->quantity }} - Price: ₹{{ number_format($item->price) }}</li>
            <li><img src="{{ asset('storage/' . $item->product->image_url) }}" alt="{{ $item->product->name }}" class="img-thumbnail mr-3" style="width: 80px;"></li>
        @endforeach
    </ul>
    <a href="{{ route('orders') }}" class="cancel-button">Go to orders</a>
</div>
@endsection

@push('styles')
<style>
.cancel-button {
    display: inline-block; /* Keeps the button behavior */
    text-align: center;
    color: #ffffff; /* Text color */
    background-color: #4CAF50; /* Green background */
    padding: 12px 30px; /* Padding for size */
    border-radius: 25px; /* Pill shape */
    text-decoration: none;
    font-weight: bold;
    transition: background-color 0.3s ease, color 0.3s ease; /* Transition for background color */
}

.cancel-button:hover {
    background-color: #45a049; /* Darker green shade for hover effect */
}

</style>
@endpush