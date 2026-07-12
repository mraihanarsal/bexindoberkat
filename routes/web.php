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

    // Dashboard Pengguna Routes (Only for Owner)
    Route::get('/dashboard/kelola_pengguna', [App\Http\Controllers\PenggunaController::class, 'index']);
    Route::post('/dashboard/kelola_pengguna', [App\Http\Controllers\PenggunaController::class, 'store']);
    Route::put('/dashboard/kelola_pengguna/{id}', [App\Http\Controllers\PenggunaController::class, 'update']);
    Route::delete('/dashboard/kelola_pengguna/{id}', [App\Http\Controllers\PenggunaController::class, 'destroy']);
    Route::get('/dashboard/kategori', [App\Http\Controllers\KategoriController::class, 'index']);
    Route::post('/dashboard/kategori', [App\Http\Controllers\KategoriController::class, 'store']);
    Route::put('/dashboard/kategori/{id}', [App\Http\Controllers\KategoriController::class, 'update']);
    Route::delete('/dashboard/kategori/{id}', [App\Http\Controllers\KategoriController::class, 'destroy']);
    Route::get('/dashboard/produk', [App\Http\Controllers\ProdukController::class, 'index']);

    // Platform Routes
    Route::get('/dashboard/kelola_platform', [App\Http\Controllers\PlatformController::class, 'index']);
    Route::post('/dashboard/kelola_platform', [App\Http\Controllers\PlatformController::class, 'store']);
    Route::put('/dashboard/kelola_platform/{id}', [App\Http\Controllers\PlatformController::class, 'update']);
    Route::delete('/dashboard/kelola_platform/{id}', [App\Http\Controllers\PlatformController::class, 'destroy']);
    Route::patch('/dashboard/kelola_platform/{id}/activate', [App\Http\Controllers\PlatformController::class, 'activate']);

    // Toko Routes
    Route::get('/dashboard/kelola_toko', [App\Http\Controllers\TokoController::class, 'index']);
    Route::post('/dashboard/kelola_toko', [App\Http\Controllers\TokoController::class, 'store']);
    Route::put('/dashboard/kelola_toko/{id}', [App\Http\Controllers\TokoController::class, 'update']);
    Route::delete('/dashboard/kelola_toko/{id}', [App\Http\Controllers\TokoController::class, 'destroy']);
    Route::patch('/dashboard/kelola_toko/{id}/activate', [App\Http\Controllers\TokoController::class, 'activate']);

    // Pemasukan Mockup Routes
    Route::get('/pemasukan/input', [App\Http\Controllers\PemasukanController::class, 'input'])->name('pemasukan.input');
    Route::post('/pemasukan/store', [App\Http\Controllers\PemasukanController::class, 'store'])->name('pemasukan.store');
    Route::post('/pemasukan/upload-pdf', [App\Http\Controllers\PemasukanController::class, 'uploadPdf'])->name('pemasukan.upload_pdf');
    Route::get('/pemasukan/riwayat', [App\Http\Controllers\PemasukanController::class, 'riwayat'])->name('pemasukan.riwayat');
    Route::get('/pemasukan/grafik', [App\Http\Controllers\PemasukanController::class, 'grafik'])->name('pemasukan.grafik');
    Route::delete('/pemasukan/{id}', [App\Http\Controllers\PemasukanController::class, 'destroy'])->name('pemasukan.destroy');

    // Pengeluaran Mockup Routes
    Route::get('/pengeluaran/input', [App\Http\Controllers\PengeluaranController::class, 'input'])->name('pengeluaran.input');
    Route::post('/pengeluaran/store', [App\Http\Controllers\PengeluaranController::class, 'store'])->name('pengeluaran.store');
    Route::get('/pengeluaran/riwayat', [App\Http\Controllers\PengeluaranController::class, 'riwayat'])->name('pengeluaran.riwayat');
    Route::delete('/pengeluaran/{id}', [App\Http\Controllers\PengeluaranController::class, 'destroy'])->name('pengeluaran.destroy');

    // Laporan Mockup Route
    Route::get('/laporan', [App\Http\Controllers\LaporanController::class, 'index']);
});

require __DIR__.'/auth.php';
