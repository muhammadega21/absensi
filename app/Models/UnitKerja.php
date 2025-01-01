<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitKerja extends Model
{
    protected $fillable = [
        'name',
        'code'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
