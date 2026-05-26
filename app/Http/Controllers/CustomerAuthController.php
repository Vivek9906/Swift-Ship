<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;

class CustomerAuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.customer-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $role = Auth::user()->role;
            if ($role === 'admin' || $role === 'staff') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('customer.dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid email or password',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.customer-register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'min:2', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'regex:/^(\+91|91)?[6-9]\d{9}$/'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[A-Z])(?=.*\d).+$/'],
            'terms' => ['required', 'accepted'],
        ], [
            'phone.regex' => 'Enter a valid 10-digit Indian mobile number.',
            'password.regex' => 'Password must contain at least one uppercase letter and one number.',
        ]);

        $normalizedPhone = $validated['phone'];
        if (preg_match('/^(\+91|91)?([6-9]\d{9})$/', $normalizedPhone, $matches)) {
            $normalizedPhone = '+91' . $matches[2];
        }

        $user = User::create([
            'name' => $validated['full_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'customer',
            'status' => 'active',
        ]);

        UserProfile::create([
            'user_id' => $user->id,
            'phone' => $normalizedPhone,
        ]);

        try {
            Mail::to($user->email)->send(new WelcomeEmail($user));
        } catch (\Throwable $th) {
            // fail silently for mail
        }

        Auth::login($user);

        return redirect()->route('customer.dashboard')->with('success', 'Registration successful! Welcome to SwiftShip.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Logged out successfully.');
    }
}
