<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/export-users', [UserController::class, 'export'])->name('users.export');
Route::post('/import-users', [UserController::class, 'import'])->name('users.import');

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
        Route::get('/users/{id}', [AuthController::class, 'showUser'])->name('admin.user.show');
        Route::get('/user/{id}/edit', [AuthController::class, 'editUser'])->name('admin.user.edit');
        Route::put('/user/{id}', [AuthController::class, 'updateUser'])->name('admin.user.update');
        Route::delete('/user/{id}', [AuthController::class, 'deleteUser'])->name('admin.user.delete');
        
        Route::delete('/user/softdelete/{id}', [UserController::class, 'softDelete'])->name('admin.user.softdelete');

        Route::post('/logout', [AuthController::class, 'adminLogout'])->name('admin.logout');
    });
});
