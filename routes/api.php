<?php

use App\Http\Controllers\Api\PresensiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::post('/presensi', [PresensiController::class, 'store']);
