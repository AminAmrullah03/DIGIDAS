<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perpulangan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_event', 150);                  // contoh: "Perpulangan Liburan Semester Ganjil 2025"
            $table->date('tanggal_mulai');                      // tanggal perpulangan dibuka
            $table->date('batas_kembali');                      // deadline santri harus kembali
            $table->text('keterangan')->nullable();             // catatan tambahan
            $table->enum('status', ['aktif', 'selesai'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perpulangan');
    }
};
