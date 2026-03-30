<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StallController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\PreorderController;
use App\Http\Controllers\FinanceCategoryController;
use App\Http\Controllers\UserController;

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::post('/api/preorder', [PreorderController::class, 'store'])->name('api.preorder.store');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Route khusus sistem yang wajib login
Route::middleware('auth')->group(function () {
    
    // Route untuk Menu POS Kasir (Kasir & Admin bisa akses)
    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
    Route::get('/pos/{stall}', [PosController::class, 'create'])->name('pos.create');
    Route::post('/pos/{stall}', [PosController::class, 'store'])->name('pos.store');

    // Route profile bawaan breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route KHUSUS ADMIN
    Route::middleware('admin')->group(function () {
        // Route Kelola Users
        Route::resource('users', UserController::class)->except(['show']);
        
        Route::resource('products', ProductController::class);
        // Route untuk Menu Lapak
        Route::resource('stalls', StallController::class);
        Route::patch('/stalls/{stall}/toggle-status', [StallController::class, 'toggleStatus'])->name('stalls.toggle-status');
        // Route Kelola Keuangan
        Route::get('/finances/pdf', [FinanceController::class, 'exportPdf'])->name('finances.pdf');
        Route::resource('finances', FinanceController::class)->except(['show']);
        Route::resource('finance-categories', FinanceCategoryController::class)->except(['create', 'show', 'edit']);
        // Route Laporan
        Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
        Route::get('/reports/sales/pdf', [ReportController::class, 'exportPdf'])->name('reports.sales.pdf');

        // Route Log Aktivitas
        Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');

        // Route Rekap Preorder
        Route::get('/preorders', [PreorderController::class, 'index'])->name('preorders.index');
        Route::patch('/preorders/{preorder}/status', [PreorderController::class, 'updateStatus'])->name('preorders.status');
        Route::delete('/preorders/{preorder}', [PreorderController::class, 'destroy'])->name('preorders.destroy');
    });
});

require __DIR__.'/auth.php';