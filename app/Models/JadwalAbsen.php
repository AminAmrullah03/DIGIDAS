<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalAbsen extends Model
{
    protected $table = 'jadwal_absen';

    protected $fillable = [
        'nama_kegiatan',
        'jam_mulai',
        'jam_selesai',
        'hari',
        'kode',
        'keterangan',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'hari' => 'array',
    ];

    public function absensis()
    {
        return $this->hasMany(Absensi::class, 'jadwal_id');
    }
}
