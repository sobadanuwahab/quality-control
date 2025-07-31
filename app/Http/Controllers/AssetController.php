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
      'grouping_asset' => 'required|string',
      'nama_asset' => 'required|string',
      'brand' => 'required|string',
      'model_type' => 'required|string',
      'serial_number' => 'nullable|string',
      'label_fungsi' => 'nullable|string',
      'penempatan' => 'nullable|string',
      'spesifikasi_detail' => 'nullable|string',
      'foto' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
    ]);

    $requestData = $request->all();

    if ($request->hasFile('foto')) {
      $fotoPath = $request->file('foto')->store('assets', 'public');
      $requestData['foto'] = $fotoPath;
    }

    Asset::create($requestData);

    return redirect()->back()->with('success', 'Asset berhasil ditambahkan!');
  }

  public function index()
  {
    $assets = \App\Models\Asset::latest()->paginate(8);
    return view('asset.index', compact('assets'));
  }
}
