<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\WaliRekapController;
use App\Http\Controllers\Admin\JadwalAbsenController;
use Illuminate\Support\Facades\Route;
use App\Models\Santri;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// ✅ Route khusus wali santri (akses hanya dari domain wali)
// Penting: harus didaftarkan sebelum route /rekap umum agar tidak ketiban.
$waliDomain = trim(explode(',', (string) env('WALI_DOMAIN', ''))[0] ?? '');
if ($waliDomain !== '') {
    Route::domain($waliDomain)
        ->middleware(['auth', 'wali.domain'])
        ->group(function () {
            Route::get('/rekap', [WaliRekapController::class, 'index'])->name('wali.rekap');
            Route::get('/rekap-data', [WaliRekapController::class, 'data'])->name('wali.rekap.data');
        });
}

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
    Route::get('/rekap-data', [AbsensiController::class, 'rekapData'])->name('rekap.data');

    // ✅ Halaman Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ✅ Jadwal Absen
    Route::prefix('jadwal')->as('jadwal.')->group(function () {
        Route::get('/', [JadwalAbsenController::class, 'index'])->name('index');
        Route::get('/create', [JadwalAbsenController::class, 'create'])->name('create');
        Route::post('/', [JadwalAbsenController::class, 'store'])->name('store');
        Route::get('/{jadwalAbsen}/edit', [JadwalAbsenController::class, 'edit'])->name('edit');
        Route::put('/{jadwalAbsen}', [JadwalAbsenController::class, 'update'])->name('update');
        Route::delete('/{jadwalAbsen}', [JadwalAbsenController::class, 'destroy'])->name('destroy');
        Route::post('/{jadwalAbsen}/toggle', [JadwalAbsenController::class, 'toggleAktif'])->name('toggle');
    });
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

require __DIR__.'/auth.php';
