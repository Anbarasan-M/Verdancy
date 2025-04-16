<!DOCTYPE html>
<html>
<head>
    <title>Transaction Details</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .card { border: 1px solid #ddd; padding: 20px; margin: 20px 0; }
        .card-title { font-size: 24px; font-weight: bold; margin-bottom: 10px; }
        .card-text { margin-bottom: 5px; }
    </style>
</head>
<body>
    <div class="card">
        <h5 class="card-title">Transaction ID: {{ $payment->razorpay_payment_id }}</h5>
        <p class="card-text"><strong>User:</strong> {{ $payment->user->name }}</p>
        <p class="card-text"><strong>Order ID:</strong> {{ $payment->order_id }}</p>
        <p class="card-text"><strong>Amount:</strong> {{ $payment->amount }}</p>
        <p class="card-text"><strong>Payment Method:</strong> {{ ucfirst($payment->payment_method) }}</p>
        <p class="card-text"><strong>Status:</strong> {{ ucfirst($payment->status) }}</p>
        <p class="card-text"><strong>Created At:</strong> {{ $payment->created_at }}</p>
    </div>
</body>
</html>
