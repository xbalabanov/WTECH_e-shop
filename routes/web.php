<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileSettingsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/homepage.html');
});

Route::view('/homepage.html', 'homepage')->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login.html', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');

    Route::get('/register.html', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::view('/profile.html', 'profile')->name('profile');
    Route::get('/profile-settings.html', [ProfileSettingsController::class, 'edit'])->name('profile.settings');
    Route::post('/profile-settings.html', [ProfileSettingsController::class, 'update'])->name('profile.settings.update');
});
