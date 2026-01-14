<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('spp_tagihan', function (Blueprint $table) {
            $table->smallInteger('tahun')->change();
        });

        Schema::table('spp_pembayaran', function (Blueprint $table) {
            $table->smallInteger('tahun')->change();
        });
    }

    public function down(): void
    {
        Schema::table('spp_tagihan', function (Blueprint $table) {
            $table->year('tahun')->change();
        });

        Schema::table('spp_pembayaran', function (Blueprint $table) {
            $table->year('tahun')->change();
        });
    }
};
