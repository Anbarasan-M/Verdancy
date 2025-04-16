<?php

class Draft extends Controller{
    public function buyFromCart()
    {
        // Get the logged-in user
        $user = auth()->user();
    
        // Fetch user's cart items
        $cartItems = Cart::where('user_id', $user->id)->get();
    
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Cart is empty');
        }
    
        // Calculate the total amount
        $totalAmount = 0;
        foreach ($cartItems as $item) {
            $product = Product::find($item->product_id);
            $totalAmount += $product->price * $item->quantity;
        }
    
        // Create an order
        DB::beginTransaction();
        try {
            $order = new Order();
            $order->user_id = $user->id;
            $order->total_amount = $totalAmount;
            $order->status = 'pending';
            $order->save();
    
            // Add order items
            foreach ($cartItems as $item) {
                $product = Product::find($item->product_id);
    
                // Reduce product stock
                if ($product->stock < $item->quantity) {
                    throw new \Exception("Not enough stock for product: {$product->name}");
                }
    
                $product->stock -= $item->quantity;
                $product->save();
    
                // Create order item
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'category_id' => $item->category_id,
                    'quantity' => $item->quantity,
                    'price' => $product->price,
                ]);
            }
    
            // Clear the user's cart
            Cart::where('user_id', $user->id)->delete();
    
            DB::commit();
    
            // Load the order with items and products
            $order->load('orderItems.product');
    
            // Send success email with product names
            Mail::to($user->email)->send(new OrderPlacedSuccessMail($order));
    
            // Redirect to user's cart with success message
            session()->flash('order_placed', 'Order Placed successfully!');
    
            return redirect()->back()->with('success', 'Order Placed successfully!');
    
        } catch (\Exception $e) {
            DB::rollBack();
    
            // Send failure email
            Mail::to($user->email)->send(new OrderFailedMail($e->getMessage()));
    
            // Redirect to user's cart with error message
            return redirect()->route('cart.index')->with('error', 'Order Failed: ' . $e->getMessage());
        }
    }





        public function completePayment(Request $request)
    {
        $api = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));
    
        $attributes = [
            'razorpay_order_id' => $request->input('razorpay_order_id'),
            'razorpay_payment_id' => $request->input('razorpay_payment_id'),
            'razorpay_signature' => $request->input('razorpay_signature'),
        ];
        
        DB::beginTransaction();
        try {
            // Verify Razorpay payment
            $api->utility->verifyPaymentSignature($attributes);
    
            // Call the buyFromCart function to complete the order
            $order = $this->orderController->buyFromCart();
    
            // Save payment details as successful
            Payment::create([
                'user_id' => auth()->id(),
                'order_id' => $order->id, // From buyFromCart
                'amount' => $order->total_amount,
                'payment_method' => 'Razorpay',
                'status' => 'completed'
            ]);
    
            DB::commit();
    
            return redirect()->route('order.success')->with('success', 'Payment successful! Order placed.');
        } catch (\Exception $e) {
            DB::rollBack();
    
            // Save failed order and payment details
            $order = $this->orderController->buyFromCart();
    
            Payment::create([
                'user_id' => auth()->id(),
                'order_id' => $order->id,
                'amount' => $order->total_amount,
                'payment_method' => 'credit_card',
                'status' => 'failed'
            ]);
    
            return redirect()->route('order.success')->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }
}




