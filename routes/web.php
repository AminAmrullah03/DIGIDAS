<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AbsensiController;
use Illuminate\Support\Facades\Route;
use App\Models\Santri;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Group route dengan auth middleware
Route::middleware(['auth'])->group(function () {

    // ✅ Halaman Absensi
    Route::get('/absen', [AbsensiController::class, 'index'])->name('absen');
    Route::post('/absen', [AbsensiController::class, 'store'])->name('absen.store');

    // ✅ Halaman Rekap
    Route::get('/rekap', [AbsensiController::class, 'rekap'])->name('rekap');

    // ✅ Halaman Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ✅ Import CSV santri (sementara, nanti bisa dipindah ke controller)
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
            continue; // skip header
        }

        $nis = trim($data[0]);
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

Route::get('/rekap-data', [AbsensiController::class, 'rekapData'])->name('rekap.data');

require __DIR__.'/auth.php';
