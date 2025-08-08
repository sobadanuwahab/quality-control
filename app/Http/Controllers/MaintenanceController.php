<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\MaintenanceProjector;
use App\Models\MaintenanceHvac;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class MaintenanceController extends Controller
{
  private function getTargetAdminId()
  {
    $user = Auth::user();
    return $user->role === 'admin' ? 1 : $user->id;
  }

  // ------------------ FORM ------------------ //
  public function projectorForm()
  {
    return view('projector.form');
  }

  public function hvacForm()
  {
    return view('hvac.form');
  }

  // ------------------ STORE ------------------ //
  public function storeProjector(Request $request)
  {
    $request->validate([
      'tanggal' => 'required|date',
      'deskripsi' => 'required|string|max:100',
      'jenis_perangkat' => 'required|string',
      'type' => 'required|string',
      'studio' => 'required|string',
      'komponen_diganti' => 'nullable|string|max:255',
      'keterangan' => 'nullable|string',
    ]);

    MaintenanceProjector::create([
      'admin_id' => Auth::id(),
      'tanggal' => $request->tanggal,
      'deskripsi' => $request->deskripsi,
      'jenis_perangkat' => $request->jenis_perangkat,
      'type_merk' => $request->type,
      'studio' => $request->studio,
      'komponen_diganti' => $request->komponen_diganti,
      'keterangan' => $request->keterangan,
    ]);

    return back()->with('success', 'Data maintenance berhasil disimpan.');
  }

  public function storeHvac(Request $request)
  {
    $request->validate([
      'tanggal' => 'required|date',
      'teknisi' => 'required|string|max:100',
      'unit_komponen' => 'required|string|max:255',
      'merk_type' => 'required|string|max:255',
      'lokasi_area' => 'required|string|max:255',
      'tindakan' => 'required|string|max:255',
      'keterangan' => 'nullable|string',
    ]);

    $nextServiceDate = Carbon::parse($request->tanggal)->addDays(30);

    MaintenanceHvac::create([
      'admin_id' => Auth::id(),
      'tanggal' => $request->tanggal,
      'teknisi' => $request->teknisi,
      'unit_komponen' => $request->unit_komponen,
      'merk_type' => $request->merk_type,
      'lokasi_area' => $request->lokasi_area,
      'tindakan' => $request->tindakan,
      'keterangan' => $request->keterangan,
      'next_service_date' => $nextServiceDate,
    ]);

    return back()->with('success', 'Data maintenance HVAC berhasil disimpan.');
  }

  // ------------------ EDIT & UPDATE ------------------ //
  public function editProjector($id)
  {
    $data = MaintenanceProjector::findOrFail($id);
    if (Auth::user()->role !== 'admin') abort(403);
    return view('projector.edit', compact('data'));
  }

  public function updateProjector(Request $request, $id)
  {
    $request->validate([
      'tanggal' => 'required|date',
      'deskripsi' => 'required|string|max:100',
      'jenis_perangkat' => 'required|string',
      'type_merk' => 'required|string',
      'studio' => 'required|string',
      'komponen_diganti' => 'nullable|string|max:255',
      'keterangan' => 'nullable|string',
    ]);

    $data = MaintenanceProjector::findOrFail($id);
    if (Auth::user()->role !== 'admin') abort(403);
    $data->update($request->all());

    return redirect()->route('maintenance.projector.laporan')
      ->with('success', 'Data berhasil diperbarui.');
  }

  public function destroyProjector($id)
  {
    $data = MaintenanceProjector::findOrFail($id);
    if (Auth::user()->role !== 'admin') abort(403);
    $data->delete();
    return back()->with('success', 'Data berhasil dihapus.');
  }

  // ------------------ LAPORAN ------------------ //
  public function laporanProjector(Request $request)
  {
    $adminId = $this->getTargetAdminId();

    $query = MaintenanceProjector::where('admin_id', $adminId)
      ->when(
        $request->filled('tanggal_mulai') && $request->filled('tanggal_sampai'),
        fn($q) => $q->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_sampai])
      )
      ->when(
        $request->filled('search'),
        fn($q) => $q->where('studio', $request->search)
      );

    $data = $query->orderBy('tanggal', 'desc')
      ->paginate(5)
      ->withQueryString();

    return view('projector.laporan', compact('data'));
  }

  public function laporanHvac(Request $request)
  {
    $adminId = $this->getTargetAdminId();

    $query = MaintenanceHvac::where('admin_id', $adminId)
      ->when(
        $request->filled('tanggal_mulai') && $request->filled('tanggal_sampai'),
        fn($q) => $q->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_sampai])
      );

    $data = $query->orderBy('tanggal', 'desc')
      ->paginate(5)
      ->withQueryString();

    return view('hvac.laporan', compact('data'));
  }

  // ------------------ ACTION ------------------ //
  public function markAsDone($id)
  {
    $data = MaintenanceHvac::findOrFail($id);
    $data->is_done = true;
    $data->save();
    return back()->with('success', 'Data berhasil ditandai sebagai selesai.');
  }

  // ------------------ EXPORT PDF ------------------ //
  public function exportProjectorPdf(Request $request)
  {
    $adminId = $this->getTargetAdminId();
    $bioskop = Admin::find($adminId)?->nama_bioskop ?? 'Nama Bioskop Tidak Diketahui';

    $query = MaintenanceProjector::where('admin_id', $adminId);

    if ($request->filled('tanggal_mulai') && $request->filled('tanggal_sampai')) {
      $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_sampai]);
    }
    if ($request->filled('search')) {
      $query->where('studio', 'like', '%' . $request->search . '%');
    }

    $data = $query->orderBy('tanggal', 'desc')->get();

    $pdf = Pdf::loadView('projector.laporan-pdf', [
      'data' => $data,
      'namaBioskop' => $bioskop,
      'tanggal_mulai' => $request->tanggal_mulai,
      'tanggal_sampai' => $request->tanggal_sampai,
    ])->setPaper('a4', 'landscape');

    return $pdf->download('laporan_maintenance_projector_' . now()->format('Ymd_His') . '.pdf');
  }

  public function exportHvacPdf(Request $request)
  {
    $adminId = $this->getTargetAdminId();
    $bioskop = Admin::find($adminId)?->nama_bioskop ?? 'Nama Bioskop Tidak Diketahui';

    $query = MaintenanceHvac::where('admin_id', $adminId);
    if ($request->filled('tanggal_mulai') && $request->filled('tanggal_sampai')) {
      $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_sampai]);
    }

    $data = $query->orderBy('tanggal', 'desc')->get();

    $pdf = Pdf::loadView('hvac.laporan-pdf', [
      'data' => $data,
      'namaBioskop' => $bioskop,
      'tanggal_mulai' => $request->tanggal_mulai,
      'tanggal_sampai' => $request->tanggal_sampai,
    ])->setPaper('a4', 'landscape');

    return $pdf->download('laporan_maintenance_hvac_' . now()->format('Ymd_His') . '.pdf');
  }

  // ------------------ SEARCH ------------------ //
  public function search(Request $request)
  {
    $adminId = Auth::id();

    $query = MaintenanceProjector::where('admin_id', $adminId);

    if ($request->search) {
      $query->where('studio', 'like', '%' . $request->search . '%');
    }
    if ($request->tanggal_mulai) {
      $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
    }
    if ($request->tanggal_sampai) {
      $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
    }

    $data = $query->orderBy('tanggal', 'desc')
      ->paginate(5)
      ->withQueryString();

    return view('projector.partial_table', [
      'data' => $data,
      'role' => Auth::user()->role ?? null,
    ]);
  }
}
