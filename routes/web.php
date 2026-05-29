<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FoodOrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// ─── Guest routes ────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/',         [AuthController::class, 'showLogin'])->name('home');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register']);
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);
});

// ─── Authenticated routes ─────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Users CRUD
    Route::get('/users',          [UserController::class, 'index'])->name('users.index');
    Route::post('/users',         [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{user}',   [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}',[UserController::class, 'destroy'])->name('users.destroy');

    // Food Orders CRUD
    Route::get('/food-orders',               [FoodOrderController::class, 'index'])->name('food-orders.index');
    Route::post('/food-orders',              [FoodOrderController::class, 'store'])->name('food-orders.store');
    Route::put('/food-orders/{foodOrder}',   [FoodOrderController::class, 'update'])->name('food-orders.update');
    Route::delete('/food-orders/{foodOrder}',[FoodOrderController::class, 'destroy'])->name('food-orders.destroy');

    // Profile
    Route::get('/profile',                   [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile',                   [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password',          [ProfileController::class, 'changePassword'])->name('profile.password');
    Route::post('/profile/picture',          [ProfileController::class, 'uploadPicture'])->name('profile.picture');
});
