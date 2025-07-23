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
  public function index(Request $request)
  {
    $users = Admin::where('role', 'user')->get();

    $selectedUser = null;
    $logMeteran = collect();
    $dcpReports = collect();
    $onesheetReports = collect();
    $projectorReports = collect();
    $hvacReports = collect();

    if ($request->has('admin_id')) {
      $selectedUser = Admin::find($request->input('admin_id'))
        ->where('role', 'user')
        ->first();
      if ($selectedUser) {
        $logMeteran = LogMeteran::where('admin_id', $selectedUser->id)->get();
        $dcpReports = DcpReport::where('admin_id', $selectedUser->id)->get();
        $onesheetReports = Onesheet::where('admin_id', $selectedUser->id)->get();
        $projectorReports = MaintenanceProjector::where('admin_id', $selectedUser->id)->get();
        $hvacReports = MaintenanceHvac::where('admin_id', $selectedUser->id)->get();
      }
    }

    return view('admin.data-user', compact('users', 'selectedUser', 'logMeteran', 'dcpReports', 'onesheetReports', 'projectorReports', 'hvacReports'));
  }
}
