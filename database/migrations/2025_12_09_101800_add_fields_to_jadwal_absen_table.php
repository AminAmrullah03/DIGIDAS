<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('jadwal_absen', function (Blueprint $table) {
            if (!Schema::hasColumn('jadwal_absen', 'kode')) {
                $table->string('kode', 50)->nullable()->after('jam_selesai');
                $table->index('kode');
            }
            if (!Schema::hasColumn('jadwal_absen', 'keterangan')) {
                $table->text('keterangan')->nullable()->after('kode');
            }
            if (!Schema::hasColumn('jadwal_absen', 'aktif')) {
                $table->boolean('aktif')->default(true)->after('keterangan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('jadwal_absen', function (Blueprint $table) {
            if (Schema::hasColumn('jadwal_absen', 'aktif')) {
                $table->dropColumn('aktif');
            }
            if (Schema::hasColumn('jadwal_absen', 'keterangan')) {
                $table->dropColumn('keterangan');
            }
            if (Schema::hasColumn('jadwal_absen', 'kode')) {
                // drop index if exists is not straightforward; Laravel will drop automatically if named conventionally
                $table->dropIndex(['kode']);
                $table->dropColumn('kode');
            }
        });
    }
};
