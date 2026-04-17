<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('scan');
});

Route::get('/scan', function () {
    return view('scan');
})->name('scan');

Route::get('/generate', function () {
    $siswa = \App\Models\Siswa::all();
    return view('generate', compact('siswa'));
})->name('generate');
