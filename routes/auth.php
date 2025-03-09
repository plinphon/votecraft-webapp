<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\Auth\UserController;

Route::middleware('guest')->group(function () {
    Route::get('login', [App\Http\Controllers\Auth\UserController::class, 'showLoginForm'])
        ->name('login');
    
    Route::post('login', [App\Http\Controllers\Auth\UserController::class, 'login']);
    
    Route::get('register', [App\Http\Controllers\Auth\UserController::class, 'showRegistrationForm'])
        ->name('register');
    
    Route::post('register', [App\Http\Controllers\Auth\UserController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Volt::route('verify-email', 'auth.verify-email')
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Volt::route('confirm-password', 'auth.confirm-password')
        ->name('password.confirm');
});

Route::post('logout', [App\Http\Controllers\Auth\UserController::class, 'logout']);
