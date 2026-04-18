<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrangTuaController;
use App\Http\Controllers\SiswaController;
use App\Models\Siswa;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('scan');
});

Route::get('/scan', function () {
    return view('QR.scan');
})->name('scan');

Route::get('/generate', function () {
    $siswa = Siswa::all();

    return view('QR.generate', compact('siswa'));
})->name('generate');

// Authentication Routes
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard & Master Data Routes (Protected)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::resource('orang-tua', OrangTuaController::class);
    Route::resource('siswa', SiswaController::class);
});
