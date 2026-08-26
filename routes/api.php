<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BundleController;
use App\Http\Controllers\Api\DashboardController;
use Illuminate\Support\Facades\Route;

/* ------------------------------------------------------------------ */
/*  Public API Routes                                                    */
/* ------------------------------------------------------------------ */
Route::prefix('v1')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);

    /* ------------------------------------------------------------------ */
    /*  Protected API Routes (Sanctum)                                       */
    /* ------------------------------------------------------------------ */
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index']);

        // Bundles CRUD
        Route::apiResource('bundles', BundleController::class);
    });
});
