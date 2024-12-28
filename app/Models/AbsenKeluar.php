<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsenKeluar extends Model
{
    protected $fillable = [
        'jam_masuk',
        'status'
    ];
}
