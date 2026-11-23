<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MovementController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('movements', MovementController::class)->except(['show', 'create']);
    Route::resource('accounts', AccountController::class)->except(['show', 'create']);
    Route::resource('categories', CategoryController::class)->except(['show', 'create']);
    Route::resource('payment-methods', PaymentMethodController::class)
        ->parameters(['payment-methods' => 'paymentMethod'])
        ->except(['show', 'create']);
    Route::resource('people', PersonController::class)->except(['show', 'create']);
    Route::resource('users', UserController::class)->except(['show', 'create']);
});
