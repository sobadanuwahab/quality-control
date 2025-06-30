<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogMeteran extends Model
{
    protected $table = 'log_meteran'; // ganti dari 'meteran' ke 'log_meteran'

    protected $fillable = [
        'admin_id',
        'tanggal',
        'nama_meteran',
        'awal',
        'akhir',
        'pemakaian',
    ];

    public $timestamps = false;
}

