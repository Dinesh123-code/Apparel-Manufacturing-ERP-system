<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductionBundleController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/* ------------------------------------------------------------------ */
/*  Auth Routes (Breeze)                                                 */
/* ------------------------------------------------------------------ */
require __DIR__ . '/auth.php';

/* ------------------------------------------------------------------ */
/*  Protected Web Routes                                                 */
/* ------------------------------------------------------------------ */
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Profile (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Production Bundles
    Route::resource('bundles', ProductionBundleController::class);
    Route::get('/bundles/{bundle}/print', [ProductionBundleController::class, 'printSlip'])->name('bundles.print');
    Route::get('/bundles-export', [ProductionBundleController::class, 'export'])->name('bundles.export');
    Route::get('/api-styles', [ProductionBundleController::class, 'stylesByBuyer'])->name('styles.by-buyer');
});
