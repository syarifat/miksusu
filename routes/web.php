<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login'); // Langsung lempar ke login
});

Route::get('/dashboard', function () {
    return view('dashboard'); // Pastikan kamu punya view dashboard atau arahkan ke produk
})->middleware(['auth', 'verified'])->name('dashboard');

// Route khusus sistem yang wajib login
Route::middleware('auth')->group(function () {
    Route::resource('products', ProductController::class);
    
    // Route profile bawaan breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';