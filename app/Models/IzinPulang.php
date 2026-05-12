<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IzinPulang extends Model
{
    use HasFactory;

    public const STATUS_BELUM_KEMBALI = 'Belum Kembali';
    public const STATUS_SUDAH_KEMBALI = 'Sudah Kembali';
    public const STATUS_TERLAMBAT = 'Terlambat';
    public const STATUS_KABUR = 'Kabur';

    protected $table = 'izin_pulang';

    protected $fillable = [
        'nis',
        'keperluan',
        'durasi_hari',
        'waktu_pulang',
        'batas_waktu_kembali',
        'waktu_kembali',
        'terlambat_menit',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'durasi_hari' => 'integer',
        'waktu_pulang' => 'datetime',
        'batas_waktu_kembali' => 'datetime',
        'waktu_kembali' => 'datetime',
        'terlambat_menit' => 'integer',
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class, 'nis', 'nis');
    }

    public function getDurasiLabelAttribute(): string
    {
        return $this->durasi_hari.' hari';
    }

    public function getKeterlambatanMenitAttribute(): int
    {
        if ($this->terlambat_menit !== null) {
            return (int) $this->terlambat_menit;
        }

        if (! $this->batas_waktu_kembali) {
            return 0;
        }

        $referenceTime = $this->waktu_kembali ?: now('Asia/Jakarta');

        if ($referenceTime->lessThanOrEqualTo($this->batas_waktu_kembali)) {
            return 0;
        }

        return (int) ceil($this->batas_waktu_kembali->diffInSeconds($referenceTime) / 60);
    }

    public function getKetepatanLabelAttribute(): string
    {
        if ($this->status === self::STATUS_KABUR) {
            return 'Kabur';
        }

        $lateMinutes = $this->keterlambatan_menit;

        if ($this->status === self::STATUS_BELUM_KEMBALI) {
            return $lateMinutes > 0
                ? 'Belum kembali, terlambat '.self::formatMinutes($lateMinutes)
                : 'Belum kembali';
        }

        return $lateMinutes > 0
            ? 'Terlambat '.self::formatMinutes($lateMinutes)
            : 'Tepat waktu';
    }

    public static function formatMinutes(int $minutes): string
    {
        if ($minutes <= 0) {
            return '0 menit';
        }

        $days = intdiv($minutes, 1440);
        $minutes %= 1440;
        $hours = intdiv($minutes, 60);
        $minutes %= 60;

        $parts = [];
        if ($days > 0) {
            $parts[] = $days.' hari';
        }
        if ($hours > 0) {
            $parts[] = $hours.' jam';
        }
        if ($minutes > 0) {
            $parts[] = $minutes.' menit';
        }

        return implode(' ', $parts);
    }
}
