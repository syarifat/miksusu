<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StallController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect()->route('login'); // Langsung lempar ke login
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Route khusus sistem yang wajib login
Route::middleware('auth')->group(function () {
    Route::resource('products', ProductController::class);
    // Route untuk Menu Lapak
    Route::resource('stalls', StallController::class);
    Route::patch('/stalls/{stall}/toggle-status', [StallController::class, 'toggleStatus'])->name('stalls.toggle-status');
    // Route untuk Menu POS Kasir
    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
    Route::get('/pos/{stall}', [PosController::class, 'create'])->name('pos.create');
    Route::post('/pos/{stall}', [PosController::class, 'store'])->name('pos.store');
    // Route Kelola Keuangan
    Route::resource('finances', FinanceController::class)->except(['show']);
    // Route Laporan
    Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('/reports/sales/pdf', [ReportController::class, 'exportPdf'])->name('reports.sales.pdf');

    // Route profile bawaan breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';