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
            $table->string('nama_kegiatan', 255);
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->json('hari')->nullable();
            $table->string('kode', 50)->nullable()->index();
            $table->text('keterangan')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        // Add foreign keys
        Schema::table('absensi', function (Blueprint $table) {
            $table->foreign('nis')->references('nis')->on('santri')->onDelete('cascade');
            $table->foreign('jadwal_id')->references('id')->on('jadwal_absen')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->dropForeign(['nis']);
            $table->dropForeign(['jadwal_id']);
        });

        Schema::dropIfExists('jadwal_absen');
    }
};
