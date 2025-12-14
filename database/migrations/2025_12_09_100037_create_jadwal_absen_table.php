<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('jadwal_absen')) {
            Schema::create('jadwal_absen', function (Blueprint $table) {
                $table->id();
                $table->string('nama_kegiatan', 120);
                $table->time('jam_mulai');
                $table->time('jam_selesai');
                $table->string('kode', 50)->nullable()->index();
                $table->text('keterangan')->nullable();
                $table->boolean('aktif')->default(true); // agar admin bisa nonaktifkan
                $table->timestamps();
                $table->index(['jam_mulai','jam_selesai']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_absen');
    }
};
