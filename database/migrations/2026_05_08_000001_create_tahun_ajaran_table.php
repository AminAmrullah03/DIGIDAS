<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tahun_ajaran', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 20)->unique();              // "2025/2026"
            $table->smallInteger('tahun_hijriah')->unique();   // 1446
            $table->smallInteger('tahun_masehi');              // 2025
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->decimal('nominal_spp', 12, 2)->default(50000);
            $table->enum('status', ['aktif', 'selesai'])->default('selesai');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tahun_ajaran');
    }
};
