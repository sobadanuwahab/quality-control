<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\LogMeteran;
use App\Models\DcpReport;
use App\Models\Onesheet;
use App\Models\MaintenanceProjector;
use App\Models\MaintenanceHvac;


class AdminViewController extends Controller
{
  public function userData(Request $request)
  {
    $selectedUserId = $request->get('admin_id');

    // Ambil semua user untuk dropdown
    $users = Admin::where('role', 'user')->get(); // atau model lain yang sesuai

    $selectedUser = null;
    $logMeteran = collect();
    $dcpReports = collect();
    $onesheetReports = collect();
    $projectorReports = collect();
    $hvacReports = collect();

    if ($selectedUserId) {
      $selectedUser = Admin::find($selectedUserId);

      $logMeteran = LogMeteran::where('admin_id', $selectedUserId)->get();
      $dcpReports = DcpReport::where('admin_id', $selectedUserId)->get();
      $onesheetReports = Onesheet::where('admin_id', $selectedUserId)->get();
      $projectorReports = MaintenanceProjector::where('admin_id', $selectedUserId)->get();
      $hvacReports = MaintenanceHvac::where('admin_id', $selectedUserId)->get();
    }

    return view('admin.data-user', compact(
      'users',
      'selectedUser',
      'logMeteran',
      'dcpReports',
      'onesheetReports',
      'projectorReports',
      'hvacReports'
    ));
  }
}
