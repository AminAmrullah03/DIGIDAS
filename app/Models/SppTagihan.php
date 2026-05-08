<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SppTagihan extends Model
{
    protected $table = 'spp_tagihan';

    protected $fillable = [
        'nis',
        'tahun_ajaran_id',
        'bulan',
        'nominal',
        'status',
    ];

    protected $casts = [
        'nominal' => 'decimal:2',
    ];

    // ─── Relations ───────────────────────────────────────────────────────────

    public function santri()
    {
        return $this->belongsTo(Santri::class, 'nis', 'nis');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function pembayaran()
    {
        return $this->hasMany(SppPembayaran::class, 'nis', 'nis')
            ->where('bulan', $this->bulan)
            ->where('tahun_ajaran_id', $this->tahun_ajaran_id);
    }

    // ─── Accessors ───────────────────────────────────────────────────────────

    public function getNamaBulanAttribute(): string
    {
        $bulan = [
            1 => 'Muharram', 2 => 'Safar', 3 => 'Rabiul Awal',
            4 => 'Rabiul Akhir', 5 => 'Jumadil Awal', 6 => 'Jumadil Akhir',
            7 => 'Rajab', 8 => 'Syaban', 9 => 'Ramadhan',
            10 => 'Syawal', 11 => 'Dzulqaidah', 12 => 'Dzulhijjah',
        ];
        return $bulan[$this->bulan] ?? '-';
    }
}
