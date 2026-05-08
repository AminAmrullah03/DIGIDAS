<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    protected $table = 'tahun_ajaran';

    protected $fillable = [
        'nama',
        'tahun_hijriah',
        'tahun_masehi',
        'tanggal_mulai',
        'tanggal_selesai',
        'nominal_spp',
        'status',
    ];

    protected $casts = [
        'tanggal_mulai'   => 'date',
        'tanggal_selesai' => 'date',
        'nominal_spp'     => 'decimal:2',
    ];

    // ─── Scopes ──────────────────────────────────────────────────────────────

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    // ─── Helpers ─────────────────────────────────────────────────────────────

    /**
     * Ambil tahun ajaran yang sedang aktif.
     * Kembalikan null jika tidak ada.
     */
    public static function getAktif(): ?self
    {
        return static::where('status', 'aktif')->first();
    }

    public function isAktif(): bool
    {
        return $this->status === 'aktif';
    }

    // ─── Relations ───────────────────────────────────────────────────────────

    public function santriKelas()
    {
        return $this->hasMany(SantriKelas::class);
    }

    public function sppTagihan()
    {
        return $this->hasMany(SppTagihan::class);
    }

    public function sppPembayaran()
    {
        return $this->hasMany(SppPembayaran::class);
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }
}
