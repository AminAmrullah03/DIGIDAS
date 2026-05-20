<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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

        if (empty($rows)) {
            return 0;
        }

        // insertOrIgnore agar aman jika dipanggil dua kali
        return PerpulanganSantri::insertOrIgnore($rows);
    }

    public function approvalStartsAt(): Carbon
    {
        return $this->tanggal_mulai->copy()->startOfDay();
    }

    public function approvalEndsAt(): Carbon
    {
        return $this->tanggal_mulai->copy()->endOfDay();
    }

    public function returnStartsAt(): Carbon
    {
        return $this->batas_kembali->copy()->startOfDay();
    }

    public function returnEndsAt(): Carbon
    {
        return $this->batas_kembali->copy()->endOfDay();
    }

    public function isApprovalDay(?Carbon $time = null): bool
    {
        $time ??= now();

        return $time->betweenIncluded($this->approvalStartsAt(), $this->approvalEndsAt());
    }

    public function isBeforeApprovalDay(?Carbon $time = null): bool
    {
        $time ??= now();

        return $time->lt($this->approvalStartsAt());
    }

    public function isAfterApprovalDay(?Carbon $time = null): bool
    {
        $time ??= now();

        return $time->gt($this->approvalEndsAt());
    }

    public function isReturnOpen(?Carbon $time = null): bool
    {
        $time ??= now();

        return $time->greaterThanOrEqualTo($this->returnStartsAt());
    }

    public function isReturnDay(?Carbon $time = null): bool
    {
        $time ??= now();

        return $time->betweenIncluded($this->returnStartsAt(), $this->returnEndsAt());
    }

    public function isBeforeReturnDay(?Carbon $time = null): bool
    {
        $time ??= now();

        return $time->lt($this->returnStartsAt());
    }

    public function isLateReturn(?Carbon $time = null): bool
    {
        $time ??= now();

        return $time->gt($this->returnEndsAt());
    }

    public function sinkronkanStatusOtomatis(?Carbon $time = null): array
    {
        $time ??= now();
        $kabur = 0;
        $terlambatKembali = 0;

        if ($this->isAfterApprovalDay($time)) {
            $kabur = $this->perpulanganSantri()
                ->whereIn('status', [
                    PerpulanganSantri::STATUS_MENUNGGU,
                    PerpulanganSantri::STATUS_SEBAGIAN,
                    PerpulanganSantri::STATUS_DIIZINKAN,
                ])
                ->update(['status' => PerpulanganSantri::STATUS_KABUR]);
        }

        if ($this->isLateReturn($time)) {
            $terlambatKembali = $this->perpulanganSantri()
                ->whereNull('kembali_at')
                ->whereNotIn('status', [
                    PerpulanganSantri::STATUS_KEMBALI,
                    PerpulanganSantri::STATUS_TERLAMBAT_KEMBALI,
                ])
                ->update(['status' => PerpulanganSantri::STATUS_TERLAMBAT_KEMBALI]);
        }

        return [
            'kabur' => $kabur,
            'terlambat_kembali' => $terlambatKembali,
        ];
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
