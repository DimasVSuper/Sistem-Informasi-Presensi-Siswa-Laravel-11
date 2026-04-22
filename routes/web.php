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
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.post');

    // Apabila ingin menggunakan GET untuk logout, karena guest yang iseng akses logout, maka tambahkan route GET untuk logout
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout.get');
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout.get');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard & Master Data Routes (Protected)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::resource('orang-tua', OrangTuaController::class);
    Route::resource('siswa', SiswaController::class);
});
