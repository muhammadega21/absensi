<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsenMasuk extends Model
{
    protected $fillable = [
        'jam_keluar',
        'status'
    ];
}
