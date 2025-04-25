<?php

use App\Http\Controllers\FrontendCatalogController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\TestimoniController;
use App\Http\Middleware\CheckUserStatus;
use App\Http\Middleware\SuperUser;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

// Rute Dashboard Frontend
Route::get('/', [DashboardController::class, 'index']);
Route::get('/beranda', [DashboardController::class, 'berandaKatalog']);
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
 
// Rute CRUD Katalog (Bisa diakses oleh Admin dan Super Admin)
Route::middleware(['auth', CheckUserStatus::class])->group(function () {
    Route::resource('/admin/katalog', KatalogController::class);
});

// Rute CRUD Testimoni (Bisa diakses oleh Admin dan Super Admin)
Route::middleware(['auth', CheckUserStatus::class])->group(function () {
    Route::resource('/admin/testimoni', TestimoniController::class);
});


Route::middleware('auth')->post('/change-password', [UserController::class, 'changePassword'])->name('password.update');



