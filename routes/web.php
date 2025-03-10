<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\PostController;
use App\Http\Controllers\VoteController; // Add this import

Route::middleware(['auth'])->group(function () {
    // Home page route to show posts (protected)
    Route::get('/', [PostController::class, 'index'])->name('home');

    Route::resource('/posts', PostController::class);
    
    // Add vote routes
    Route::post('/votes', [VoteController::class, 'store'])->name('votes.store');
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';