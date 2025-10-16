<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JadwalAbsenSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jadwal_absen')->insert([
            [
                'nama_kegiatan' => 'Ngaji Pagi',
                'jam_mulai' => '05:30:00',
                'jam_selesai' => '06:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kegiatan' => 'Berangkat Sekolah',
                'jam_mulai' => '06:45:00',
                'jam_selesai' => '07:15:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kegiatan' => 'Madin',
                'jam_mulai' => '18:30:00',
                'jam_selesai' => '20:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kegiatan' => 'Taqror',
                'jam_mulai' => '20:45:00',
                'jam_selesai' => '21:15:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
