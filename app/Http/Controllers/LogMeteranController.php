<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogMeteran;
use Illuminate\Support\Facades\Auth;

class LogMeteranController extends Controller
{
  public function lastAkhir(Request $request)
  {
    $namaMeteran = $request->query('nama_meteran');

    $data = \App\Models\LogMeteran::where('nama_meteran', $namaMeteran)
      ->where('admin_id', Auth::id())
      ->orderByDesc('tanggal')
      ->first();

    return response()->json([
      'akhir' => $data ? $data->akhir : null
    ]);
  }

  public function create()
  {
    return view('meteran.input');
  }

  public function store(Request $request)
  {
    $request->validate([
      'tanggal' => 'required|date',
      'nama_meteran' => 'required|string',
      'awal' => 'required|numeric',
      'akhir' => 'required|numeric',
    ]);

    $awal = floatval(str_replace(',', '.', $request->awal));
    $akhir = floatval(str_replace(',', '.', $request->akhir));
    $pemakaian = $akhir - $awal;

    LogMeteran::create([
      'tanggal' => $request->tanggal,
      'nama_meteran' => $request->nama_meteran,
      'awal' => $awal,
      'akhir' => $akhir,
      'pemakaian' => $pemakaian,
      'admin_id' => Auth::id(),
    ]);

    return redirect()->route('meteran.input')->with('success', 'Data berhasil disimpan!');
  }
}
