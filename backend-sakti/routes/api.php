<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MahasiswaController; // <--- Import Controller

// Route Public (Login/Register)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Route Protected (Butuh Token)
Route::middleware('auth:sanctum')->group(function () {
    
    // Auth User Info
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);

    // --- MODULE MAHASISWA ---
    // apiResource otomatis membuat route: index, store, show, update, destroy
    Route::apiResource('mahasiswas', MahasiswaController::class);
    
});