<?php

use App\Http\Controllers\Api\AbsensiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\IzinController;
use App\Http\Controllers\Api\JadwalAbsenController;
use App\Http\Controllers\Api\PerpulanganController;
use App\Http\Controllers\Api\SantriController;
use App\Http\Controllers\Api\SppController;
use App\Support\ApiResponse;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (tanpa login)
|--------------------------------------------------------------------------
*/

Route::get('/ping', function () {
    return ApiResponse::success(null, 'API hidup');
});

Route::post('/login', [AuthController::class, 'login']);


/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES (WAJIB LOGIN)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | AUTH USER
    |--------------------------------------------------------------------------
    */
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/logout-all', [AuthController::class, 'logoutAll']);


    /*
    |--------------------------------------------------------------------------
    | SANTRI (semua user login bisa lihat list)
    |--------------------------------------------------------------------------
    */
    Route::get('/santri', [SantriController::class, 'index']);

    // Scan QR santri (semua role yang login bisa scan untuk lihat status)
    Route::get('/perpulangan/scan/{nis}', [PerpulanganController::class, 'scan']);


    /*
    |--------------------------------------------------------------------------
    | ROLE: SUPERADMIN & GURU
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:superadmin,guru')->group(function () {

        Route::get('/santri/kelas', [SantriController::class, 'kelas']);
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

        // Perpulangan
        Route::get('/perpulangan/rekap', [PerpulanganController::class, 'rekap']);
        Route::post('/perpulangan/approve/musrif', [PerpulanganController::class, 'approveMusrif']);
        Route::post('/perpulangan/approve/keamanan', [PerpulanganController::class, 'approveKeamanan']);
        Route::post('/perpulangan/kembali', [PerpulanganController::class, 'kembali']);
    });


    /*
    |--------------------------------------------------------------------------
    | ROLE: SUPERADMIN ONLY (SPP)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:superadmin')->group(function () {
        Route::post('/perpulangan/approve/spp', [PerpulanganController::class, 'approveSpp']);

        Route::prefix('spp')->group(function () {
            Route::get('/tagihan', [SppController::class, 'tagihan']);
            Route::post('/bayar', [SppController::class, 'bayar']);
            Route::get('/riwayat', [SppController::class, 'riwayat']);
        });
    });

});