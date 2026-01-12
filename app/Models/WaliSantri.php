<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class WaliSantri extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'wali_santri';

    protected $fillable = [
        'nis',
        'nama_wali',
        'no_hp',
        'password',
        'hubungan',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // Relasi ke santri
    public function santri()
    {
        return $this->belongsTo(Santri::class, 'nis', 'nis');
    }
}
