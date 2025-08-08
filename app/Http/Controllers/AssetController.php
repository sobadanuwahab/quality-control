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
    $requestData['admin_id'] = \Illuminate\Support\Facades\Auth::user()->id;

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

    // Kalau user bukan admin, filter berdasarkan admin_id
    if (\Illuminate\Support\Facades\Auth::user()->role !== 'admin') {
      $query->where('admin_id', \Illuminate\Support\Facades\Auth::id());
    }

    // Filter by Grouping Asset
    if ($request->filled('grouping_asset')) {
      $query->where('grouping_asset', $request->grouping_asset);
    }

    // Search by Nama Asset
    if ($request->filled('search')) {
      $query->where('nama_asset', 'like', '%' . $request->search . '%');
    }

    // Manual pagination jika ada filter pencarian atau grouping
    if ($request->filled('search') || $request->filled('grouping_asset')) {
      $filtered = $query->get();
      $perPage = 6;
      $page = $request->get('page', 1);

      $assets = new \Illuminate\Pagination\LengthAwarePaginator(
        $filtered->forPage($page, $perPage)->values(),
        $filtered->count(),
        $perPage,
        $page,
        ['path' => $request->url(), 'query' => $request->query()]
      );
    } else {
      // Default pagination
      $assets = $query->orderByDesc('created_at')->paginate(6);
    }

    // Ambil semua opsi Grouping unik untuk dropdown filter
    $groupingOptions = Asset::select('grouping_asset')->distinct()->pluck('grouping_asset');

    return view('asset.index', compact('assets', 'groupingOptions'));
  }

  public function edit($id)
  {
    if (!\Illuminate\Support\Facades\Auth::check()) {
      abort(403, 'Unauthorized');
    }

    $asset = Asset::findOrFail($id);
    $groupingOptions = Asset::select('grouping_asset')->distinct()->pluck('grouping_asset');

    return view('asset.edit', compact('asset', 'groupingOptions'));
  }

  public function update(Request $request, $id)
  {
    if (!\Illuminate\Support\Facades\Auth::check()) {
      abort(403, 'Unauthorized');
    }

    $request->validate([
      'serial_number' => 'required|string|max:255',
      'nama_asset' => 'required|string|max:255',
      'brand' => 'nullable|string|max:255',
      'model_type' => 'nullable|string|max:255',
      'label_fungsi' => 'nullable|string',
      'spesifikasi_detail' => 'nullable|string',
      'penempatan' => 'nullable|string|max:255',

      'foto' => 'nullable|image|max:2048',
    ]);

    $asset = Asset::findOrFail($id);
    $asset->serial_number = $request->serial_number;
    $asset->nama_asset = $request->nama_asset;
    $asset->brand = $request->brand;
    $asset->model_type = $request->model_type;
    $asset->label_fungsi = $request->label_fungsi;
    $asset->spesifikasi_detail = $request->spesifikasi_detail;
    $asset->penempatan = $request->penempatan;

    if ($request->hasFile('foto')) {
      $asset->foto = $request->file('foto')->store('asset', 'public');
    }

    $asset->save();

    return redirect()->route('asset.index')->with('success', 'Asset berhasil diperbarui');
  }
}
