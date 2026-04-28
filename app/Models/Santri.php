<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Santri extends Model
{
    protected $table      = 'santri';
    protected $primaryKey = 'nis';
    public $incrementing  = false;
    protected $keyType    = 'string';
    protected $fillable   = ['nis','nama','kelas','gender','jenjang','status','tanggal_masuk','keterangan'];
    protected $casts      = ['tanggal_masuk' => 'date'];

    public function absensi()    { return $this->hasMany(Absensi::class, 'nis', 'nis'); }
    public function izin()       { return $this->hasMany(Izin::class, 'nis', 'nis'); }
    public function sppTagihan() { return $this->hasMany(SppTagihan::class, 'nis', 'nis'); }
    public function riwayatKelas() { return $this->hasMany(RiwayatKelas::class, 'nis', 'nis')->orderBy('created_at', 'desc'); }

    public function isAktif(): bool { return $this->status === 'aktif'; }

    public function getStatusLabelAttribute(): string {
        return match($this->status) {
            'aktif'       => 'Aktif',
            'lulus'       => 'Lulus',
            'mutasi'      => 'Mutasi',
            'dikeluarkan' => 'Dikeluarkan',
            'wafat'       => 'Wafat',
            default       => ucfirst($this->status ?? ''),
        };
    }

    public function getStatusColorAttribute(): string {
        return match($this->status) {
            'aktif'       => 'green',
            'lulus'       => 'blue',
            'mutasi'      => 'amber',
            'dikeluarkan' => 'red',
            'wafat'       => 'slate',
            default       => 'gray',
        };
    }

    public static function daftarKelas(): array {
        return [
            'PA 1A','PA 1B','PA 2A','PA 2B','PA 3A','PA 3B','PA 4','PA 5','PA 6',
            'PA TAHFIDZ 1','PA TAHFIDZ 2','PA TAHFIDZ 3','PA TAHFIDZ 4',
            'PI 1A','PI 1B','PI 1C','PI 2A','PI 2B','PI 2C','PI 3A','PI 3B','PI 3C','PI 4','PI 5','PI 6',
            'PI TAHFIDZ 1','PI TAHFIDZ 2','PI TAHFIDZ 3','PI TAHFIDZ 4','PI TAHFIDZ 5',
        ];
    }
}