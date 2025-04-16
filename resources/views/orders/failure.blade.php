@extends('layouts.common_layout')

@section('content')
<div class="container">
    <h2>Order Failed</h2>
    <p>We're sorry, but your order could not be processed.</p>
    
    <h3>Error Details:</h3>
    <p>{{ session('error_message', 'An unknown error occurred. Please try again.') }}</p>

    <p>If you believe this is a mistake, please contact our support team.</p>
    
    <h3>What you can do:</h3>
    <ul>
        <li><a href="{{ route('users.shop') }}">Return to Shop</a></li>
        <li><a href="{{ route('orders') }}">View My Orders</a></li>
    </ul>
</div>
@endsection
