<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    //
    protected $table = 'presensi';
    public $timestamps = false;

    protected $fillable = [
        'user_id'
    ];

    protected $casts = [
        'waktu_datang' => 'datetime',
        'waktu_istirahat' => 'datetime',
        'waktu_setelah_istirahat' => 'datetime',
        'waktu_pulang' => 'datetime',
    ];
}
