<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\SppController;
use App\Http\Controllers\IzinController;
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
})->middleware(['auth', 'verified'])->name('dashboard');

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

    // Import CSV Santri
    Route::get('/import-santri', function () {
        $path = storage_path('app/public/santri.csv');

        if (!file_exists($path)) {
            return "❌ File CSV tidak ditemukan di: $path";
        }

        $file = fopen($path, 'r');
        $isFirstRow = true;
        $count = 0;

        while (($data = fgetcsv($file, 1000, ',')) !== FALSE) {
            if ($isFirstRow) {
                $isFirstRow = false;
                continue;
            }

            $nis  = trim($data[0]);
            $nama = trim($data[1]);
            $kelas = trim($data[2] ?? '');

            if (!$nis || !$nama) continue;

            Santri::updateOrCreate(
                ['nis' => $nis],
                ['nama' => $nama, 'kelas' => $kelas]
            );

            $count++;
        }

        fclose($file);
        return "✅ Import selesai! Jumlah data masuk: {$count}";
    });
});

require __DIR__.'/auth.php';