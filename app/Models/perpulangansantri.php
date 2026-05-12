<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerpulanganSantri extends Model
{
    protected $table = 'perpulangan_santri';

    protected $fillable = [
        'perpulangan_id',
        'nis',
        'status',
        'keluar_at',
        'kembali_at',
    ];

    protected $casts = [
        'keluar_at'  => 'datetime',
        'kembali_at' => 'datetime',
    ];

    // ─── Status Constants ─────────────────────────────────────────────────────

    const STATUS_MENUNGGU  = 'menunggu';
    const STATUS_SEBAGIAN  = 'sebagian';
    const STATUS_DIIZINKAN = 'diizinkan';
    const STATUS_KELUAR    = 'keluar';
    const STATUS_KEMBALI   = 'kembali';

    // ─── Relasi ───────────────────────────────────────────────────────────────

    public function perpulangan()
    {
        return $this->belongsTo(Perpulangan::class, 'perpulangan_id');
    }

    public function santri()
    {
        return $this->belongsTo(Santri::class, 'nis', 'nis');
    }

    public function approvals()
    {
        return $this->hasMany(PerpulanganApproval::class, 'perpulangan_santri_id');
    }

    // ─── Helpers Cek Approval ─────────────────────────────────────────────────

    public function hasApproval(string $type): bool
    {
        return $this->approvals()->where('approval_type', $type)->exists();
    }

    public function hasMusrif(): bool
    {
        return $this->hasApproval('musrif');
    }

    public function hasSpp(): bool
    {
        return $this->hasApproval('spp');
    }

    public function hasKeamanan(): bool
    {
        return $this->hasApproval('keamanan');
    }

    /**
     * Apakah santri sudah boleh diapprove keamanan
     * (syarat: musrif + spp sudah approve)
     */
    public function bolehKeluar(): bool
    {
        return $this->hasMusrif() && $this->hasSpp();
    }

    // ─── Update Status Otomatis ───────────────────────────────────────────────

    /**
     * Hitung ulang status berdasarkan approval yang ada,
     * lalu simpan ke DB.
     */
    public function recalculateStatus(): void
    {
        $hasMusrif   = $this->hasMusrif();
        $hasSpp      = $this->hasSpp();
        $hasKeamanan = $this->hasKeamanan();

        if ($this->kembali_at !== null) {
            $status = self::STATUS_KEMBALI;
        } elseif ($hasKeamanan) {
            $status = self::STATUS_KELUAR;
        } elseif ($hasMusrif && $hasSpp) {
            $status = self::STATUS_DIIZINKAN;
        } elseif ($hasMusrif || $hasSpp) {
            $status = self::STATUS_SEBAGIAN;
        } else {
            $status = self::STATUS_MENUNGGU;
        }

        $this->update(['status' => $status]);
    }

    // ─── Accessors ────────────────────────────────────────────────────────────

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_MENUNGGU  => 'Menunggu',
            self::STATUS_SEBAGIAN  => 'Sebagian',
            self::STATUS_DIIZINKAN => 'Diizinkan',
            self::STATUS_KELUAR    => 'Keluar',
            self::STATUS_KEMBALI   => 'Kembali',
            default                => ucfirst($this->status),
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_MENUNGGU  => 'bg-gray-100 text-gray-600',
            self::STATUS_SEBAGIAN  => 'bg-yellow-100 text-yellow-800',
            self::STATUS_DIIZINKAN => 'bg-blue-100 text-blue-800',
            self::STATUS_KELUAR    => 'bg-orange-100 text-orange-800',
            self::STATUS_KEMBALI   => 'bg-green-100 text-green-800',
            default                => 'bg-gray-100 text-gray-600',
        };
    }
}