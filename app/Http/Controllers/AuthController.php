<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle login request
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Redirect based on role_id
            switch ($user->role_id) {
                case 1:
                    return redirect()->route('superadmin.dashboard');
                case 2:
                    return redirect()->route('admin.dashboard');
                case 3:
                    return redirect()->route('orders');
                case 4:
                    return redirect()->route('user.dashboard');
                case 5:
                    return redirect()->route('serviceProvider.bookings');
                default:
                    return redirect()->route('test')->withErrors(['msg' => 'Invalid role']);
            }
        } else {
            return redirect()->route('login')->withErrors(['msg' => 'Invalid credentials']);
        }
    }

    // Handle logout request
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
    
    public function home(){
        return view('auth.home');
    }
}