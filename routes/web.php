<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\{
  ProfileController,
  DashboardController,
  LogMeteranController,
  LaporanController,
  MeteranController,
  UserController,
  DcpController,
  OnesheetController,
  MaintenanceController,
  AssetController,
};
use App\Http\Controllers\AdminViewController;

// Arahkan root ke halaman login
Route::get('/', fn() => redirect('/login'));

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
  ->middleware(['auth', 'verified'])->name('dashboard');

// Profile (Laravel Breeze default)
Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Meteran Input
Route::middleware('auth')->group(function () {
  Route::get('/meteran/input', [LogMeteranController::class, 'create'])->name('meteran.input');
  Route::post('/meteran/input', [LogMeteranController::class, 'store'])->name('meteran.store');
});

Route::get('/meteran/{id}/edit', [MeteranController::class, 'edit'])->name('meteran.edit');
Route::delete('/meteran/{id}', [LogMeteranController::class, 'destroy'])->name('meteran.destroy');
Route::put('/log-meteran/{id}', [LogMeteranController::class, 'update'])->name('log_meteran.update');


// Laporan
Route::get('/laporan', [LaporanController::class, 'index'])
  ->middleware('auth')->name('laporan.index');

// AJAX - Ambil data terakhir meteran
Route::get('/meteran/last-akhir', [MeteranController::class, 'getLastAkhir'])
  ->middleware('auth');

// Ubah Password
Route::middleware('auth')->group(function () {
  Route::get('/ubah-password', [UserController::class, 'editPassword'])->name('password.admin.change');
  Route::put('/ubah-password', [UserController::class, 'updatePassword'])->name('password.admin.update');
});

Route::get('/laporan/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.pdf');

Route::get('/lokasi-daerah', function () {
  $lat = request('lat');
  $lon = request('lon');

  if (!$lat || !$lon) {
    return response()->json(['error' => 'Latitude dan longitude diperlukan'], 400);
  }

  $response = Http::withHeaders([
    'User-Agent' => 'MeteranApp/1.0 (admin@yourdomain.com)'
  ])->get('https://nominatim.openstreetmap.org/reverse', [
    'format' => 'json',
    'lat' => $lat,
    'lon' => $lon,
  ]);

  return $response->json();
});

Route::middleware('auth')->group(function () {
  Route::get('/dcp/form', [\App\Http\Controllers\DcpController::class, 'form'])->name('dcp.form');
});

Route::get('/dcp/laporan', [DcpController::class, 'laporan'])->name('dcp.laporan');

Route::get('/dcp/laporan/pdf', [DcpController::class, 'exportPdf'])->name('dcp.laporan.pdf');

Route::resource('dcp', DcpController::class)->except(['show']); // sudah mencakup edit & destroy

// Onesheet Routes
Route::get('/onesheet/form', [OnesheetController::class, 'create'])->name('onesheet.form');
Route::post('/onesheet/store', [OnesheetController::class, 'store'])->name('onesheet.store');
Route::get('/onesheet/laporan', [OnesheetController::class, 'index'])->name('onesheet.laporan');
Route::get('/onesheet/search', [OnesheetController::class, 'search'])->name('onesheet.search');

// Projector & Sound System
Route::get('/maintenance/projector', [MaintenanceController::class, 'projectorForm'])->name('maintenance.projector.form');
Route::post('/maintenance/projector', [MaintenanceController::class, 'storeProjector'])->name('maintenance.projector.store');
Route::get('/maintenance/projector/search', [MaintenanceController::class, 'search'])->name('maintenance.projector.search');

// Maintenance - HVAC
Route::get('/maintenance/hvac', [MaintenanceController::class, 'hvacForm'])->name('maintenance.hvac.form');
Route::post('/maintenance/hvac', [MaintenanceController::class, 'storeHvac'])->name('maintenance.hvac.store');

// Laporan Maintenance
Route::get('/maintenance/projector/laporan', [MaintenanceController::class, 'laporanProjector'])->name('maintenance.projector.laporan');
Route::get('/maintenance/hvac/laporan', [MaintenanceController::class, 'laporanHvac'])->name('maintenance.hvac.laporan');

Route::middleware(['auth'])->prefix('maintenance/projector')->group(function () {
  Route::get('/maintenance/projector/{id}/edit', [MaintenanceController::class, 'editProjector'])->name('maintenance.projector.edit');
  Route::put('/maintenance/projector/{id}', [MaintenanceController::class, 'updateProjector'])->name('maintenance.projector.update');
  Route::delete('/maintenance/projector/{id}', [MaintenanceController::class, 'destroyProjector'])->name('maintenance.projector.destroy');
});

Route::patch('/maintenance/hvac/{id}/done', [MaintenanceController::class, 'markAsDone'])->name('maintenance.hvac.done');

// Export PDF Maintenance
Route::get('/maintenance/projector/laporan/pdf', [MaintenanceController::class, 'exportProjectorPdf'])
  ->name('maintenance.projector.pdf');
Route::get('/maintenance/hvac/laporan/pdf', [MaintenanceController::class, 'exportHvacPdf'])
  ->name('maintenance.hvac.pdf');

// Route Dashboard Admin
Route::middleware('auth:admin')->prefix('admin')->group(function () {
  Route::get('/select-user', [AdminViewController::class, 'selectUser'])->name('admin.selectUser');
  Route::get('/user-menu', [AdminViewController::class, 'showMenu'])->name('admin.userMenu');

  Route::get('/user/{userId}/log-meteran', [AdminViewController::class, 'showLogMeteran'])->name('admin.logMeteran');
  Route::get('/user/{userId}/dcp', [AdminViewController::class, 'showDcp'])->name('admin.dcp');
  Route::get('/user/{userId}/onesheet', [AdminViewController::class, 'showOnesheet'])->name('admin.onesheet');
  Route::get('/user/{userId}/projector', [AdminViewController::class, 'showProjector'])->name('admin.projector');
  Route::get('/user/{userId}/hvac', [AdminViewController::class, 'showHvac'])->name('admin.hvac');
  Route::get('/user/{userId}/asset', [AdminViewController::class, 'showAsset'])->name('admin.asset');
});

Route::prefix('asset')->middleware('auth:admin')->group(function () {
  Route::get('/asset/create', [AssetController::class, 'create'])->name('asset.create');
  Route::post('/store', [AssetController::class, 'store'])->name('asset.store');
  Route::get('/', [AssetController::class, 'index'])->name('asset.index');
  Route::delete('/{id}', [AssetController::class, 'destroy'])->name('asset.destroy');
});

Route::middleware(['auth'])->group(function () {
  Route::get('/asset/{id}/edit', [AssetController::class, 'edit'])->name('asset.edit');
  Route::put('/asset/{id}', [AssetController::class, 'update'])->name('asset.update');
});

require __DIR__ . '/auth.php';
