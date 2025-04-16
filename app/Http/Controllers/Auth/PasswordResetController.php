<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class PasswordResetController extends Controller
{
    // Show the form to request a password reset link
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    // Send the password reset link to the user's email
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // This line should reference the correct table
        $response = Password::sendResetLink($request->only('email'));

        return $response == Password::RESET_LINK_SENT
            ? back()->with('status', 'Password reset link sent!')
            : back()->withErrors(['email' => 'Unable to send password reset link.']);
    }


    // Validate the email
    protected function validateEmail(Request $request)
    {
        return $request->validate(['email' => 'required|email']);
    }

    // Show the password reset form
    public function showResetForm($token)
    {
        return view('auth.passwords.reset')->with(['token' => $token]);
    }

    // Handle the password reset process
    public function reset(Request $request)
    {
        // Validate the password reset input
        $this->validateReset($request);

        $resetStatus = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->password = bcrypt($request->password);
                $user->setRememberToken(Str::random(60));
                $user->save();
            }
        );

        return $resetStatus == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Password has been reset! You can now login.')
            : back()->withErrors(['email' => 'Failed to reset password.']);
    }

    // Validate the password reset input
    protected function validateReset(Request $request)
    {
        return $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
            'token' => 'required'
        ]);
    }
}
