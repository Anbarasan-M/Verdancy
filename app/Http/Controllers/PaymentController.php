<?php


namespace App\Http\Controllers;

use Razorpay\Api\Api;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPlacedSuccessMail;
use App\Mail\OrderFailedMail;
use PDF;

class PaymentController extends Controller
{
    // public function createOrder(Request $request)
    // {
    //     $api = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));

    //     $orderData = [
    //         'receipt' => 'receipt#1',
    //         'amount' => $request->input('amount'), // Amount in paise (e.g., 50000 for ₹500)
    //         'currency' => 'INR',
    //         'payment_capture' => 1, // Auto capture
    //     ];

    //     try {
    //         $order = $api->order->create($orderData);
    //         return response()->json($order);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()]);
    //     }
    // }

    public function paymentCallback(Request $request)
    {
        $api = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));
    
        // Verify the payment signature
        $attributes = [
            'razorpay_order_id' => $request->input('razorpay_order_id'),
            'razorpay_payment_id' => $request->input('razorpay_payment_id'),
            'razorpay_signature' => $request->input('razorpay_signature')
        ];
    

        try {
            $api->utility->verifyPaymentSignature($attributes);
            // Payment is successful, save details to the database, etc.
            return redirect()->route('success.page')->with('success', 'Payment successful!');
        } catch (\Exception $e) {
            // Payment verification failed
            return redirect()->route('failure.page')->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }

    protected $orderController;

    public function __construct(OrderController $orderController)
    {
        $this->orderController = $orderController;
    }

    public function completePayment(Request $request)
    {
        DB::beginTransaction();
        try {
            // Verify Razorpay payment
            // $this->verifyRazorpayPayment($request);
    
            // Get authenticated user
            $user = auth()->user();
    
            // Fetch and validate cart items
            $cartItems = $this->getCartItems($user);
            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.index')->with('error', 'Cart is empty');
            }
    
            // Calculate total amount
            $totalAmount = $this->calculateTotalAmount($cartItems);
    
            // Create order
            $order = $this->createOrder($user, $totalAmount);
    
            // Process order items and update stock
            $this->processOrderItems($cartItems, $order);
    
            // Save successful payment
            $this->savePayment($request->input('razorpay_payment_id'), $user->id, $order, 'completed');
    
            // Clear the cart
            $this->clearCart($user);
    
            // Commit the transaction
            DB::commit();
    
            // Send success email
            $this->sendSuccessEmail($user, $order);
    
            return redirect()->route('order.success', $order->id)->with('success', 'Payment successful! Order placed.');
    
        } catch (\Exception $e) {
            DB::rollBack();
    
            // Handle failure
            return $this->handlePaymentFailure($e, $user, $cartItems, $totalAmount);
        }
    }
    
    // Fetch user's cart items
    private function getCartItems($user)
    {
        return Cart::where('user_id', $user->id)->get();
    }
    
    // Calculate total amount of cart items
    private function calculateTotalAmount($cartItems)
    {
        $totalAmount = 0;
        foreach ($cartItems as $item) {
            $product = Product::find($item->product_id);
            $totalAmount += $product->price * $item->quantity;
        }
        return $totalAmount;
    }
    
    // Create an order
    private function createOrder($user, $totalAmount)
    {
        $order = new Order();
        $order->user_id = $user->id;
        $order->total_amount = $totalAmount;
        $order->status = 'pending'; // Initial order status
        $order->save();
    
        return $order;
    }
    
    // Process order items and update product stock
    private function processOrderItems($cartItems, $order)
    {
        foreach ($cartItems as $item) {
            $product = Product::find($item->product_id);
    
            // Check if enough stock is available
            if ($product->stock < $item->quantity) {
                throw new \Exception("Not enough stock for product: {$product->name}");
            }
    
            // Deduct stock
            $product->stock -= $item->quantity;
            $product->save();
    
            // Create an order item record
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'category_id' => $item->category_id,
                'quantity' => $item->quantity,
                'price' => $product->price,
            ]);
        }
    }
    
    // Save payment details
    private function savePayment($razorpay_payment_id, $user_id, $order, $status)
    {
        Payment::create([
            'razorpay_payment_id' => (string)$razorpay_payment_id,
            'user_id' => $user_id,
            'order_id' => $order->id,
            'amount' => $order->total_amount,
            'payment_method' => 'card',
            'status' => $status,
        ]);
    }
    
    // Clear the user's cart
    private function clearCart($user)
    {
        Cart::where('user_id', $user->id)->delete();
    }
    
    // Send success email
    private function sendSuccessEmail($user, $order)
    {
        Mail::to($user->email)->send(new OrderPlacedSuccessMail($order));
    }
    
    // Handle payment failure
    private function handlePaymentFailure($e, $user, $cartItems, $totalAmount)
    {
        // Send failure email
        Mail::to($user->email)->send(new OrderFailedMail($e->getMessage()));
    
        // Log the failed payment
        Payment::create([
            'user_id' => $user->id,
            'order_id' => null, // Only if the order was not created
            'amount' => $totalAmount,
            'payment_method' => 'card',
            'status' => 'failed',
            'razorpay_payment_id' => request('razorpay_payment_id'), // Fetch from request
        ]);
    
        return redirect()->route('order.failure')->with('error', 'Payment failed: ' . $e->getMessage());
    }
    
    
    
    public function showPaymentForm(Request $request)
    {
        $user = auth()->user();
        $cartItems = Cart::where('user_id', $user->id)->with('product')->get();
    
        // Calculate the total amount
        $totalAmount = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
    
        if ($totalAmount == 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty or invalid.');
        }
    
        return view('payment', compact('cartItems', 'totalAmount'));
    }
    

    public function orderSuccess($orderId)
    {
        // Retrieve the order by its ID
        $order = Order::with('orderItems.product')->findOrFail($orderId);
    
        // Retrieve the payment details based on the order ID
        $payment = Payment::where('order_id', $orderId)->firstOrFail();
    
        // Return the success view with the order and payment ID from the payments table
        return view('orders.success', [
            'order' => $order,
            'payment_id' => $payment->id // Use the 'id' from the payments table
        ]);
    }
    

    public function orderFailure(){
        return view('orders.failure');
    }

    public function index()
    {
        $payments = Payment::with('user', 'order')->orderBy('id', 'desc')->paginate(10);
        return view('transactions.index', compact('payments'));
    }
    

    // Method to show a specific transaction
    public function show($id)
    {
        $payment = Payment::with('user', 'order')->findOrFail($id); // Eager load relationships if necessary
        return view('transactions.show', compact('payment'));
    }

    public function downloadPDF($id)
    {
        $payment = Payment::with('user', 'order')->findOrFail($id);

        // Load the view to generate the PDF
        $pdf = PDF::loadView('transactions.pdf', compact('payment'));

        // Return the generated PDF for download
        return $pdf->download('transaction_'.$payment->id.'.pdf');
    }
}
