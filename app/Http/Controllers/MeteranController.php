<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogMeteran;
use Illuminate\Support\Facades\Auth;

class MeteranController extends Controller
{
    public function getLastAkhir(Request $request)
    {
        $nama = $request->query('nama_meteran');
        $adminId = Auth::id();

        $last = LogMeteran::where('admin_id', $adminId)
            ->where('nama_meteran', $nama)
            ->orderByDesc('tanggal')
            ->value('akhir');

        return response()->json(['akhir' => $last ?? 0]);
    }
}
