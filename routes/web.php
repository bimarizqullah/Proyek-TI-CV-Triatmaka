<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckUserStatus;

//Rute CRUD User
Route::resource('users', UserController::class);
Route::get('admin/users/create', [UserController::class, 'create'])->name('backend.users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('backend.users.edit');
Route::put('/users/{user}', [UserController::class, 'update'])->name('backend.users.update');

//Rute Dashboard Frontend
Route::get('/', [DashboardController::class, 'index']);

// Rute untuk login
Route::get('admin/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('admin/login', [AuthController::class, 'login']);
Route::post('admin/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Rute yang memerlukan autentikasi

// Pastikan route yang memerlukan autentikasi dan status aktif
Route::middleware(['auth', CheckUserStatus::class])->group(function () {
    Route::get('/admin/dashboard', [UserController::class, 'index'])->name('backend.dashboard');
});

// Route::middleware(['auth', CheckUserStatus::class])->group(function () {
//     Route::get('admin/dashboard', function () {
//         return view('backend.dashboard');
//     })->name('dashboard');
// });

// Route::middleware(['auth'])->group(function () {
//     Route::get('/admin/dashboard', [UserController::class, 'index'])->name('backend.dashboard');
// });
     