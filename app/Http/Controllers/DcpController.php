<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\DcpReport;
use App\Models\Admin;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class DcpController extends Controller
{
  // ✅ Form input DCP
  public function form()
  {
    $locations = ['Library', 'IMAX', 'Studio 1', 'Studio 2', 'Studio 3', 'Studio 4', 'Studio 5', 'Studio 6', 'Studio 1 Premiere', 'Studio 2 Premiere']; // Tambah lokasi sesuai kebutuhan
    return view('dcp.form', compact('locations'));
  }

  // ✅ Simpan data baru
  public function store(Request $request)
  {
    $request->validate([
      'tanggal_penerimaan' => 'required|date',
      'nama_penerima' => 'required|string|max:100',
      'pengirim' => 'required|string|max:100',
      'film_details' => 'required|array|min:1',
      'film_details.*.judulFilm' => 'required|string|max:255',
      'film_details.*.sound' => 'nullable|string|max:100',
      'film_details.*.statusKdm' => 'required|string',
      'film_details.*.formatFilm' => 'nullable|string',
      'film_details.*.keterangan' => 'nullable|string',
      'film_details.*.lokasiPenyimpanan' => 'nullable|array',
      'film_details.*.lokasiPenyimpanan.*' => 'string',
    ]);

    DcpReport::create([
      'id' => Str::uuid(),
      'admin_id' => Auth::id(),
      'tanggal_penerimaan' => $request->tanggal_penerimaan,
      'nama_penerima' => $request->nama_penerima,
      'pengirim' => $request->pengirim,
      'film_details' => json_encode($request->film_details),
    ]);

    return redirect()->back()->with('success', 'Data DCP berhasil disimpan.');
  }

  // ✅ Tampilkan laporan
  public function laporan(Request $request)
  {
    $admin = Auth::user();

    // Admin bisa lihat semua data, selain admin hanya lihat miliknya sendiri
    $dcpList = $admin->role === 'admin'
      ? DcpReport::orderByDesc('tanggal_penerimaan')->get()
      : DcpReport::where('admin_id', $admin->id)->orderByDesc('tanggal_penerimaan')->get();

    // Decode semua film_details
    foreach ($dcpList as $item) {
      $item->film_details = is_string($item->film_details)
        ? json_decode($item->film_details, true)
        : $item->film_details;
    }

    // Filter jika ada keyword pencarian
    if ($request->filled('search')) {
      $search = strtolower($request->search);

      $dcpList = $dcpList->filter(function ($item) use ($search) {
        $details = is_string($item->film_details)
          ? json_decode($item->film_details, true)
          : $item->film_details;

        $judulMatch = false;
        foreach ($details as $film) {
          if (isset($film['judulFilm']) && stripos($film['judulFilm'], $search) !== false) {
            $judulMatch = true;
            break;
          }
        }

        return stripos($item->nama_penerima, $search) !== false ||
          stripos($item->pengirim, $search) !== false ||
          $judulMatch;
      });
    }

    if ($request->ajax()) {
      return view('dcp.table', compact('dcpList'));
    }

    return view('dcp.laporan', compact('dcpList'));
  }

  // ✅ Export PDF
  public function exportPdf()
  {
    $adminId = Auth::id();
    $bioskop = Admin::find($adminId)?->nama_bioskop ?? 'Nama Bioskop Tidak Diketahui';

    $dcpList = DcpReport::where('admin_id', $adminId)
      ->orderByDesc('tanggal_penerimaan')
      ->get();

    $pdf = Pdf::loadView('dcp.export-pdf', [
      'dcpList' => $dcpList,
      'namaBioskop' => $bioskop,
      'tanggal' => Carbon::now()->translatedFormat('d F Y'),
    ])->setPaper('A4', 'landscape');

    return $pdf->download('laporan_dcp_' . now()->format('Ymd_His') . '.pdf');
  }

  // ✅ Form edit
  public function edit($id)
  {
    if (Auth::user()->role !== 'admin') {
      abort(403, 'Akses ditolak.');
    }

    $dcp = DcpReport::findOrFail($id);

    $dcp->film_details = is_string($dcp->film_details)
      ? json_decode($dcp->film_details, true)
      : $dcp->film_details;

    $locations = ['Library', 'IMAX', 'Studio 1', 'Studio 2', 'Studio 3', 'Studio 4', 'Studio 5', 'Studio 6', 'Studio 1 Premiere', 'Studio 2 Premiere'];
    return view('dcp.edit', compact('dcp', 'locations'));
  }

  public function update(Request $request, $id)
  {
    if (Auth::user()->role !== 'admin') {
      abort(403, 'Akses ditolak.');
    }

    $request->validate([
      'tanggal_penerimaan' => 'required|date',
      'nama_penerima' => 'required|string|max:255',
      'pengirim' => 'required|string|max:255',
      'film_details' => 'required|array|min:1',
    ]);

    $dcp = DcpReport::findOrFail($id);

    $dcp->tanggal_penerimaan = \Carbon\Carbon::parse($request->tanggal_penerimaan)->format('Y-m-d');
    $dcp->nama_penerima = $request->nama_penerima;
    $dcp->pengirim = $request->pengirim;
    $dcp->film_details = json_encode($request->film_details);
    $dcp->save();

    return redirect()->route('dcp.laporan')->with('success', 'Data berhasil diperbarui.');
  }

  public function destroy($id)
  {
    if (\Illuminate\Support\Facades\Auth::user()->role !== 'admin') {
      abort(403, 'Akses ditolak.');
    }

    $dcp = DcpReport::findOrFail($id);
    $dcp->delete();

    return redirect()->route('dcp.laporan')->with('success', 'Data berhasil dihapus.');
  }

  // ✅ Redirect jika ada akses ke /dcp (index)
  public function index()
  {
    return redirect()->route('dcp.laporan');
  }
}
