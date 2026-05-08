<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Isi tabel santri_kelas dari data santri.kelas yang sudah ada.
     */
    public function up(): void
    {
        $tahunAjaranAktif = DB::table('tahun_ajaran')
            ->where('status', 'aktif')
            ->first() ?? DB::table('tahun_ajaran')->orderBy('id')->first();

        if (! $tahunAjaranAktif) {
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

            $tahunAjaranAktif = DB::table('tahun_ajaran')->where('status', 'aktif')->first();
        }

        DB::table('santri')
            ->whereNotNull('kelas')
            ->where('kelas', '!=', '')
            ->orderBy('nis')
            ->select('nis', 'kelas')
            ->chunk(200, function ($santriRows) use ($tahunAjaranAktif) {
                foreach ($santriRows as $santri) {
                    DB::table('santri_kelas')->updateOrInsert(
                        ['nis' => $santri->nis, 'tahun_ajaran_id' => $tahunAjaranAktif->id],
                        [
                            'kelas' => $santri->kelas,
                            'diubah_oleh' => 'Migrasi Awal',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );
                }
            });
    }

    public function down(): void
    {
        // Tidak bisa di-rollback dengan aman karena data sudah mungkin berubah.
    }
};
