<?php

// app/Http/Controllers/AssetController.php
namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;

class AssetController extends Controller
{
  public function create()
  {
    return view('asset.create');
  }

  public function store(Request $request)
  {
    $request->validate([
      'outlet' => 'required|string',
      'grouping_asset' => 'required|string',
      'nama_asset' => 'required|string',
      'brand' => 'required|string',
      'model_type' => 'required|string',
      'serial_number' => 'nullable|string',
      'label_fungsi' => 'nullable|string',
      'penempatan' => 'nullable|string',
      'spesifikasi_detail' => 'nullable|string',
    ]);

    Asset::create($request->all());

    return redirect()->back()->with('success', 'Asset berhasil ditambahkan!');
  }
}
