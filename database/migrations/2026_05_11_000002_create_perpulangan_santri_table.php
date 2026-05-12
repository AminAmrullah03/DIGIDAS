<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perpulangan_santri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('perpulangan_id')->constrained('perpulangan')->cascadeOnDelete();
            $table->string('nis');
            $table->foreign('nis')->references('nis')->on('santri')->cascadeOnDelete();

            // Status keseluruhan santri dalam event ini
            $table->enum('status', [
                'menunggu',   // belum ada approval apapun
                'sebagian',   // sudah ada 1 approval (musrif ATAU spp), belum keduanya
                'diizinkan',  // sudah dapat approval musrif + spp, siap ke keamanan
                'keluar',     // sudah melewati checkpoint keamanan / sudah keluar
                'kembali',    // sudah kembali ke pondok
            ])->default('menunggu');

            $table->timestamp('keluar_at')->nullable();   // diisi saat keamanan approve
            $table->timestamp('kembali_at')->nullable();  // diisi saat scan kembali

            $table->timestamps();

            // Satu santri hanya bisa terdaftar sekali per event
            $table->unique(['perpulangan_id', 'nis']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perpulangan_santri');
    }
};
