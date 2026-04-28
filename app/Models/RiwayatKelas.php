<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class RiwayatKelas extends Model
{
    protected $table    = 'riwayat_kelas';
    protected $fillable = ['nis', 'kelas_lama', 'kelas_baru', 'diubah_oleh', 'catatan'];
    public function santri() { return $this->belongsTo(Santri::class, 'nis', 'nis'); }
}