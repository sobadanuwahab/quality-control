<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogMeteran;
use Illuminate\Support\Facades\Auth;

class LogMeteranController extends Controller
{
  public function create()
  {
    return view('meteran.input');
  }

  public function edit($id)
  {
    $log = LogMeteran::findOrFail($id);
    return view('log_meteran.edit', compact('log'));
  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'tanggal' => 'required|date',
      'nama_meteran' => 'required|string',
      'awal' => 'required|numeric',
      'akhir' => 'required|numeric',
    ]);

    $log = LogMeteran::findOrFail($id);

    // Hitung ulang pemakaian
    $awal = floatval(str_replace(',', '.', $request->awal));
    $akhir = floatval(str_replace(',', '.', $request->akhir));
    $pemakaian = $akhir - $awal;

    $log->update([
      'tanggal' => $request->tanggal,
      'nama_meteran' => $request->nama_meteran,
      'awal' => $awal,
      'akhir' => $akhir,
      'pemakaian' => $pemakaian,
    ]);

    return redirect()->route('laporan.index')->with('success', 'Data berhasil diupdate');
  }

  public function destroy($id)
  {
    $log = LogMeteran::findOrFail($id);
    $log->delete();

    return back()->with('success', 'Data berhasil dihapus');
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
