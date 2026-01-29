<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

use App\Models\User;
use App\Models\Company;

class UserController extends Controller
{
    public function login(){        
        $company = Company::first();
        if (Auth::guard('admin')->check()) {
            return redirect()->intended('/'); 
        }
        return view('user.login', compact('company'));
    }

    public function logout(Request $request){
        Auth::guard('admin')->logout();

        // Fully invalidate session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }

    public function loginPost(Request $request){
        
        // Validate input
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $key = strtolower($credentials['email']).'|'.$request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'email' => "Too many attempts. Try again in {$seconds} seconds.",
            ]);
        }

        $remember = (bool) $request->boolean('remember');

        // Attempt login with remember me
        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            RateLimiter::clear($key);

            $request->session()->regenerate();

            $admin = Auth::guard('admin')->user();
            $admin->forceFill([
                'last_login_at' => now(),
                'last_login_ip' => $request->ip(),
            ])->save();
            return redirect()->intended('/')->with('success', 'Login successful.');
        }

        // Login failed
        RateLimiter::hit($key, 60); // decay 60 seconds

        throw ValidationException::withMessages([
            'email' => 'Credentials do not match our records.',
        ]);

    }
}
