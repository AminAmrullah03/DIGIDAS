<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TahunAjaranSeeder extends Seeder
{
    public function run(): void
    {
        $existing = DB::table('tahun_ajaran')->where('tahun_hijriah', 1446)->first();
        $hasActive = DB::table('tahun_ajaran')->where('status', 'aktif')->exists();

        DB::table('tahun_ajaran')->updateOrInsert(
            ['tahun_hijriah' => 1446],
            [
                'nama'           => '2025/2026',
                'tahun_masehi'   => 2025,
                'tanggal_mulai'  => '2025-07-14',   // 1 Muharram 1446H
                'tanggal_selesai'=> '2026-07-02',
                'nominal_spp'    => 50000,
                'status'         => $existing?->status === 'aktif' || ! $hasActive ? 'aktif' : 'selesai',
                'created_at'     => now(),
                'updated_at'     => now(),
            ]
        );
    }
}
