<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\SppController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SantriController;
use App\Http\Controllers\Admin\JadwalAbsenController;
use Illuminate\Support\Facades\Route;
use App\Models\Santri;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// Dashboard — semua role yang sudah login bisa akses
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// ─────────────────────────────────────────────────────────────────────────────
// ROUTES UNTUK SUPERADMIN & GURU (shared)
// Kedua role bisa akses: absen, rekap absensi, izin, profile
// ─────────────────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:superadmin,guru'])->group(function () {

    // Halaman Absensi
    Route::get('/absen', [AbsensiController::class, 'index'])->name('absen');
    Route::post('/absen', [AbsensiController::class, 'store'])->name('absen.store');

    // Halaman Rekap Absensi
    Route::get('/rekap', [AbsensiController::class, 'rekap'])->name('rekap');
    Route::post('/rekap/update-status', [AbsensiController::class, 'updateStatus'])->name('rekap.updateStatus');
    Route::get('/rekap-data', [AbsensiController::class, 'rekapData'])->name('rekap.data');

    // Perizinan
    Route::prefix('izin')->as('izin.')->group(function () {
        Route::get('/', [IzinController::class, 'index'])->name('index');
        Route::get('/santri', [IzinController::class, 'getSantri'])->name('santri');
        Route::post('/store', [IzinController::class, 'store'])->name('store');
        Route::post('/kembali', [IzinController::class, 'kembali'])->name('kembali');
        Route::get('/rekap', [IzinController::class, 'rekap'])->name('rekap');
        Route::post('/update-status', [IzinController::class, 'updateStatus'])->name('updateStatus');
    });

    // Profile (semua role bisa edit profil sendiri)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ─────────────────────────────────────────────────────────────────────────────
// ROUTES KHUSUS SUPERADMIN
// Hanya superadmin yang bisa akses: jadwal, SPP, import santri
// ─────────────────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:superadmin'])->group(function () {

    // Manajemen Santri
    Route::prefix('admin/santri')->as('admin.santri.')->group(function () {
        Route::get('/', [SantriController::class, 'index'])->name('index');
        Route::get('/create', [SantriController::class, 'create'])->name('create');
        Route::post('/', [SantriController::class, 'store'])->name('store');
        Route::post('/import', [SantriController::class, 'import'])->name('import');
        Route::get('/{santri}', [SantriController::class, 'show'])->name('show');
        Route::get('/{santri}/edit', [SantriController::class, 'edit'])->name('edit');
        Route::put('/{santri}', [SantriController::class, 'update'])->name('update');
        Route::delete('/{santri}', [SantriController::class, 'destroy'])->name('destroy');
    });

    // Manajemen User
    Route::prefix('admin/users')->as('admin.users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::patch('/{user}/reset-password', [UserController::class, 'resetPassword'])->name('resetPassword');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    });

    // Jadwal Absen
    Route::prefix('jadwal')->as('jadwal.')->group(function () {
        Route::get('/', [JadwalAbsenController::class, 'index'])->name('index');
        Route::get('/create', [JadwalAbsenController::class, 'create'])->name('create');
        Route::post('/', [JadwalAbsenController::class, 'store'])->name('store');
        Route::get('/{jadwalAbsen}/edit', [JadwalAbsenController::class, 'edit'])->name('edit');
        Route::put('/{jadwalAbsen}', [JadwalAbsenController::class, 'update'])->name('update');
        Route::delete('/{jadwalAbsen}', [JadwalAbsenController::class, 'destroy'])->name('destroy');
        Route::post('/{jadwalAbsen}/toggle', [JadwalAbsenController::class, 'toggleAktif'])->name('toggle');
    });

    // SPP (Pembayaran)
    Route::prefix('spp')->as('spp.')->group(function () {
        Route::get('/', [SppController::class, 'index'])->name('index');
        Route::get('/rekap', [SppController::class, 'rekap'])->name('rekap');
        Route::get('/santri', [SppController::class, 'getSantriSpp'])->name('santri');
        Route::post('/bayar', [SppController::class, 'store'])->name('store');
        Route::get('/riwayat', [SppController::class, 'riwayat'])->name('riwayat');
    });

    // Import lama dipindah ke SantriController::import

});

require __DIR__.'/auth.php';