<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function index()
    {
        $orderItems = OrderItem::all();
        return view('order_items.index', compact('orderItems'));
    }

    public function create()
    {
        return view('order_items.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
            'product_id' => 'required',
            'category_id' => 'required',
            'quantity' => 'required|integer',
            'price' => 'required|numeric'
        ]);

        OrderItem::create($request->all());

        return redirect()->route('order_items.index')->with('success', 'Order item created successfully.');
    }

    public function show(OrderItem $orderItem)
    {
        return view('order_items.show', compact('orderItem'));
    }

    public function edit(OrderItem $orderItem)
    {
        return view('order_items.edit', compact('orderItem'));
    }

    public function update(Request $request, OrderItem $orderItem)
    {
        $request->validate([
            'order_id' => 'required',
            'product_id' => 'required',
            'category_id' => 'required',
            'quantity' => 'required|integer',
            'price' => 'required|numeric'
        ]);

        $orderItem->update($request->all());

        return redirect()->route('order_items.index')->with('success', 'Order item updated successfully.');
    }

    public function destroy(OrderItem $orderItem)
    {
        $orderItem->delete();
        return redirect()->route('order_items.index')->with('success', 'Order item deleted successfully.');
    }
}
