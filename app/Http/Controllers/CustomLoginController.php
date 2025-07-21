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
        //dd($request);
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Login successful
            $request->session()->regenerate();
            return redirect()->intended('/dashboard'); // redirect to your preferred page
        }

        // Login failed
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
