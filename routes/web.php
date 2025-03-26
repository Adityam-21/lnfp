<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Mail\WelcomeMail;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');



Route::get('/users/export', [UserController::class, 'export'])->name('users.export');
Route::get('/users/export/filtered', [UserController::class, 'exportFiltered'])->name('users.export.filtered');
Route::post('/users/import', [UserController::class, 'import'])->name('users.import');

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerPost'])->name('register.post');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/authenticate', [AuthController::class, 'loginPost'])->name('login.post');

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::prefix('admin')->group(function () {
    Route::get('/adminlogin', [AuthController::class, 'adminlogin'])->name('admin.adminlogin');
    Route::post('/adminlogin', [AuthController::class, 'adminloginPost'])->name('admin.adminlogin.post');

    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/users/{id}', [UserController::class, 'showUser'])->name('admin.user.show');
        Route::get('/user/{id}/edit', [UserController::class, 'editUser'])->name('admin.user.edit-user');
        Route::put('/user/{id}', [UserController::class, 'updateUser'])->name('admin.user.update');
        Route::delete('/user/{id}', [UserController::class, 'deleteUser'])->name('admin.user.delete');
        Route::delete('/user/softdelete/{id}', [UserController::class, 'softDelete'])->name('admin.user.softdelete');

        Route::post('/logout', [AuthController::class, 'adminLogout'])->name('admin.logout');
    });
});

// ✅ Test Mail Route
Route::get('/test-mail', function () {
    $user = User::first();
    if (!$user) {
        return "No user found! Add a user in the database.";
    }

    Mail::to($user->email)->send(new WelcomeMail($user));

    return "Test email sent successfully to " . $user->email;
});
