<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Public — no session yet, this is how you get one.
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Everything below requires an authenticated Sanctum session
// (or Bearer token, once mobile clients exist).
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Admin/management-only: full user directory.
    Route::get('/users', [UserController::class, 'index'])
        ->middleware('role:admin,management');
});
