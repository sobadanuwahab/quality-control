<?php

// app/Models/Asset.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
  protected $fillable = [
    'outlet',
    'grouping_asset',
    'nama_asset',
    'brand',
    'model_type',
    'serial_number',
    'label_fungsi',
    'penempatan',
    'spesifikasi_detail',
  ];
}
