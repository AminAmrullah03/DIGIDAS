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
            $table->unsignedBigInteger('jadwal_id')->nullable();
            $table->timestamp('waktu')->useCurrent();
            $table->string('status', 20)->default('Hadir');
            $table->string('kegiatan', 255)->nullable();
            $table->timestamps();

            $table->index('nis');
            $table->index('jadwal_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};
