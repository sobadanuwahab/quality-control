<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\LogMeteran;
use Illuminate\Support\Facades\Auth;
use App\Models\MaintenanceHvac;
use App\Models\DcpReport;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
  public function index()
  {
    $adminId = Auth::id();
    $today = Carbon::today();

    // Total Kumulatif Meteran
    $jenis_meteran = [
      'Meteran Listrik 1_WBP',
      'Meteran Listrik 1_LWBP',
      'Meteran Listrik Single 1',
      'Meteran Listrik 2_WBP',
      'Meteran Listrik 2_LWBP',
      'Meteran Listrik Single 2',
      'Meteran Air',
      'Meteran Gas'
    ];

    $total_kumulatif = [];

    foreach ($jenis_meteran as $jenis) {
      $latestLog = LogMeteran::where('admin_id', $adminId)
        ->where('nama_meteran', $jenis)
        ->orderByDesc('tanggal')
        ->first();

      $total_kumulatif[$jenis] = [
        'nilai' => $latestLog->akhir ?? 0,
        'tanggal' => $latestLog->tanggal ?? null,
      ];
    }

    $total_kumulatif = collect($total_kumulatif);

    // DCP Report
    $dcpReports = DcpReport::where('admin_id', $adminId)
      ->latest()
      ->take(12)
      ->get();

    foreach ($dcpReports as $report) {
      $report->film_details = is_string($report->film_details)
        ? json_decode($report->film_details, true)
        : $report->film_details;

      $judul = $report->film_details[0]['judulFilm'] ?? null;

      $report->poster_url = $judul
        ? $this->getPosterUrlFromTmdb($judul)
        : asset('images/no-poster.jpg');
    }


    // Notifikasi Maintenance HVAC
    $notifService = MaintenanceHvac::where('admin_id', Auth::id())
      ->whereNotNull('next_service_date')
      ->where('is_done', false)
      ->whereDate('next_service_date', '<=', Carbon::today()->addDays(7)) // H-7
      ->whereDate('next_service_date', '>=', Carbon::today()) // Masih akan datang
      ->get();


    $notifUmum = Notifikasi::whereDate('tanggal_awal', '<=', $today)
      ->whereDate('tanggal_berakhir', '>=', $today)
      ->orderBy('tanggal_berakhir')
      ->get();

    return view('dashboard', compact('total_kumulatif', 'notifService', 'dcpReports', 'notifUmum'));
  }

  public function getPosterUrlFromTmdb($judul)
  {
    $apiKey = config('services.tmdb.api_key');

    try {
      $response = Http::get("https://api.themoviedb.org/3/search/movie", [
        'api_key' => $apiKey,
        'query' => $judul,
      ]);

      $data = $response->json();

      if (!empty($data['results']) && !empty($data['results'][0]['poster_path'])) {
        return 'https://image.tmdb.org/t/p/w500' . $data['results'][0]['poster_path'];
      }
    } catch (\Exception $e) {
      // log error jika perlu
    }

    return asset('images/no-poster.jpg'); // fallback jika tidak ada hasil
  }
}
