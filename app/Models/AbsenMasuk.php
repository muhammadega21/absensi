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
        'status'
    ];

    protected $with = ['absen', 'user'];

    public function absen()
    {
        return $this->belongsTo(Absen::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
