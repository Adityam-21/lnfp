<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class AuthController extends Controller
{
    public function login()
    {
        return view("auth.login");
    }

    public function loginPost(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('welcome');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->except('password'));
    }

    public function register()
    {
        return view("auth.register");
    }

    public function registerPost(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:255|regex:/^[a-zA-Z\s\-\'\.]+$/",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:6|confirmed",
        ], [
            "name.regex" => "The full name may only contain letters, spaces, hyphens, apostrophes, and dots.",
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($user) {
            return redirect()->route("login")->with("success", "Registration successful! Please login.");
        }

        return back()->with("error", "Registration failed. Please try again.");
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('welcome');
    }
}
