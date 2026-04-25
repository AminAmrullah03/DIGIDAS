<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambah kolom NIP setelah 'name', unique karena dipakai untuk login
            $table->string('nip')->unique()->nullable()->after('name');

            // Email dijadikan nullable karena login tidak lagi pakai email
            $table->string('email')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('nip');
            $table->string('email')->nullable(false)->change();
        });
    }
};