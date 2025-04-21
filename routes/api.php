<?php

use App\Http\Controllers\API\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::get('/user', [AuthController::class, 'getAuthenticatedUser']);
    Route::post('/has-permission', [AuthController::class, 'hasPermission']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/logout', [AuthController::class, 'logout']);
});
