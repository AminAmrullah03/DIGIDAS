<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SppPembayaran extends Model
{
    protected $table = 'spp_pembayaran';

    protected $fillable = [
        'nis',
        'bulan',
        'tahun',
        'nominal_bayar',
        'metode',
        'keterangan',
    ];

    protected $casts = [
        'nominal_bayar' => 'decimal:2',
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class, 'nis', 'nis');
    }

    public function getNamaBulanAttribute()
    {
        $bulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
            4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September',
            10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        return $bulan[$this->bulan] ?? '-';
    }
}
