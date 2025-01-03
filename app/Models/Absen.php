<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    protected $fillable = [
        'tanggal',
        'status',
        'checkin_start',
        'checkin_over',
        'checkout_start',
        'checkout_over',
    ];
}
