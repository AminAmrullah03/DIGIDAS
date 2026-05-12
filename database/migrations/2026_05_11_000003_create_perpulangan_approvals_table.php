<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perpulangan_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('perpulangan_santri_id')
                  ->constrained('perpulangan_santri')
                  ->cascadeOnDelete();

            // Jenis approval: musrif, spp, keamanan
            $table->enum('approval_type', ['musrif', 'spp', 'keamanan']);

            // User yang melakukan approval (guru/superadmin)
            $table->foreignId('approved_by')->constrained('users');

            $table->timestamp('approved_at');
            $table->text('catatan')->nullable();

            $table->timestamps();

            // Satu jenis approval hanya boleh ada sekali per santri per event
            $table->unique(['perpulangan_santri_id', 'approval_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perpulangan_approvals');
    }
};
