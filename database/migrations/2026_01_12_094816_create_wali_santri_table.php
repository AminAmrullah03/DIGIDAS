<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('wali_santri', function (Blueprint $table) {
            $table->id();
            $table->string('nis', 50); // NIS santri yang diasuh
            $table->string('nama_wali', 100);
            $table->string('no_hp', 20)->nullable();
            $table->string('password');
            $table->string('hubungan', 50)->default('Orang Tua'); // Orang Tua, Wali, dll
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('nis')->references('nis')->on('santri')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wali_santri');
    }
};
