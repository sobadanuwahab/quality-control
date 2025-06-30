<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceHvac extends Model
{
    use HasFactory;

    protected $table = 'maintenance_hvac';

    protected $fillable = [
        'admin_id',
        'tanggal',
        'next_service_date',
        'teknisi',
        'unit_komponen',
        'merk_type',
        'lokasi_area',
        'tindakan',
        'keterangan',
    ];

    // Jika ingin relasi ke admin:
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
