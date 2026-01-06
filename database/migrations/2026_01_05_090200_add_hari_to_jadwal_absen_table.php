<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwal_absen', function (Blueprint $table) {
            if (!Schema::hasColumn('jadwal_absen', 'hari')) {
                $table->json('hari')->nullable()->after('jam_selesai');
            }
        });
    }

    public function down(): void
    {
        Schema::table('jadwal_absen', function (Blueprint $table) {
            if (Schema::hasColumn('jadwal_absen', 'hari')) {
                $table->dropColumn('hari');
            }
        });
    }
};
