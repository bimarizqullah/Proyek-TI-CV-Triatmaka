<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
//Rute CRUD User
Route::resource('users', UserController::class);

//Rute Dashboard Frontend
Route::get('/', [DashboardController::class, 'index']);

// Rute untuk login
Route::get('admin/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('admin/login', [AuthController::class, 'login']);
Route::post('admin/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Rute yang memerlukan autentikasi
Route::middleware(['auth'])->group(function () {
    Route::get('admin/dashboard', function () {
        return view('backend.dashboard');
    })->name('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [UserController::class, 'index'])->name('backend.dashboard');
});
