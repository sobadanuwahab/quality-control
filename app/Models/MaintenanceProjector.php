<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaintenanceProjector extends Model
{
    use HasFactory;

    protected $table = 'maintenance_projectors';

    protected $fillable = [
        'admin_id',
        'tanggal',
        'deskripsi',
        'jenis_perangkat',
        'type_merk',
        'studio',
        'komponen_diganti',
        'keterangan',
    ];

    /**
     * Relasi ke model Admin
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
