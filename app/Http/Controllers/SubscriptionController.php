<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\SubscriptionSuccessful;
use Illuminate\Support\Facades\Mail;

class SubscriptionController extends Controller
{
    // Method to handle subscription form submission
    public function subscribe(Request $request)
    {
        // Validate the email
        $request->validate([
            'email' => 'required|email|unique:users,email', // Adjust based on your database structure
        ]);

        $email = $request->input('email');

        // Process subscription logic here...

        // Send subscription email
        Mail::to($email)->send(new SubscriptionSuccessful());

        return redirect()->back()->with('success', 'Subscription successful! Check your email.');
    }
}
