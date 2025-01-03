<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsenPulang extends Model
{
    protected $fillable = [
        'absen_id',
        'user_id',
        'checkout',
        'keterangan'
    ];
}
