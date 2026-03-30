<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiPosController; // Kita akan buat controller ini di langkah berikutnya

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Di sinilah jalur khusus untuk aplikasi Android Miksusu POS.
| Semua rute di sini otomatis memiliki awalan "/api" di URL-nya.
|
*/

Route::post('/login', [ApiPosController::class, 'login']);

// Nanti kalau aplikasi sudah jadi, kita akan pindahkan ke dalam grup ini 
// agar wajib pakai Token Login:
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/pos/sync', [ApiPosController::class, 'sync']);
    Route::get('/pos/katalog', [ApiPosController::class, 'katalog']);
});