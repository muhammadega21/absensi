<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

// Auth
Route::controller(LoginController::class)->group(function () {
    Route::get('/', 'index')->name('login')->middleware('guest');
    Route::get('/login', 'index')->middleware('guest');
    Route::post('/login', 'login');
    Route::get('/register', 'register')->middleware('guest');
    Route::post('/register', 'registerStore')->name('registerStore');
    Route::get('/logout', 'logout')->middleware('auth');
});

Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard')->middleware('auth');
