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
