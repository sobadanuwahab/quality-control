<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\LogMeteran;
use App\Models\DcpReport;
use App\Models\Onesheet;
use App\Models\MaintenanceProjector;
use App\Models\MaintenanceHvac;
use Carbon\Carbon;


class AdminViewController extends Controller
{
  // 1. Pilih User
  public function selectUser()
  {
    $users = Admin::where('role', 'user')->get();
    return view('admin.select-user', compact('users'));
  }

  // 2. Tampilkan menu setelah user dipilih
  public function showMenu(Request $request)
  {
    $selectedUser = Admin::findOrFail($request->get('user_id'));
    return view('admin.user-menu', compact('selectedUser'));
  }

  // 3. tampilkan data log meteran
  public function showLogMeteran(Request $request, $userId)
  {
    $tanggal_awal = $request->tanggal_awal ?? Carbon::now()->startOfMonth()->toDateString();
    $tanggal_akhir = $request->tanggal_akhir ?? Carbon::now()->endOfMonth()->toDateString();

    // Ambil data log_meteran berdasarkan admin_id, bukan user_id
    $logMeteran = LogMeteran::where('admin_id', $userId)
      ->whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir])
      ->orderBy('tanggal', 'asc')
      ->get();

    // Kelompokkan berdasarkan nama meteran
    $raw_data = $logMeteran->groupBy('nama_meteran');

    // Hitung total kumulatif pemakaian per meteran
    $total_kumulatif = [];
    foreach ($raw_data as $nama => $items) {
      $total_kumulatif[$nama] = $items->sum('pemakaian');
    }

    return view('laporan.index', compact('raw_data', 'total_kumulatif', 'tanggal_awal', 'tanggal_akhir'));
  }

  // 4. Tampilkan data DCP
  public function showDcp($userId)
  {
    $selectedUser = Admin::findOrFail($userId);
    $dcpList = DcpReport::where('admin_id', $userId)->paginate(6);
    if (request()->ajax()) {
      return view('dcp.table', compact('dcpList'))->render();
    }
    return view('admin.data.dcp', compact('selectedUser', 'dcpList'));
  }

  // 5. Tampilkan data Onesheet
  public function showOnesheet($userId)
  {
    $selectedUser = Admin::findOrFail($userId);
    $onesheets = Onesheet::where('admin_id', $userId)->get();
    return view('admin.data.onesheet', compact('selectedUser', 'onesheets'));
  }

  // 6. Tampilkan data Maintenance Projector
  public function showProjector($userId)
  {
    $selectedUser = Admin::findOrFail($userId);
    $data = MaintenanceProjector::where('admin_id', $userId)->get();
    return view('admin.data.projector', compact('selectedUser', 'data'));
  }

  // 7. Tampilkan data HVAC
  public function showHvac($userId)
  {
    $selectedUser = Admin::findOrFail($userId);
    $data = MaintenanceHvac::where('admin_id', $userId)->get();
    return view('admin.data.hvac', compact('selectedUser', 'data'));
  }
}
