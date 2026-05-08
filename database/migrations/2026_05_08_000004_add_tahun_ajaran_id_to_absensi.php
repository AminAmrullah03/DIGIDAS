<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('absensi', function (Blueprint $table) {
            // Nullable: data lama tetap valid tanpa tahun_ajaran_id
            $table->foreignId('tahun_ajaran_id')
                  ->nullable()
                  ->after('jadwal_id')
                  ->constrained('tahun_ajaran')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->dropForeign(['tahun_ajaran_id']);
            $table->dropColumn('tahun_ajaran_id');
        });
    }
};
