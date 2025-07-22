<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogMeteran;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Admin;

class LaporanController extends Controller
{
  public function index(Request $request)
  {
    $user = Auth::user();
    $isAdmin = $user->role === 'admin';
    $adminId = $user->id;

    $tanggal_awal = $request->tanggal_awal;
    $tanggal_akhir = $request->tanggal_akhir;

    $query = LogMeteran::query();

    if ($tanggal_awal && $tanggal_akhir) {
      $query->whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir]);

      // ❗ Hanya filter admin_id jika BUKAN ADMIN
      if (!$isAdmin) {
        $query->where('admin_id', $adminId);
      }

      $raw_data = $query->orderBy('nama_meteran')->orderBy('tanggal')->get()->groupBy('nama_meteran');

      // Salin ulang query untuk total
      $total_query = LogMeteran::query()
        ->whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir]);

      if (!$isAdmin) {
        $total_query->where('admin_id', $adminId);
      }

      $total_kumulatif = $total_query
        ->selectRaw('nama_meteran, SUM(pemakaian) as total')
        ->groupBy('nama_meteran')
        ->pluck('total', 'nama_meteran');
    } else {
      $raw_data = [];
      $total_kumulatif = [];
    }

    return view('laporan.index', compact('raw_data', 'total_kumulatif', 'tanggal_awal', 'tanggal_akhir'));
  }

  public function exportPdf(Request $request)
  {
    $user = Auth::user();
    $isAdmin = $user->role === 'admin';
    $adminId = $user->id;

    $admin = Admin::find($adminId);
    $namaBioskop = $admin->nama_bioskop ?? 'Bioskop';

    $tanggal_awal = $request->tanggal_awal;
    $tanggal_akhir = $request->tanggal_akhir;

    $data_log = collect();
    $total_kumulatif = collect();

    if ($tanggal_awal && $tanggal_akhir) {
      $query = LogMeteran::whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir]);

      if (!$isAdmin) {
        $query->where('admin_id', $adminId);
      }

      $data_log = $query->orderBy('nama_meteran')->orderBy('tanggal')->get()->groupBy('nama_meteran');

      $total_query = LogMeteran::whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir]);

      if (!$isAdmin) {
        $total_query->where('admin_id', $adminId);
      }

      $total_kumulatif = $total_query
        ->selectRaw('nama_meteran, SUM(pemakaian) as total')
        ->groupBy('nama_meteran')
        ->pluck('total', 'nama_meteran');
    }

    $pdf = PDF::loadView('laporan.pdf', [
      'raw_data' => $data_log,
      'total_kumulatif' => $total_kumulatif,
      'nama_bioskop' => $namaBioskop,
      'tanggal_awal' => $tanggal_awal,
      'tanggal_akhir' => $tanggal_akhir,
    ])->setPaper('A4', 'portrait');

    return $pdf->stream('laporan-meteran.pdf');
  }
}
