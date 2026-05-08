<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tahunAjaran = DB::table('tahun_ajaran')->where('status', 'aktif')->first()
            ?? DB::table('tahun_ajaran')->orderBy('id')->first();

        if (! $tahunAjaran) {
            DB::table('tahun_ajaran')->insert([
                'nama' => '2025/2026',
                'tahun_hijriah' => 1446,
                'tahun_masehi' => 2025,
                'tanggal_mulai' => '2025-07-14',
                'tanggal_selesai' => '2026-07-02',
                'nominal_spp' => 50000,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $tahunAjaran = DB::table('tahun_ajaran')->where('status', 'aktif')->first();
        }

        foreach (['spp_tagihan', 'spp_pembayaran', 'absensi'] as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'tahun_ajaran_id')) {
                DB::table($table)
                    ->whereNull('tahun_ajaran_id')
                    ->update(['tahun_ajaran_id' => $tahunAjaran->id]);
            }
        }

        if (! Schema::hasTable('santri_kelas')) {
            return;
        }

        DB::table('santri')
            ->whereNotNull('kelas')
            ->where('kelas', '!=', '')
            ->orderBy('nis')
            ->select('nis', 'kelas')
            ->chunk(200, function ($santriRows) use ($tahunAjaran) {
                foreach ($santriRows as $santri) {
                    DB::table('santri_kelas')->updateOrInsert(
                        ['nis' => $santri->nis, 'tahun_ajaran_id' => $tahunAjaran->id],
                        [
                            'kelas' => $santri->kelas,
                            'diubah_oleh' => 'Repair Migration',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );
                }
            });
    }

    public function down(): void
    {
        // Repair migration intentionally has no rollback.
    }
};
