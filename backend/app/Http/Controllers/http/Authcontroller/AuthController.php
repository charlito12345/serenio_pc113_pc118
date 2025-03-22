<?php
    namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle login request
    public function login(Request $request)
    {
        // Validate the form data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Attempt to log the user in
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->intended('/dashboard'); // Redirect to the intended route
        }

        return back()->withErrors([
            'email' => 'These credentials do not match our records.',
        ]);
    }

    // Handle logout
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
