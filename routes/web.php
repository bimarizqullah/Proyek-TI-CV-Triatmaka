<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HargaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\TestimoniController;
use App\Http\Middleware\CheckUserStatus;
use App\Http\Middleware\SuperUser;

// // Rute Dashboard Frontend
// Route::get('/', [DashboardController::class, 'index']);
Route::get('/', [DashboardController::class, 'beranda']);
Route::get('/detail-produk/{id}', [DashboardController::class, 'show'])->name('produk.show');


// Rute untuk login
Route::get('admin/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('admin/login', [AuthController::class, 'login']);
Route::post('admin/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Rute CRUD User (Hanya bisa diakses oleh Super Admin)


// Rute CRUD Profile (Bisa diakses oleh Admin dan Super Admin)
Route::middleware(['auth', CheckUserStatus::class])->group(function () {
    Route::resource('/admin/profile', ProfileController::class);
    Route::put('/admin/profile/update-foto/{id}', [ProfileController::class, 'updateFoto'])->name('profile.update-foto'); 
});


// Rute CRUD User (Hanya bisa diakses oleh Super Admin)
Route::middleware(['auth', CheckUserStatus::class, SuperUser::class])->group(function () {
    Route::resource('/admin/users', UserController::class);
});
 
// Rute CRUD  (Bisa diakses oleh Admin dan Super Admin)
Route::middleware(['auth', CheckUserStatus::class])->group(function () {
    Route::resource('/admin/katalog', KatalogController::class);
    Route::resource('/admin/testimoni', TestimoniController::class);
    Route::resource('/admin/harga', HargaController::class)->except(['create', 'edit']);
});


Route::get('/search', [DashboardController::class, 'search'])->name('search.global');
Route::middleware('auth')->post('/change-password', [UserController::class, 'changePassword'])->name('password.update');



