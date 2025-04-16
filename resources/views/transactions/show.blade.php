@extends('layouts.common_layout')

@section('content')
<div class="container">
    <h1>Transaction Details</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Transaction ID: {{ $payment->razorpay_payment_id }}</h5>
            <p class="card-text"><strong>User:</strong> {{ $payment->user->name }}</p>
            <p class="card-text"><strong>Order ID:</strong> {{ $payment->order_id }}</p>
            <p class="card-text"><strong>Amount:</strong> {{ $payment->amount }}</p>
            <p class="card-text"><strong>Payment Method:</strong> {{ ucfirst($payment->payment_method) }}</p>
            <p class="card-text"><strong>Status:</strong> {{ ucfirst($payment->status) }}</p>
            <p class="card-text"><strong>Payment At:</strong> {{ $payment->created_at }}</p>
        </div>
    </div>

    <a href="{{ route('transactions.index') }}" class="btn btn-secondary mt-3">Back to Transactions</a>
    <a href="{{ route('transactions.pdf', $payment->id) }}" class="btn btn-primary mt-3">Download as PDF</a> <!-- PDF Button -->
</div>
@endsection
