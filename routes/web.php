<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard Mockup Routes
    Route::get('/dashboard/kelola_pengguna', [App\Http\Controllers\PenggunaController::class, 'index']);
    Route::get('/dashboard/kategori', [App\Http\Controllers\KategoriController::class, 'index']);
    Route::get('/dashboard/produk', [App\Http\Controllers\ProdukController::class, 'index']);

    // Pemasukan Mockup Routes
    Route::get('/pemasukan/input', [App\Http\Controllers\PemasukanController::class, 'input']);
    Route::get('/pemasukan/riwayat', [App\Http\Controllers\PemasukanController::class, 'riwayat']);

    // Pengeluaran Mockup Routes
    Route::get('/pengeluaran/input', [App\Http\Controllers\PengeluaranController::class, 'input']);
    Route::get('/pengeluaran/riwayat', [App\Http\Controllers\PengeluaranController::class, 'riwayat']);

    // Laporan Mockup Route
    Route::get('/laporan', [App\Http\Controllers\LaporanController::class, 'index']);
});

require __DIR__.'/auth.php';
