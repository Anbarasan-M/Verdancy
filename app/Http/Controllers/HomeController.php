<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all(); // Fetch all categories
        $products = Product::latest()->take(4)->get(); // Fetch latest 4 products
        return view('home', compact('categories', 'products'));
    }

    public function home(){
        return view('home');
    }
}
