<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class JadwalAbsenSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jadwal_absen')->insert([
            ['nama_kegiatan'=>'Ngaji Pagi','jam_mulai'=>'05:30:00','jam_selesai'=>'06:00:00','hari'=>json_encode([1,2,3]),'kode'=>'NGP','aktif'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['nama_kegiatan'=>'Berangkat Sekolah','jam_mulai'=>'06:45:00','jam_selesai'=>'07:15:00','hari'=>json_encode([1,2,3,4,5,6]),'kode'=>'BRK','aktif'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['nama_kegiatan'=>'Madin','jam_mulai'=>'18:30:00','jam_selesai'=>'20:00:00','hari'=>json_encode([1,3,5]),'kode'=>'MDN','aktif'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['nama_kegiatan'=>'Taqror','jam_mulai'=>'20:45:00','jam_selesai'=>'21:15:00','hari'=>null,'kode'=>'TQR','aktif'=>true,'created_at'=>now(),'updated_at'=>now()],
        ]);
    }
}
