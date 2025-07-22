<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;


class CustomLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('mainpages.login'); // your custom login blade
    }

    public function login(Request $request)
    {
        
        // Validate input (optional but recommended)
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('employee')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/dashboard'); // safer
        }        

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login-page'); // or your custom logout route
    }
}
