<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Onesheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'tanggal',
        'penerima',
        'pengirim',
        'judul_film',
        'jumlah',
        'keterangan',
    ];
}