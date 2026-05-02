<?php

use App\Http\Controllers\Api\AbsensiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\IzinController;
use App\Http\Controllers\Api\JadwalAbsenController;
use App\Http\Controllers\Api\SantriController;
use App\Http\Controllers\Api\SppController;
use Illuminate\Support\Facades\Route;

Route::get('/ping', function () {
    return response()->json([
        'success' => true,
        'message' => 'API hidup',
    ]);
});

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/logout-all', [AuthController::class, 'logoutAll']);

    Route::middleware('role:superadmin,guru')->group(function () {
        Route::get('/santri/kelas', [SantriController::class, 'kelas']);
        Route::get('/santri', [SantriController::class, 'index']);
        Route::get('/santri/{santri:nis}', [SantriController::class, 'show']);

        Route::get('/jadwal-absen', [JadwalAbsenController::class, 'index']);
        Route::get('/jadwal-absen/current', [JadwalAbsenController::class, 'current']);

        Route::post('/absensi', [AbsensiController::class, 'store']);
        Route::get('/absensi/rekap', [AbsensiController::class, 'rekap']);
        Route::patch('/absensi/status', [AbsensiController::class, 'updateStatus']);

        Route::get('/izin/santri', [IzinController::class, 'santri']);
        Route::post('/izin', [IzinController::class, 'store']);
        Route::post('/izin/kembali', [IzinController::class, 'kembali']);
        Route::get('/izin/rekap', [IzinController::class, 'rekap']);
        Route::patch('/izin/status', [IzinController::class, 'updateStatus']);
    });

    Route::middleware('role:superadmin')->prefix('spp')->group(function () {
        Route::get('/tagihan', [SppController::class, 'tagihan']);
        Route::post('/bayar', [SppController::class, 'bayar']);
        Route::get('/riwayat', [SppController::class, 'riwayat']);
    });
});
