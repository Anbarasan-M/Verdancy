<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Product;
use PDF;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPlacedSuccessMail;
use App\Mail\OrderFailedMail;

use App\Http\Controllers\PaymentController;

class OrderController extends Controller
{

    public function orders(Request $request)
    {
        $loggedInUser = auth()->user();
        $query = Order::query();
    
        // Apply user-specific filters based on role
        if ($loggedInUser->role_id == 4) {
            // Service providers can only see their own orders
            $query->where('user_id', $loggedInUser->id);
        }
    
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = '%' . $request->search . '%';
            
            $query->where(function ($q) use ($searchTerm, $loggedInUser) {
                // Search by order id instead of order_number
                $q->where('id', 'like', $searchTerm);
                
                // Admin (role_id 2) can also search by customer name
                if ($loggedInUser->role_id == 2) {
                    $q->orWhereHas('user', function ($q) use ($searchTerm) {
                        $q->where('name', 'like', $searchTerm);
                    });
                }
            });
        }
    
        // Fetch orders with pagination (10 orders per page)
        $orders = $query->orderBy('created_at', 'desc')->paginate(10);
    
        return view('orders.index', compact('orders'));
    }
    

    public function buyFromCart()
    {
        $user = auth()->user();
        $cartItems = Cart::where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            throw new \Exception('Cart is empty');
        }

        $totalAmount = 0;
        foreach ($cartItems as $item) {
            $product = Product::find($item->product_id);
            $totalAmount += $product->price * $item->quantity;
        }

        DB::beginTransaction();
        try {
            // Create the order
            $order = new Order();
            $order->user_id = $user->id;
            $order->total_amount = $totalAmount;
            $order->status = 'pending';
            $order->save();

            // Add order items
            foreach ($cartItems as $item) {
                $product = Product::find($item->product_id);

                if ($product->stock < $item->quantity) {
                    throw new \Exception("Not enough stock for product: {$product->name}");
                }

                $product->stock -= $item->quantity;
                $product->save();

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'category_id' => $item->category_id,
                    'quantity' => $item->quantity,
                    'price' => $product->price,
                ]);
            }


            DB::commit();

            // Load the order with items
            $order->load('orderItems.product');

            return $order; // Return the order object for further processing
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    
    // public function buyFromCart()
    // {
    //     // Get the logged-in user
    //     $user = auth()->user();
    
    //     // Fetch user's cart items
    //     $cartItems = Cart::where('user_id', $user->id)->get();
    
    //     if ($cartItems->isEmpty()) {
    //         return redirect()->route('cart.index')->with('error', 'Cart is empty');
    //     }
    
    //     // Calculate the total amount
    //     $totalAmount = 0;
    //     foreach ($cartItems as $item) {
    //         $product = Product::find($item->product_id);
    //         $totalAmount += $product->price * $item->quantity;
    //     }
    
    //     // Create an order
    //     DB::beginTransaction();
    //     try {
    //         $order = new Order();
    //         $order->user_id = $user->id;
    //         $order->total_amount = $totalAmount;
    //         $order->status = 'pending';
    //         $order->save();
    
    //         // Add order items
    //         foreach ($cartItems as $item) {
    //             $product = Product::find($item->product_id);
    
    //             // Reduce product stock
    //             if ($product->stock < $item->quantity) {
    //                 throw new \Exception("Not enough stock for product: {$product->name}");
    //             }
    
    //             $product->stock -= $item->quantity;
    //             $product->save();
    
    //             // Create order item
    //             OrderItem::create([
    //                 'order_id' => $order->id,
    //                 'product_id' => $item->product_id,
    //                 'category_id' => $item->category_id,
    //                 'quantity' => $item->quantity,
    //                 'price' => $product->price,
    //             ]);
    //         }
    
    //         // Clear the user's cart
    //         Cart::where('user_id', $user->id)->delete();
    
    //         DB::commit();
    
    //         // Load the order with items and products
    //         $order->load('orderItems.product');
    
    //         // Send success email with product names
    //         Mail::to($user->email)->send(new OrderPlacedSuccessMail($order));
    
    //         // Redirect to user's cart with success message
    //         session()->flash('order_placed', 'Order Placed successfully!');
    
    //         return redirect()->back()->with('success', 'Order Placed successfully!');
    
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    
    //         // Send failure email
    //         Mail::to($user->email)->send(new OrderFailedMail($e->getMessage()));
    
    //         // Redirect to user's cart with error message
    //         return redirect()->route('cart.index')->with('error', 'Order Failed: ' . $e->getMessage());
    //     }
    // }

    

    public function create()
    {
        return view('orders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'total_amount' => 'required|numeric',
            'status' => 'required'
        ]);

        Order::create($request->all());

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    public function show($orderId)
    {
        // Retrieve the order by its ID with related order items, products, and categories
        $order = Order::with(['orderItems.product', 'orderItems.category'])->findOrFail($orderId);

        // Pass the order to the view
        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        return view('orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'user_id' => 'required',
            'total_amount' => 'required|numeric',
            'status' => 'required'
        ]);

        $order->update($request->all());

        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }



    public function ship(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'shipped'; // Update status to shipped
        $order->save();

        return redirect()->back()->with('success', 'Order marked as shipped.');
    }

    public function deliver(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'completed'; // Update status to delivered
        $order->save();

        return redirect()->back()->with('success', 'Order marked as delivered.');
    }

    public function cancel(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'cancelled'; // Update status to cancelled
        $order->save();

        return redirect()->back()->with('success', 'Order has been cancelled.');
    }

    public function downloadPdf($id)
    {
        $order = Order::with('orderItems.product', 'orderItems.category', 'user')->findOrFail($id);

        // Load the view and pass the order data
        $pdf = PDF::loadView('orders.pdf', compact('order'));

        // Download the PDF file
        return $pdf->download('order_' . $order->id . '.pdf');
    }

}
