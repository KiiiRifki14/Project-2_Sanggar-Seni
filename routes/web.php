<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\AdminController;

// ══════ PUBLIC ══════
Route::get('/', [PublicController::class, 'landing'])->name('landing');
Route::get('/galeri', [PublicController::class, 'galeri'])->name('galeri');
Route::get('/katalog', [PublicController::class, 'katalog'])->name('katalog');

// ══════ AUTH ══════
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ══════ MEMBER ══════
Route::prefix('member')->middleware(['auth', 'member'])->group(function () {
    Route::get('/dashboard', [MemberController::class, 'dashboard'])->name('member.dashboard');
    Route::get('/profil', [MemberController::class, 'profil'])->name('member.profil');
    Route::put('/profil', [MemberController::class, 'updateProfil'])->name('member.profil.update');
    Route::get('/daftar-les', [MemberController::class, 'daftarLes'])->name('member.daftar-les');
    Route::post('/daftar-les', [MemberController::class, 'storeLes'])->name('member.store-les');
    Route::get('/booking', [MemberController::class, 'booking'])->name('member.booking');
    Route::post('/booking', [MemberController::class, 'storeBooking'])->name('member.store-booking');
    Route::get('/riwayat', [MemberController::class, 'riwayat'])->name('member.riwayat');
    Route::get('/cetak-bukti/{id}', [MemberController::class, 'cetakBukti'])->name('member.cetak-bukti');
});

// ══════ ADMIN ══════
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/validasi-les', [AdminController::class, 'validasiLes'])->name('admin.validasi-les');
    Route::post('/validasi-les/{id}', [AdminController::class, 'processLes'])->name('admin.process-les');
    Route::get('/validasi-booking', [AdminController::class, 'validasiBooking'])->name('admin.validasi-booking');
    Route::post('/validasi-booking/{id}', [AdminController::class, 'processBooking'])->name('admin.process-booking');
    Route::get('/galeri', [AdminController::class, 'galeri'])->name('admin.galeri');
    Route::post('/galeri', [AdminController::class, 'storeGaleri'])->name('admin.store-galeri');
    Route::delete('/galeri/{id}', [AdminController::class, 'deleteGaleri'])->name('admin.delete-galeri');
    Route::get('/siswa', [AdminController::class, 'siswa'])->name('admin.siswa');
    Route::delete('/siswa/{id}', [AdminController::class, 'deleteSiswa'])->name('admin.delete-siswa');
    Route::get('/jadwal', [AdminController::class, 'jadwal'])->name('admin.jadwal');
    Route::delete('/jadwal/{id}', [AdminController::class, 'cancelJadwal'])->name('admin.cancel-jadwal');
    Route::get('/laporan', [AdminController::class, 'laporan'])->name('admin.laporan');
    Route::get('/laporan/export', [AdminController::class, 'exportLaporan'])->name('admin.export-laporan');
});
