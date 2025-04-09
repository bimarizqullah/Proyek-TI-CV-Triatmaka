<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KatalogController;
use App\Http\Middleware\CheckUserStatus;
use App\Http\Middleware\SuperUser;

// Rute Dashboard Frontend
Route::get('/', [DashboardController::class, 'index']);

// Rute untuk login
Route::get('admin/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('admin/login', [AuthController::class, 'login']);
Route::post('admin/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Rute CRUD User (Hanya bisa diakses oleh Super Admin)


// Rute CRUD Profile (Bisa diakses oleh Admin dan Super Admin)
Route::middleware(['auth', CheckUserStatus::class])->group(function () {
    Route::resource('profile', ProfileController::class);
    Route::get('admin/profile/create', [ProfileController::class, 'create'])->name('profile.create');
    Route::post('/profile', [ProfileController::class, 'store'])->name('profile.store');
    Route::get('/profile/{user}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/admin/profile/index', [ProfileController::class, 'index'])->name('profile.index');  
});


// Rute CRUD User (Hanya bisa diakses oleh Super Admin)
Route::middleware(['auth', CheckUserStatus::class, SuperUser::class])->group(function () {
    Route::resource('users', UserController::class);
    Route::get('admin/users/create', [UserController::class, 'create'])->name('backend.users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('backend.users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('backend.users.update');
    Route::get('/admin/users/index', [UserController::class, 'index'])->name('backend.users.index');
});

// Rute CRUD Katalog (Bisa diakses oleh Admin dan Super Admin)
Route::middleware(['auth', CheckUserStatus::class])->group(function () {
    Route::resource('katalog', KatalogController::class);
    Route::get('admin/katalog/create', [KatalogController::class, 'create'])->name('katalog.create');
    Route::post('/katalog', [KatalogController::class, 'store'])->name('katalog.store');
    Route::get('/katalog/{katalog}/edit', [KatalogController::class, 'edit'])->name('katalog.edit');
    Route::put('/katalog/{katalog}', [KatalogController::class, 'update'])->name('katalog.update');
    Route::get('/admin/katalog/index', [KatalogController::class, 'index'])->name('katalog.index');
});


// Rute Admin Dashboard
Route::middleware(['auth', CheckUserStatus::class])->group(function () {
    Route::get('/admin/users/index', [UserController::class, 'index'])->name('backend.users.index');
});
