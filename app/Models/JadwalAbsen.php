<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalAbsen extends Model
{
    use HasFactory;

    protected $table = 'jadwal_absen';
    protected $fillable = ['nama_kegiatan', 'jam_mulai', 'jam_selesai'];

    public function absensis()
    {
        return $this->hasMany(Absensi::class, 'jadwal_id');
    }
}
