<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
    
        // Fill the user with validated data
        $user->fill($request->validated());
    
        // Check if the email is being updated
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;  // Reset email verification
        }
    
        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->filled('address')) {
            $user->address = $request->address;
        }

        if ($request->filled('phone_number')) {
            $user->phone_number = $request->phone_number;
        }
    
        // Handle image upload if a new image is provided
        if ($request->hasFile('image')) {
            $user->profile_image = $request->file('image')->store('profile_images', 'public');
        }
    
        $user->save();
    
        return Redirect::route('profile.edit')->with('status', 'Profile updated successfully.');
    }
    
    

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
