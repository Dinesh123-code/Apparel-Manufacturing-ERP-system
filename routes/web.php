<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\MasterDataController;
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

    // Production Bundles (Sewing)
    Route::resource('bundles', ProductionBundleController::class);
    Route::get('/sewing', [ProductionBundleController::class, 'index'])->name('sewing.index');
    Route::get('/bundles/{bundle}/print', [ProductionBundleController::class, 'printSlip'])->name('bundles.print');
    Route::get('/bundles-export', [ProductionBundleController::class, 'export'])->name('bundles.export');
    Route::get('/api-styles', [ProductionBundleController::class, 'stylesByBuyer'])->name('styles.by-buyer');

    // ERP Department Pages & Activity History
    Route::get('/sourcing', [DepartmentController::class, 'sourcing'])->name('sourcing');
    Route::get('/cutting', [DepartmentController::class, 'cutting'])->name('cutting');
    Route::get('/qc', [DepartmentController::class, 'qc'])->name('qc');
    Route::get('/shipping', [DepartmentController::class, 'shipping'])->name('shipping');
    Route::get('/settings', [DepartmentController::class, 'settings'])->name('settings');
    Route::get('/support', [DepartmentController::class, 'support'])->name('support');
    Route::get('/activity-logs', [DepartmentController::class, 'activityLogs'])->name('activity-logs');

    // Master Data Management
    Route::get('/master/buyers', [MasterDataController::class, 'buyers'])->name('master.buyers');
    Route::post('/master/buyers', [MasterDataController::class, 'storeBuyer'])->name('master.buyers.store');
    Route::delete('/master/buyers/{buyer}', [MasterDataController::class, 'destroyBuyer'])->name('master.buyers.destroy');

    Route::get('/master/styles', [MasterDataController::class, 'styles'])->name('master.styles');
    Route::post('/master/styles', [MasterDataController::class, 'storeStyle'])->name('master.styles.store');
    Route::delete('/master/styles/{style}', [MasterDataController::class, 'destroyStyle'])->name('master.styles.destroy');

    Route::get('/master/lines', [MasterDataController::class, 'sewingLines'])->name('master.lines');
    Route::post('/master/lines', [MasterDataController::class, 'storeSewingLine'])->name('master.lines.store');
    Route::delete('/master/lines/{line}', [MasterDataController::class, 'destroySewingLine'])->name('master.lines.destroy');
});
