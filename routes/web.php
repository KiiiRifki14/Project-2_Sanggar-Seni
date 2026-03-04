<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\AdminController;

// ══════ PUBLIC ══════
Route::get('/', [PublicController::class, 'landing'])->name('landing');

// ══════ AUTH ══════
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ══════ ADMIN (Manajer Sanggar — Pak Yat) ══════
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Event Management
    Route::get('/event', [AdminController::class, 'kelolaEvent'])->name('admin.kelola-event');
    Route::post('/event', [AdminController::class, 'storeEvent'])->name('admin.store-event');
    Route::put('/event/{id}', [AdminController::class, 'updateEvent'])->name('admin.update-event');
    Route::delete('/event/{id}', [AdminController::class, 'deleteEvent'])->name('admin.delete-event');

    // Jadwal Multi-Track
    Route::get('/jadwal', [AdminController::class, 'jadwal'])->name('admin.jadwal');
    Route::post('/jadwal', [AdminController::class, 'storeJadwal'])->name('admin.store-jadwal');
    Route::put('/jadwal/{id}', [AdminController::class, 'updateJadwal'])->name('admin.update-jadwal');
    Route::delete('/jadwal/{id}', [AdminController::class, 'deleteJadwal'])->name('admin.delete-jadwal');

    // Absensi
    Route::get('/absensi', [AdminController::class, 'absensi'])->name('admin.absensi');
    Route::post('/absensi', [AdminController::class, 'updateAbsensi'])->name('admin.update-absensi');

    // Personel Management
    Route::get('/personel', [AdminController::class, 'kelolaPersonel'])->name('admin.kelola-personel');
    Route::post('/personel', [AdminController::class, 'storePersonel'])->name('admin.store-personel');
    Route::put('/personel/{id}', [AdminController::class, 'updatePersonel'])->name('admin.update-personel');
    Route::delete('/personel/{id}', [AdminController::class, 'deletePersonel'])->name('admin.delete-personel');

    // Vendor Management
    Route::get('/vendor', [AdminController::class, 'kelolaVendor'])->name('admin.kelola-vendor');
    Route::post('/vendor', [AdminController::class, 'storeVendor'])->name('admin.store-vendor');
    Route::put('/vendor/{id}', [AdminController::class, 'updateVendor'])->name('admin.update-vendor');
    Route::delete('/vendor/{id}', [AdminController::class, 'deleteVendor'])->name('admin.delete-vendor');

    // Sewa Kostum
    Route::get('/sewa-kostum', [AdminController::class, 'sewaKostum'])->name('admin.sewa-kostum');
    Route::post('/sewa-kostum', [AdminController::class, 'storeSewaKostum'])->name('admin.store-sewa-kostum');
    Route::put('/sewa-kostum/{id}', [AdminController::class, 'updateSewaKostum'])->name('admin.update-sewa-kostum');
    Route::delete('/sewa-kostum/{id}', [AdminController::class, 'deleteSewaKostum'])->name('admin.delete-sewa-kostum');

    // Negosiasi
    Route::get('/negosiasi', [AdminController::class, 'negosiasi'])->name('admin.negosiasi');
    Route::post('/negosiasi', [AdminController::class, 'storeNegosiasi'])->name('admin.store-negosiasi');
    Route::put('/negosiasi/{id}/deal', [AdminController::class, 'setDeal'])->name('admin.set-deal');

    // Keuangan
    Route::get('/keuangan', [AdminController::class, 'keuangan'])->name('admin.keuangan');
    Route::put('/keuangan/{id}', [AdminController::class, 'updateKeuangan'])->name('admin.update-keuangan');
});

// ══════ MEMBER (Personel) ══════
Route::prefix('member')->middleware(['auth', 'member'])->group(function () {
    Route::get('/dashboard', [MemberController::class, 'dashboard'])->name('member.dashboard');
    Route::get('/jadwal', [MemberController::class, 'jadwalSaya'])->name('member.jadwal');
    Route::get('/absensi', [MemberController::class, 'absensiSaya'])->name('member.absensi');
    Route::get('/profil', [MemberController::class, 'profil'])->name('member.profil');
    Route::put('/profil', [MemberController::class, 'updateProfil'])->name('member.profil.update');
});
