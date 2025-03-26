<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is logged in as an admin using the 'admin' guard
        if (Auth::guard('admin')->check()) {
            return $next($request);
        }

        // Redirect to admin login with an error message if unauthorized
        return redirect()->route('admin.adminlogin')->with('error', 'Access Denied! You do not have admin access.');
    }
}
