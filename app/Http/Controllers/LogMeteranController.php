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

    if (!$namaMeteran) {
      return response()->json(['akhir' => null]);
    }

    $lastLog = LogMeteran::where('nama_meteran', $namaMeteran)
      ->where('admin_id', Auth::id()) // agar sesuai user login
      ->orderBy('tanggal', 'desc')
      ->first();

    return response()->json([
      'akhir' => $lastLog ? $lastLog->akhir : null
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
