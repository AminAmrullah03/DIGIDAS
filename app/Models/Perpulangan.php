<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perpulangan extends Model
{
    use HasFactory;

    protected $table = 'perpulangan';

    protected $fillable = [
        'nama_event',
        'tanggal_mulai',
        'batas_kembali',
        'keterangan',
        'status',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'batas_kembali' => 'date',
    ];

    // ─── Constants ────────────────────────────────────────────────────────────

    const STATUS_AKTIF   = 'aktif';
    const STATUS_SELESAI = 'selesai';

    // ─── Relasi ───────────────────────────────────────────────────────────────

    public function perpulanganSantri()
    {
        return $this->hasMany(PerpulanganSantri::class, 'perpulangan_id');
    }

    // ─── Scopes ───────────────────────────────────────────────────────────────

    public function scopeAktif($query)
    {
        return $query->where('status', self::STATUS_AKTIF);
    }

    // ─── Business Logic ───────────────────────────────────────────────────────

    /**
     * Daftarkan semua santri aktif ke event perpulangan ini.
     * Dipanggil saat admin membuat event baru.
     */
    public function daftarkanSemuaSantri(): int
    {
        $santriAktif = Santri::where('status', 'aktif')->pluck('nis');

        $rows = $santriAktif->map(fn ($nis) => [
            'perpulangan_id' => $this->id,
            'nis'            => $nis,
            'status'         => PerpulanganSantri::STATUS_MENUNGGU,
            'created_at'     => now(),
            'updated_at'     => now(),
        ])->toArray();

        // insertOrIgnore agar aman jika dipanggil dua kali
        PerpulanganSantri::insertOrIgnore($rows);

        return count($rows);
    }

    // ─── Accessors ────────────────────────────────────────────────────────────

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_AKTIF   => 'Aktif',
            self::STATUS_SELESAI => 'Selesai',
            default              => ucfirst($this->status),
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_AKTIF   => 'bg-green-100 text-green-800',
            self::STATUS_SELESAI => 'bg-gray-100 text-gray-600',
            default              => 'bg-blue-100 text-blue-800',
        };
    }

    public function getIsBerlakuAttribute(): bool
    {
        return $this->status === self::STATUS_AKTIF
            && $this->batas_kembali->greaterThanOrEqualTo(now()->startOfDay());
    }
}