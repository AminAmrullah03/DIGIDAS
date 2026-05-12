<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('izin_pulang', function (Blueprint $table) {
            $table->id();
            $table->string('nis', 50);
            $table->text('keperluan');
            $table->unsignedInteger('durasi_hari');
            $table->timestamp('waktu_pulang')->useCurrent();
            $table->timestamp('batas_waktu_kembali');
            $table->timestamp('waktu_kembali')->nullable();
            $table->unsignedInteger('terlambat_menit')->nullable();
            $table->string('status', 30)->default('Belum Kembali');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->index(['nis', 'status']);
            $table->foreign('nis')->references('nis')->on('santri')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('izin_pulang');
    }
};
