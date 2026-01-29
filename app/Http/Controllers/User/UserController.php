<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

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
            'password' => ['required', 'string', 'min:8'], // use Illuminate\Validation\Rules\Password; Password::min(10)->mixedCase()->numbers()->symbols(),
        ]);

        $key = strtolower($credentials['email']).'|'.$request->ip();

        $email = Str::lower(trim($credentials['email']));

        $emailKey = 'login:email:' . $email;
        $ipKey    = 'login:ip:' . $request->ip();

        if (
            RateLimiter::tooManyAttempts($emailKey, 3) ||
            RateLimiter::tooManyAttempts($ipKey, 20)
        ) {
            throw ValidationException::withMessages([
                'email' => 'Too many login attempts. Please try again later.',
            ]);
        }

        $remember = (bool) $request->boolean('remember');

        // Attempt login with remember me
        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            // clear limits
            RateLimiter::clear($emailKey);
            RateLimiter::clear($ipKey);

            $request->session()->invalidate();
            $request->session()->regenerateToken();
            $request->session()->regenerate();

            $admin = Auth::guard('admin')->user();
            $admin->forceFill([
                'last_login_at' => now(),
                'last_login_ip' => $request->ip(),
            ])->save();
            return redirect()->intended('/')->with('success', 'Login successful.');
        }

        // Login failed
        RateLimiter::hit($emailKey, 60);
        RateLimiter::hit($ipKey, 60);

        throw ValidationException::withMessages([
            'email' => 'Invalid login credentials.',
        ]);

    }
}
