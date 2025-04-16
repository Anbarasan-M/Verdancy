<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Your Payment</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        .payment-container {
            max-width: 600px;
            margin: 40px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .payment-title {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-size: 24px;
        }

        .order-details {
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
        }

        .order-details h3 {
            margin-top: 0;
            color: #333;
            font-size: 18px;
        }

        .total-amount {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 18px;
            margin-top: 15px;
        }

        .total-amount strong {
            font-size: 22px;
            color: #4CAF50;
        }

        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .alert-danger {
            background-color: #ffebee;
            color: #c62828;
            border: 1px solid #ef9a9a;
        }

        .alert-success {
            background-color: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #a5d6a7;
        }

        #payment-form {
            text-align: center;
            margin-bottom: 20px;
        }

        .pay-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .pay-button:hover {
            background-color: #45a049;
        }

        .cancel-button {
            display: block;
            text-align: center;
            color: #f44336;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .cancel-button:hover {
            color: #d32f2f;
        }
    </style>
</head>

<body>
    <div class="payment-container">
        <h2 class="payment-title">Complete Your Payment</h2>

        <!-- Order Details Section -->
        <div class="order-details">
            <h3>Order Summary</h3>
            <div class="total-amount">
                <span>Total Amount:</span>
                <strong>₹{{ number_format($totalAmount, 2) }}</strong>
            </div>
        </div>

        <!-- Error and Success Messages -->
        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <!-- Payment Form -->
        <form id="payment-form" method="POST" action="{{ route('make.payment') }}">
            @csrf
            <input type="hidden" name="amount" value="{{ $totalAmount * 100 }}">
            <button type="button" id="rzp-button1" class="pay-button">Pay Now</button>
        </form>

        <a href="{{ route('cart.index') }}" class="cancel-button">Cancel</a>
    </div>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        var options = {
            "key": "{{ env('RAZORPAY_KEY_ID') }}",
            "amount": document.querySelector('input[name="amount"]').value,
            "currency": "INR",
            "name": "Verdancy",
            "description": "Order Description",
            "image": "{{ asset('images/payment_logo.jpg') }}",
            "handler": function (response) {
                var form = document.getElementById('payment-form');
                form.appendChild(createHiddenInput('razorpay_payment_id', response.razorpay_payment_id));
                form.appendChild(createHiddenInput('razorpay_order_id', response.razorpay_order_id));
                form.appendChild(createHiddenInput('razorpay_signature', response.razorpay_signature));
                form.action = "{{ route('complete.payment') }}";
                form.submit();
            },
            "prefill": {
                "name": "{{ auth()->user()->name }}",
                "email": "{{ auth()->user()->email }}",
                "contact": "{{ auth()->user()->phone_number }}"
            },
            "theme": {
                "color": "#4CAF50"
            }
        };

        function createHiddenInput(name, value) {
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = value;
            return input;
        }

        document.getElementById('rzp-button1').onclick = function (e) {
            var rzp1 = new Razorpay(options);
            rzp1.open();
            e.preventDefault();
        };
    </script>
</body>

</html>
