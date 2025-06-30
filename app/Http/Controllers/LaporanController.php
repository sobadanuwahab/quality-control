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
        $adminId = Auth::id();
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $raw_data = [];
        $total_kumulatif = [];

        if ($tanggal_awal && $tanggal_akhir) {
            $raw_data = LogMeteran::where('admin_id', $adminId)
                ->whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir])
                ->orderBy('nama_meteran')
                ->orderBy('tanggal')
                ->get()
                ->groupBy('nama_meteran'); // ⬅️ hasilnya akan dikelompokkan per jenis meteran


            $total_kumulatif = LogMeteran::where('admin_id', $adminId)
                ->whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir])
                ->selectRaw('nama_meteran, SUM(pemakaian) as total')
                ->groupBy('nama_meteran')
                ->pluck('total', 'nama_meteran');
        }

        return view('laporan.index', [
            'raw_data' => $raw_data,
            'total_kumulatif' => $total_kumulatif,
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]);
    }

    public function exportPdf(Request $request)
    {
        $adminId = Auth::id();
        $admin = Admin::find($adminId);
        $namaBioskop = $admin->nama_bioskop ?? 'Bioskop';

        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $data_log = collect();
        $total_kumulatif = collect();

        if ($tanggal_awal && $tanggal_akhir) {
            $data_log = LogMeteran::where('admin_id', $adminId)
                ->whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir])
                ->orderBy('nama_meteran')
                ->orderBy('tanggal')
                ->get()
                ->groupBy('nama_meteran');

            $total_kumulatif = LogMeteran::where('admin_id', $adminId)
                ->whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir])
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
