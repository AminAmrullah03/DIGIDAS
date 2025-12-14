<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('santri')) {
            Schema::create('santri', function (Blueprint $table) {
                // Primary key menggunakan NIS (string)
                $table->string('nis', 50)->primary();
                $table->string('nama');
                $table->string('kelas')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('santri');
    }
};
