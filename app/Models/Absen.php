<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    protected $fillable = [
        'tanggal',
        'user_id',
        'absen_masuk_id',
        'absen_keluar_id'
    ];
}
