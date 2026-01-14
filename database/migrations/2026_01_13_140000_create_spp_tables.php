<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel tagihan SPP
        Schema::create('spp_tagihan', function (Blueprint $table) {
            $table->id();
            $table->string('nis');
            $table->tinyInteger('bulan'); // 1-12
            $table->year('tahun');
            $table->decimal('nominal', 12, 2)->default(0);
            $table->enum('status', ['belum', 'lunas', 'sebagian'])->default('belum');
            $table->timestamps();

            $table->foreign('nis')->references('nis')->on('santri')->onDelete('cascade');
            $table->unique(['nis', 'bulan', 'tahun']);
        });

        // Tabel pembayaran SPP
        Schema::create('spp_pembayaran', function (Blueprint $table) {
            $table->id();
            $table->string('nis');
            $table->tinyInteger('bulan'); // 1-12
            $table->year('tahun');
            $table->decimal('nominal_bayar', 12, 2);
            $table->enum('metode', ['cash', 'transfer'])->default('cash');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('nis')->references('nis')->on('santri')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spp_pembayaran');
        Schema::dropIfExists('spp_tagihan');
    }
};
