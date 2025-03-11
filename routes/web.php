<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome'); // Default home page
})->name('welcome');

// User Registration Routes
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerPost'])->name('register.post');

// User Login Routes
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/authenticate', [AuthController::class, 'loginPost'])->name('login.post');

// User Logout Route (Requires authentication)
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Admin Routes
Route::prefix('admin')->group(function () {
    // Admin authentication routes
    Route::get('/adminlogin', [AuthController::class, 'adminlogin'])->name('admin.adminlogin');
    Route::post('/adminlogin', [AuthController::class, 'adminloginPost'])->name('admin.adminlogin.post');

    
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/welcome', [AuthController::class, 'welcome'])->name('admin.welcome');
        Route::get('/users/{id}', [AuthController::class, 'showUser'])->name('admin.user.show');
        Route::post('/logout', [AuthController::class, 'adminLogout'])->name('admin.logout');
    });
});