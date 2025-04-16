<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Service;
use App\Models\User;


class AdminController extends Controller
{
    // Show the Admin Dashboard
    public function index()
    {
            // Fetch the data
    $activeSellers = User::where('role_id', 3)->where('activity_status', 'active')->count();
    $activeServiceProviders = User::where('role_id', 5)->where('activity_status', 'active')->count();
    $productsCount = Product::count();
    $servicesCount = Service::count();

    // Pass the data to the view
    return view('admin.dashboard', compact('activeSellers', 'activeServiceProviders', 'productsCount', 'servicesCount'));
    }

    // Add Seller
    public function addSeller()
    {
        return view('admin.add_seller');
    }

    // Add Service Provider
    public function addServiceProvider()
    {
        return view('admin.add_service_provider');
    }


    // Add Service
    public function addService()
    {
        return view('admin.add-service');
    }


    public function stocks()
    {
        $products = Product::with('category')->get(); // Fetch all products with their categories
        return view('admin.stocks', compact('products'));
    }

    public function services()
    {
        $services = Service::all(); // Fetch all services
        return view('admin.services', compact('services'));
    }


}
