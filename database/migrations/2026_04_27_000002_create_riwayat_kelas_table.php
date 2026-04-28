<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('riwayat_kelas', function (Blueprint $table) {
            $table->id();
            $table->string('nis', 50);
            $table->string('kelas_lama', 50)->nullable();
            $table->string('kelas_baru', 50);
            $table->string('diubah_oleh')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->foreign('nis')->references('nis')->on('santri')->onDelete('cascade');
        });
    }
    public function down(): void { Schema::dropIfExists('riwayat_kelas'); }
};