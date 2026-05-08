<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('santri_kelas', function (Blueprint $table) {
            $table->id();
            $table->string('nis', 50);
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajaran')->cascadeOnDelete();
            $table->string('kelas', 50);
            $table->string('diubah_oleh', 255)->nullable();
            $table->timestamps();

            $table->unique(['nis', 'tahun_ajaran_id']);
            $table->foreign('nis')->references('nis')->on('santri')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('santri_kelas');
    }
};
