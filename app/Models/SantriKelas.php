<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SantriKelas extends Model
{
    protected $table = 'santri_kelas';

    protected $fillable = [
        'nis',
        'tahun_ajaran_id',
        'kelas',
        'diubah_oleh',
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
}
