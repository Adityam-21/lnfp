<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;

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
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->has('remember'))) {
            return response()->json([
                'message' => 'Login successful!',
                'redirect' => route('welcome')
            ], 200);
        }

        return response()->json([
            'message' => 'Invalid credentials. Please try again.'
        ], 401);
    }

    public function register()
    {
        return view("auth.register");
    }

    public function registerPost(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Send Welcome Email
        Mail::to($user->email)->send(new WelcomeMail($user));

        return redirect()->route('login')->with('success', 'Registration successful! Check your email.');
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

    // FORM VALIDATION METHOD
    public function submitForm(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        return response()->json(['message' => 'Form submitted successfully!']);
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
            "password" => "required|min:6",
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $credentials = ['email' => $request->email, 'password' => $request->password];

        if (Auth::guard('admin')->attempt($credentials, $request->has('remember'))) {
            return response()->json([
                'status' => 'success',
                'message' => 'Login successful! Redirecting...',
                'redirect' => route('admin.dashboard'),
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Invalid credentials. Please try again.',
        ], 401);
    }

    public function dashboard()
    {
        $users = User::paginate(10); // ✅ Enables use of $users->links()
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

        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully.',
            'redirect' => route('admin.adminlogin')
        ], 200);
    }
}
