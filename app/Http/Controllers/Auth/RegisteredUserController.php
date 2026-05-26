<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class RegisteredcustomerController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'regex:/^(\+91|91)?[6-9]\d{9}$/'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
            'terms' => ['required', 'accepted'],
        ], [
            'phone.regex' => 'Enter a valid Indian mobile number (10 digits, starts with 6-9).',
            'terms.accepted' => 'You must agree to the Terms & Privacy Policy.',
            'password.min' => 'Password must be at least 8 characters.',
        ]);

        $normalizedPhone = $request->phone;
        if (preg_match('/^(\+91|91)?([6-9]\d{9})$/', $normalizedPhone, $matches)) {
            $normalizedPhone = '+91' . $matches[2];
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $normalizedPhone,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        // Send welcome email (queued, non-blocking)
        try {
            \Illuminate\Support\Facades\Mail::to($user->email)
                ->send(new \App\Mail\WelcomeMail($user));
        } catch (\Throwable) {
            // Don't block registration if email fails
        }

        return redirect()->route('login')
            ->with('success', 'Account created! Please sign in.');
    }
}
