<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsenMasuk extends Model
{
    protected $fillable = [
        'absen_id',
        'user_id',
        'checkin',
        'keterangan',
    ];
}
