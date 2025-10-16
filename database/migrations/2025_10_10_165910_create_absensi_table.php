<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->string('nis', 50);
            $table->timestamp('waktu')->useCurrent();
            $table->string('status', 20)->default('Hadir');
            $table->timestamps();

            // Foreign key opsional (kalau ingin keterkaitan santri)
            $table->foreign('nis')->references('nis')->on('santri')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};
