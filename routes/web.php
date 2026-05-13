<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\PemilikController;
use App\Http\Controllers\AdminController;


// ROUTE PELANGGAN 
Route::get('/', function () {

    if (auth()->check()) {

        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.beranda');
        }

        if (auth()->user()->role === 'pemilik') {
            return redirect()->route('pemilik.beranda');
        }
    }

    return app(PelangganController::class)->beranda();
})->name('pelanggan.beranda');


Route::get('/properti', [PelangganController::class, 'properti'])
    ->name('pelanggan.properti');

Route::get('/properti/{id}', [PelangganController::class, 'detail'])
    ->name('pelanggan.detail');

Route::get('/kontak', [PelangganController::class, 'kontak'])
    ->name('pelanggan.kontak');

Route::post('/kontak/kirim', [KontakController::class, 'kirim'])
    ->name('kontak.kirim');



// ROUTE AUTH (GUEST ONLY)
Route::middleware('guest')->group(function () {

    Route::get('/masuk', [AuthController::class, 'showLogin'])
        ->name('masuk');

    Route::post('/masuk', [AuthController::class, 'login']);

    Route::get('/daftar', [AuthController::class, 'showRegister'])
        ->name('daftar');

    Route::post('/daftar', [AuthController::class, 'register']);
});



// ROUTE LOGOUT
Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});


// ROUTE PEMILIK
Route::middleware(['auth', 'role:pemilik'])->prefix('pemilik')->group(function () {

    Route::get('/', [PemilikController::class, 'beranda'])
        ->name('pemilik.beranda');

    Route::get('/{id}/edit', [PemilikController::class, 'edit'])
        ->name('pemilik.edit');

    Route::put('/{id}', [PemilikController::class, 'update'])
        ->name('pemilik.update');

    Route::delete('/{id}', [PemilikController::class, 'destroy'])
        ->name('pemilik.destroy');

    Route::put('/{id}/update-foto', [PemilikController::class, 'updateFoto'])
        ->name('pemilik.updateFoto');

    Route::delete('/{id}/hapus-foto', [PemilikController::class, 'hapusFoto'])
        ->name('pemilik.hapusFoto');

    Route::get('/upload', [PemilikController::class, 'upload'])
        ->name('pemilik.upload');

    Route::post('/upload', [PemilikController::class, 'store'])
        ->name('pemilik.store');

    Route::get('/riwayat', [PemilikController::class, 'riwayat'])
        ->name('pemilik.riwayat');

    Route::get('/pembayaran', [PemilikController::class, 'pembayaran'])
        ->name('pemilik.pembayaran');

    Route::get('/pembayaran/{id}', [PemilikController::class, 'pembayaranDetail'])
        ->name('pemilik.detail');

    Route::post('/pembayaran/{id}', [PemilikController::class, 'uploadBukti'])
        ->name('pemilik.upload.bukti');
});

 // ROUTE ADMIN
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {

    Route::get('/', [AdminController::class, 'beranda'])
        ->name('admin.beranda');

    Route::post('/unggulan', [AdminController::class, 'unggulan'])
        ->name('admin.unggulan');

    Route::get('/verifikasi', [AdminController::class, 'verifikasi'])
        ->name('admin.verifikasi');

    Route::get('/properti/{id}', [AdminController::class, 'detail'])
        ->name('admin.detail');

    Route::post('/properti/{id}/{aksi}', [AdminController::class, 'verifikasiProses'])
        ->name('admin.proses');

    Route::get('/banner', [AdminController::class, 'uploadBannerForm'])
        ->name('admin.upload');

    Route::post('/banner', [AdminController::class, 'uploadBanner'])
        ->name('admin.banner.store');

    Route::get('/pembayaran', [AdminController::class, 'pembayaran'])
        ->name('admin.pembayaran');

    Route::get('/pembayaran/{id}', [AdminController::class, 'detailPembayaran'])
        ->name('admin.detailpembayaran');

    Route::post('/pembayaran/{id}/validasi', [AdminController::class, 'validasiPembayaran'])
        ->name('admin.validasi.pembayaran');

    Route::post('/tolak-pembayaran/{id}', [AdminController::class, 'tolakPembayaran'])
    ->name('admin.tolak.pembayaran');
});
