<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $productId = $request->product_id;
        $product = Product::findOrFail($productId);

        $cartItem = Cart::where('user_id', auth()->id())
                        ->where('product_id', $productId)
                        ->first();

        if ($cartItem) {
            // If the item already exists in the cart, increase the quantity
            $cartItem->quantity += 1;
        } else {
            // If it's a new item, create a cart entry
            $cartItem = new Cart();
            $cartItem->user_id = auth()->id();
            $cartItem->product_id = $productId;
            $cartItem->category_id = $product->category_id; // Make sure category_id is passed here
            $cartItem->quantity = 1;
        }

        $cartItem->save();
        session()->flash('added_to_cart', 'Press OK to explore more');
        return redirect()->back();
        // return redirect()->route('cart.index')->with('success', 'Cart item added successfully.');
    }


    public function showCart()
    {
        $cartItems = Cart::where('user_id', auth()->id())->with('product')->get();
        $total = $cartItems->reduce(function ($sum, $item) {
            return $sum + ($item->quantity * $item->product->price);
        }, 0);

        return view('cart.index', compact('cartItems', 'total'));
    }


    public function buyAll()
    {
        $cartItems = Cart::where('user_id', auth()->id())->with('product')->get();

        // Process the purchase (e.g., create an order, clear the cart, etc.)
        foreach ($cartItems as $item) {
            // Logic to handle purchase, e.g., create orders
            // For each item in the cart, an order can be created
        }

        // Clear the cart after purchase
        Cart::where('user_id', auth()->id())->delete();

        return redirect()->route('cart.index')->with('success', 'All items have been purchased!');
    }



    public function index()
    {
        $cartItems = Cart::all();
        return view('cart.index', compact('cartItems'));
    }

    public function create()
    {
        return view('cart.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'product_id' => 'required',
            'category_id' => 'required',
            'quantity' => 'required|integer'
        ]);

        Cart::create($request->all());

        return redirect()->route('cart.index')->with('success', 'Cart item added successfully.');
    }

    public function show(Cart $cart)
    {
        return view('cart.show', compact('cart'));
    }

    public function edit(Cart $cart)
    {
        return view('cart.edit', compact('cart'));
    }

    public function update(Request $request, Cart $cart)
    {
        $request->validate([
            'user_id' => 'required',
            'product_id' => 'required',
            'category_id' => 'required',
            'quantity' => 'required|integer'
        ]);

        $cart->update($request->all());

        return redirect()->route('cart.index')->with('success', 'Cart item updated successfully.');
    }

    public function destroy(Cart $cart)
    {
        $cart->delete();
        return redirect()->route('cart.index')->with('success', 'Cart item deleted successfully.');
    }

    public function removeFromCart($id)
{
    // Find the cart item by ID
    $cartItem = Cart::find($id);

    // Check if the cart item exists
    if ($cartItem) {
        $cartItem->delete();  // Remove the item from the cart
        session()->flash('removed_from_cart', 'Press ok to continue');
        return redirect()->back();
    }

    return redirect()->route('cart.index')->with('error', 'Item not found.');
}

}

