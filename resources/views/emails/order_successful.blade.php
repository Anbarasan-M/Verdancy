<!DOCTYPE html>
<html>
<head>
    <title>Order Placed Successfully</title>
</head>
<body>
    <h1>Order Placed Successfully</h1>
    <p>Dear {{ $order->user->name }},</p>
    <p>Your order (ID: {{ $order->id }}) has been placed successfully. The total amount is ${{ $order->total_amount }}.</p>

    <p>Here are the details of your order:</p>
    <ul>
        @foreach ($order->orderItems as $item)
            <li>{{ $item->product->name }} (Quantity: {{ $item->quantity }}) - ${{ $item->price}}</li>
        @endforeach
    </ul>

    <p>Thank you for shopping with us!</p>
</body>
</html>
