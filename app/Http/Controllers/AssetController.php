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
    $query = Asset::where('admin_id', \Illuminate\Support\Facades\Auth::user()->id);

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
}
