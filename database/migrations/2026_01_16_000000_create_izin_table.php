<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('izin', function (Blueprint $table) {
            $table->id();
            $table->string('nis', 50);
            $table->text('keperluan');
            $table->timestamp('waktu_keluar')->useCurrent();
            $table->timestamp('waktu_kembali')->nullable();
            $table->enum('status', ['Belum Kembali', 'Sudah Kembali'])->default('Belum Kembali');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->index('nis');
            $table->foreign('nis')->references('nis')->on('santri')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('izin');
    }
};
