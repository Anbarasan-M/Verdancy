<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order #{{ $order->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        .container {
            background-color: #fff;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1, h3 {
            text-align: center;
            color: #4CAF50;
        }
        p {
            margin: 10px 0;
        }
        .details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }
        .details div {
            flex-basis: 45%;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fafafa;
        }
        .table, .table th, .table td {
            border: 1px solid #ddd;
        }
        .table th, .table td {
            padding: 12px;
            text-align: left;
        }
        .table th {
            background-color: #4CAF50;
            color: white;
        }
        .total {
            text-align: right;
            font-weight: bold;
            font-size: 16px;
        }
        .payment-info {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
        }
        .payment-info h3 {
            margin-bottom: 10px;
            font-size: 18px;
            color: #333;
        }
        .badge {
            display: inline-block;
            padding: 5px 10px;
            font-size: 12px;
            border-radius: 4px;
        }
        .badge-success {
            background-color: #28a745;
            color: white;
        }
        .badge-warning {
            background-color: #ffc107;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Order #{{ $order->id }}</h1>
        
        <div class="details">
            <div>
                <p><strong>Customer:</strong> {{ $order->user->name }}</p>
                <p><strong>Email:</strong> {{ $order->user->email }}</p>
            </div>
            <div>
                <p><strong>Order Status:</strong> 
                    <span class="badge badge-{{ $order->status === 'completed' ? 'success' : 'warning' }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </p>
                <p><strong>Total Amount:</strong> ${{ number_format($order->total_amount, 2) }}</p>
            </div>
        </div>

        <h3>Order Items</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->category->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format($item->price, 2) }}</td>
                        <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total">
            <p>Total: ${{ number_format($order->total_amount, 2) }}</p>
        </div>

        <!-- Payment Information Section -->
        <div class="payment-info">
            <h3>Payment Information</h3>
            @if($order->payment)
            <p><strong>Razorpay Payment ID:</strong> {{ $order->payment->razorpay_payment_id ?? 'N/A' }}</p>
            <p><strong>Payment Method:</strong> {{ ucfirst($order->payment->payment_method) }}</p>
            <p><strong>Payment Status:</strong> {{ ucfirst($order->payment->status) }}</p>
            @else
            <p>No payment information available.</p>
            @endif
        </div>
    </div>
</body>
</html>
