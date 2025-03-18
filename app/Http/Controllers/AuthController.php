<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // USER AUTHENTICATION METHODS
    
    public function index()
    {
        $user = Auth::user();
        return view('welcome', compact('user'));
    }
    
    public function login()
    {
        return view('auth.login');
    }
    
    public function loginPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required|email",
            "password" => "required",
        ]);
        
        if ($validator->passes()) {
            $credentials = $request->only('email', 'password');
            
            if (Auth::attempt($credentials)) {
                return redirect()->route('welcome');
            }
            
            return redirect()->route('login')
                ->withInput($request->except('password'))
                ->withErrors(['email' => 'These credentials do not match our records.']);
        } else {
            return redirect()->route('login')
                ->withInput($request->except('password'))
                ->withErrors($validator);
        }
    }
    
    public function register()
    {
        return view("auth.register");
    }
    
    public function registerPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|string|max:255|regex:/^[a-zA-Z\s]+$/",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:6|confirmed",
        ], [
            "name.regex" => "The name may only contain letters and spaces.",
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
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
    
    public function profile()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in.');
        }
        
        return view('profile', compact('user'));
    }
    
    // ADMIN AUTHENTICATION METHODS
    
    public function adminlogin()
    {
        return view('admin.adminlogin');
    }
    
    public function adminloginPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required|email",
            "password" => "required",
        ]);
    
        if ($validator->passes()) {
            $credentials = ['email' => $request->email, 'password' => $request->password];

            if (Auth::guard('admin')->attempt($credentials)) {
                return redirect()->route('admin.dashboard');
            }
            
            return redirect()->route('admin.adminlogin')
                ->withInput($request->except('password'))
                ->withErrors(['email' => 'These credentials do not match our records.']);
        } else {
            return redirect()->route('admin.adminlogin')
                ->withInput($request->except('password'))
                ->withErrors($validator);
        }
    }
    
    public function dashboard()
    {
        $users = User::all();
        return view('admin.dashboard', compact('users'));
    }
    
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit-user', compact('user'));
    }
    
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        return redirect()->route('admin.dashboard')->with('success', 'User updated successfully.');
    }
    
    public function deleteUser($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('admin.dashboard')->with('success', 'User deleted successfully.');
    }
    
    public function adminlogout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.adminlogin');
    }
}
