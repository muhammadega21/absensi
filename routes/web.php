<?php

use App\Http\Controllers\AbsenController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UnitKerjaController;
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

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');

    // Unit Kerja
    Route::controller(UnitKerjaController::class)->group(function () {
        Route::get('/unit_kerja', 'index');
        Route::post('/unit_kerja', 'store');
        Route::put('/unit_kerja/update/{id}', 'update');
        Route::get('/unit_kerja/delete/{id}', 'destroy');
    });

    // Karyawan
    Route::controller(KaryawanController::class)->group(function () {
        Route::get('/karyawan', 'index');
        Route::post('/karyawan', 'store');
        Route::put('/karyawan/update/{id}', 'update');
        Route::get('/karyawan/delete/{id}', 'destroy');
        Route::get('/user/{id}/qr-code', 'showQrCode');
    });

    // Absen
    Route::controller(AbsenController::class)->group(function () {
        Route::get('/absen', 'index');
        Route::get('/absen/list/{id}', 'show');
        Route::get('/absen/attendace/{id}', 'attendace');
        Route::post('/absen/checkin/{id}', 'checkin');
        Route::post('/absen/checkout/{id}', 'checkout');
        Route::post('/absen', 'store');
        Route::put('/absen/update/{id}', 'update');
        Route::get('/absen/delete/{id}', 'destroy');
    });
});
