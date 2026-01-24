<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Company;

class UserController extends Controller
{
    public function login(){        
        $company = Company::first();
        Auth::guard('admin')->logout();
        session()->invalidate();
        session()->regenerateToken();
        return view('user.login', compact('company'));
    }

    public function logout(){
        return redirect()->route('login');
    }

    public function loginPost(Request $request){
        
        // Validate input
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required','string'],
        ]);

        $remember = $request->has('remember');

        // Attempt login with remember me
        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $admin = Auth::guard('admin')->user();
            $admin->update([
                'last_login_at' => now(),
                'last_login_ip' => $request->ip(),
            ]);
            return redirect()->intended('/')->with('success', 'Login successful.');
        }

        // Login failed
        return redirect()->back()->withErrors([
                'email' => 'Credentials do not match our records.',
            ])->withInput($request->only('email', 'remember'));

    }
}
