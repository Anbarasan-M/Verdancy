<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Booking;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests; // Add this
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\Models\Cart;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationSuccessfulMail;
use App\Mail\SubscriptionSuccessful;


class UserController extends Controller
{
    use ValidatesRequests; // Add this to use the validate() method

    // Display the form for creating a new user
    public function createUser()
    {
        return view('user.register');
    }

    public function createSeller()
    {
        return view('seller.register');
    }

    public function createServiceProvider()
    {
        return view('service_provider.register');
    }

    public function seperadminDashboard(){
        return view('user.dashboard');
    }
    public function adminDashboard(){
        return view('user.dashboard');
    }
    public function sellerDashboard(){
        return view('user.dashboard');
    }
    public function userDashboard(){
        $categories = Category::with('firstProduct')->take(8)->get(); // Fetch all categories with one product each
        $products = Product::latest()->take(4)->get(); // Fetch latest 4 products
    
        return view('user.dashboard', compact('categories', 'products'));
    }
    
    public function home2(){
        $categories = Category::with('firstProduct')->take(4)->get(); // Fetch all categories with one product each
        $products = Product::latest()->take(4)->get(); // Fetch latest 4 products
    
        return view('home2', compact('categories', 'products'));
    }
    
    public function serviceProviderDashboard(){
        $todayBookingsCount = Booking::where('worker_id', auth()->user()->id)
        ->whereDate('booking_date', Carbon::today())
        ->count();

        return view('service_provider.dashboard', compact('todayBookingsCount'));
    }

    // User side pages
    public function shop(Request $request) {
        $query = Product::query();
    
        // Search functionality
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }
    
        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
    
        // Sorting functionality
        if ($request->filled('sort')) {
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
    
        // Fetch categories for the dropdown
        $categories = Category::all();
    
        // Paginate the products
        $products = $query->paginate(12);
    
        // Pass categories and products to the view
        return view('user.shop', compact('products', 'categories'));
    }
     
    public function services(){
        return view('user.services');
    }
    public function cart(){
        $user = auth()->user();
        
        // Fetch user's cart items
        $cartItems = Cart::where('user_id', $user->id)->with('product')->get();

        // Calculate the total amount
        $totalAmount = 0;
        foreach ($cartItems as $item) {
            $totalAmount += $item->product->price * $item->quantity;
        }

        // Pass cart items and total amount to the view
        return view('user.cart', compact('cartItems', 'totalAmount'));
    }

// Store method
    
public function store(Request $request)
{
    // Validate the form input
    $this->validate($request, [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'phone_number' => 'required|string|max:15',
        'address' => 'nullable|string|max:255',
        'profile_image' => 'nullable|image|max:2048',
        'license_number' => 'nullable|string|max:50',
        'role_id' => 'required|integer|in:3,4,5',  // Validating role_id, excluding admin (which is handled separately)
    ]);

    // Check if the user is not authenticated (meaning they're registering themselves)
    if (!auth()->check()) {
        // Validate the Google reCAPTCHA response for unauthenticated users
        $this->validate($request, [
            'g-recaptcha-response' => 'required',  // Ensure CAPTCHA is filled
        ]);

        // Verify the CAPTCHA response
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('GOOGLE_RECAPTCHA_SECRET_KEY'), // Use the environment variable for secret key
            'response' => $request->input('g-recaptcha-response'),  // Match this with the field name in the form
            'remoteip' => $request->ip(),
        ]);

        $verificationData = $response->json();
        if (!$verificationData['success']) {
            return back()->withErrors(['captcha' => 'CAPTCHA verification failed.']);
        }
    }

    // Handling file upload for profile image
    $profileImagePath = null;
    if ($request->hasFile('profile_image')) {
        $profileImagePath = $request->file('profile_image')->store('profile_images', 'public');
    }

    // Create a new user with the provided role_id
    $user = User::create([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'password' => Hash::make($request->input('password')),
        'role_id' => $request->input('role_id'),  // Using the role_id from the form
        'phone_number' => $request->input('phone_number'),
        'address' => $request->input('address'),
        'profile_image' => $profileImagePath,
        'license_number' => $request->input('license_number'),
        'activity_status' => $request->input('activity_status'),
        'approval_status' => $request->input('approval_status'),
    ]);

    Mail::to($user->email)->send(new RegistrationSuccessfulMail($user));

    // Redirect the user and set a flash message
    session()->flash('registration_successful', 'Login to explore more');
    return redirect()->back();
}

    

    // Show the user profile
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user(); // Get the currently authenticated user
        return view('profile.edit', compact('user'));
    }
    
    public function update(Request $request)
    {
        // Validate the form input (license number excluded)
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'phone_number' => 'required|string|max:15',
            'address' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
    
        $user = Auth::user(); // Get the currently authenticated user
    
        // Handling file upload for profile image
        if ($request->hasFile('profile_image')) {
            $profileImagePath = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $profileImagePath;
        }
    
        // Update user's profile fields
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone_number = $request->input('phone_number');
        $user->address = $request->input('address');
    
        // Update password if provided
        if ($request->input('password')) {
            $user->password = Hash::make($request->input('password'));
        }
    
        // Save changes
        $user->save();
    
        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully!');
    }
    
    

    // Delete a user
    public function destroy(User $user)
    {
        if ($user->profile_image) {
            Storage::delete('public/' . $user->profile_image);
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }



    public function sendSubscriptionEmail($email)
    {
        Mail::to($email)->send(new SubscriptionSuccessful());

        return response()->json(['message' => 'Subscription email sent successfully!']);
    }

}
