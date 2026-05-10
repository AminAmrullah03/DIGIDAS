<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('izin', function (Blueprint $table) {
            $table->unsignedInteger('durasi_menit')->nullable()->after('keperluan');
            $table->timestamp('batas_waktu_kembali')->nullable()->after('waktu_keluar');
            $table->unsignedInteger('terlambat_menit')->nullable()->after('waktu_kembali');
        });

        $driver = DB::connection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE izin MODIFY status VARCHAR(30) NOT NULL DEFAULT 'Belum Kembali'");
            DB::statement("UPDATE izin SET durasi_menit = 1440, batas_waktu_kembali = DATE_ADD(waktu_keluar, INTERVAL 1 DAY) WHERE durasi_menit IS NULL");
        } elseif ($driver === 'pgsql') {
            DB::statement("ALTER TABLE izin ALTER COLUMN status TYPE VARCHAR(30)");
            DB::statement("UPDATE izin SET durasi_menit = 1440, batas_waktu_kembali = waktu_keluar + INTERVAL '1 day' WHERE durasi_menit IS NULL");
        } else {
            DB::statement("UPDATE izin SET durasi_menit = 1440, batas_waktu_kembali = datetime(waktu_keluar, '+1 day') WHERE durasi_menit IS NULL");
        }
    }

    public function down(): void
    {
        Schema::table('izin', function (Blueprint $table) {
            $table->dropColumn(['durasi_menit', 'batas_waktu_kembali', 'terlambat_menit']);
        });

        if (DB::connection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE izin MODIFY status ENUM('Belum Kembali', 'Sudah Kembali') NOT NULL DEFAULT 'Belum Kembali'");
        }
    }
};
