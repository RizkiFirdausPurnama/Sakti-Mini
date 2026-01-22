<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// --- PUBLIC ROUTES ---

// Register
Route::post('/register', [AuthController::class, 'register']);

// Login dengan Rate Limiting (Maksimal 5x request per menit)
// Middleware 'throttle:5,1' artinya: Max 5 hits dalam 1 menit.
Route::middleware('throttle:5,1')->post('/login', [AuthController::class, 'login']);


// --- PROTECTED ROUTES (Butuh Token) ---
Route::middleware('auth:sanctum')->group(function () {
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Profile
    Route::get('/profile', [AuthController::class, 'profile']);
    
});