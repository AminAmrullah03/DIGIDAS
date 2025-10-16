<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_absen', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kegiatan');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->timestamps();
        });

        // Tambahkan kolom jadwal_id ke tabel absensi
        Schema::table('absensi', function (Blueprint $table) {
            if (!Schema::hasColumn('absensi', 'jadwal_id')) {
                $table->unsignedBigInteger('jadwal_id')->nullable()->after('nis');
                $table->foreign('jadwal_id')->references('id')->on('jadwal_absen')->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('absensi', function (Blueprint $table) {
            if (Schema::hasColumn('absensi', 'jadwal_id')) {
                $table->dropForeign(['jadwal_id']);
                $table->dropColumn('jadwal_id');
            }
        });

        Schema::dropIfExists('jadwal_absen');
    }
};
