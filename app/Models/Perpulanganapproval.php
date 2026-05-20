<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerpulanganApproval extends Model
{
    protected $table = 'perpulangan_approvals';

    protected $fillable = [
        'perpulangan_santri_id',
        'approval_type',
        'approved_by',
        'approved_at',
        'catatan',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function perpulanganSantri()
    {
        return $this->belongsTo(PerpulanganSantri::class, 'perpulangan_santri_id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
