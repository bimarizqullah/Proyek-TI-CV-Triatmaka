<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardController;
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
