<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $driver = DB::connection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE perpulangan_santri MODIFY status VARCHAR(30) NOT NULL DEFAULT 'menunggu'");
        } elseif ($driver === 'pgsql') {
            DB::statement("ALTER TABLE perpulangan_santri ALTER COLUMN status TYPE VARCHAR(30)");
        }
    }

    public function down(): void
    {
        $driver = DB::connection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement("UPDATE perpulangan_santri SET status = 'kembali' WHERE status = 'terlambat_kembali'");
            DB::statement("UPDATE perpulangan_santri SET status = 'menunggu' WHERE status = 'kabur'");
            DB::statement("ALTER TABLE perpulangan_santri MODIFY status ENUM('menunggu','sebagian','diizinkan','keluar','kembali') NOT NULL DEFAULT 'menunggu'");
        }
    }
};
