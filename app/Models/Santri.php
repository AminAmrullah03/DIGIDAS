<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Santri extends Model
{
    protected $table = 'santri';
    protected $primaryKey = 'nis';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['nis','nama','kelas'];
}
