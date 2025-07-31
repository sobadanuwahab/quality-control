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

  public function index(Request $request)
  {
    $query = Asset::query();

    // Filter by Grouping Asset
    if ($request->grouping_asset) {
      $query->where('grouping_asset', $request->grouping_asset);
    }

    // Search by Nama Asset
    if ($request->search) {
      $query->where('nama_asset', 'like', '%' . $request->search . '%');
    }

    $assets = $query->paginate(10);

    // Ambil semua opsi Grouping unik untuk dropdown filter
    $groupingOptions = Asset::select('grouping_asset')->distinct()->pluck('grouping_asset');

    return view('asset.index', compact('assets', 'groupingOptions'));
  }
}
