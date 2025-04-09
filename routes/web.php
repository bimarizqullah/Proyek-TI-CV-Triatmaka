<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\TestimoniController;
use App\Http\Middleware\CheckUserStatus;
use App\Http\Middleware\SuperUser;

// Rute Dashboard Frontend
Route::get('/', [DashboardController::class, 'index']);

// Rute untuk login
Route::get('admin/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('admin/login', [AuthController::class, 'login']);
Route::post('admin/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Rute CRUD User (Hanya bisa diakses oleh Super Admin)

Route::middleware(['auth', CheckUserStatus::class, SuperUser::class])->group(function () {
    Route::resource('profile', UserController::class);
    Route::post('/profile', [UserController::class, 'store'])->name('users.store');
    Route::get('/profile/{user}/edit', [UserController::class, 'edit'])->name('backend.profile.edit');
    Route::put('/profile/{user}', [UserController::class, 'update'])->name('backend.profile.profile');
    Route::get('/admin/profile/', [UserController::class, 'index'])->name('backend.profile.index');
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

// Rute CRUD Testimoni (Bisa diakses oleh Admin dan Super Admin)
Route::middleware(['auth', CheckUserStatus::class])->group(function () {
    Route::resource('testimoni', TestimoniController::class);
    Route::get('admin/testimoni/create', [TestimoniController::class, 'create'])->name('testimoni.create');
    Route::post('/testimoni', [TestimoniController::class, 'store'])->name('testimoni.store');
    Route::get('/testimoni/{testimoni}/edit', [TestimoniController::class, 'edit'])->name('testimoni.edit');
    Route::put('/testimoni/{testimoni}', [TestimoniController::class, 'update'])->name('testimoni.update');
    Route::get('/admin/testimoni/index', [TestimoniController::class, 'index'])->name('testimoni.index');
});


// Rute Admin Dashboard
Route::middleware(['auth', CheckUserStatus::class])->group(function () {
    Route::get('/admin/users/index', [UserController::class, 'index'])->name('backend.users.index');
});
