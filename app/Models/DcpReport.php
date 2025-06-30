<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class DcpReport extends Model
{
    use HasUuids;

    protected $table = 'dcp_reports';

    protected $fillable = [
        'id',
        'admin_id',
        'tanggal_penerimaan',
        'nama_penerima',
        'pengirim',
        'film_details',
    ];

    protected $casts = [
        'film_details' => 'array',
        'tanggal_penerimaan' => 'date',
    ];
}
