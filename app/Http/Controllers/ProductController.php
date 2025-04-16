<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage; // Import Storage for deleting old images

class ProductController extends Controller
{
    public function list()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
            }
        }

        $products = $query->paginate(12);

        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'seller_id' => 'required',
            'stock' => 'required|integer',
            'category_id' => 'required',
            'image_url' => 'nullable',
            'image_file' => 'nullable'
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function show($id)
    {
        // Fetch the product from the database
        $product = Product::find($id);

        // Check if the product exists
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        // Return the product data as JSON
        return response()->json($product);
    }

    public function showProduct($id)
    {
        $product = Product::with('category')->find($id);
        return view('products.show', compact('product'));
    }

    
    // ProductController.php
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }


    // ProductController.php
    public function update(Request $request, $id)
    {
        // Validate the form input using the request instance
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image_file' => 'nullable|image|max:2048', // Optional image upload
        ]);
    
        // Find the product by its ID
        $product = Product::findOrFail($id);
    
        // Update product fields
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->stock = $request->input('stock');
    
        // Handling file upload for product image
        if ($request->hasFile('image_file')) {
            // Delete the old image if it exists
            if ($product->image_url) {
                \Storage::disk('public')->delete($product->image_url);
            }
            
            // Store the new image and update the path
            $product->image_url = $request->file('image_file')->store('product_images', 'public');
        }
    
        // Save changes to the product
        $product->save();
        return redirect()->route('products.edit', $product->id)->with('success', 'Product updated successfully!');
    }
    


    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
