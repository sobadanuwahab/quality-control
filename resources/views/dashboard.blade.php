@extends('layouts.custom')

@php use Illuminate\Support\Facades\Auth; @endphp

@section('content')

    @if ($notifService->count())
        <div class="alert alert-warning">
            <strong>⚠️ Perhatian:</strong> Sudah memasuki waktu service unit HVAC berikut:
            <ul class="mt-2 mb-0">
                @foreach ($notifService as $item)
                    @php
                        $today = \Carbon\Carbon::now()->startOfDay();
                        $serviceDate = \Carbon\Carbon::parse($item->next_service_date)->startOfDay();
                        $selisih = $today->diffInDays($serviceDate, false);
                    @endphp
                    <li>
                        <strong>{{ $item->unit_komponen }} All Area</strong>
                        (Jadwal Service: {{ $serviceDate->format('d M Y') }} —
                        @if ($selisih === 0)
                            Hari ini
                        @elseif($selisih > 0)
                            H-{{ $selisih }}
                        @else
                            Terlewat {{ abs($selisih) }} hari
                        @endif)
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container-fluid px-4">
        <h2 class="fw-bold display-6 text-center mb-4"
            style="font-size: 60px; color: rgb(216, 194, 68); letter-spacing: 1px; font-family: 'Roboto Slab', sans-serif; text-shadow: 2px 3px 2px rgba(0, 0, 0, 0.5);">
            {{ Auth::user()->nama_bioskop ?? 'Dashboard' }}
        </h2>
        <h4 class="fw-bold text-primary mb-3">
            <i class="bi bi-speedometer2 me-1"></i> Meteran Reports Update
        </h4>

        {{-- Carousel Log Meteran --}}
        <div id="carouselMeteran" class="carousel slide" data-bs-ride="carousel" data-bs-pause="false" data-bs-interval="4500">

            @php
                $ikon = function ($jenis) {
                    return match (true) {
                        str_contains(strtolower($jenis), 'air') => 'bi-droplet-fill',
                        str_contains(strtolower($jenis), 'gas') => 'bi-fire',
                        str_contains(strtolower($jenis), 'elpiji') => 'bi-fuel-pump-fill',
                        default => 'bi-lightning-fill',
                    };
                };

                $warna = function ($jenis) {
                    return match (true) {
                        str_contains(strtolower($jenis), 'air') => 'border-info text-info',
                        str_contains(strtolower($jenis), 'gas') => 'border-warning text-warning',
                        str_contains(strtolower($jenis), 'elpiji') => 'border-danger text-danger',
                        default => 'border-success text-success',
                    };
                };

                $satuan = function ($jenis) {
                    return str_contains(strtolower($jenis), 'gas') ||
                        str_contains(strtolower($jenis), 'air') ||
                        str_contains(strtolower($jenis), 'elpiji')
                        ? 'm³'
                        : 'kWh';
                };
            @endphp

            <div class="carousel-inner">

                @php $chunks = $total_kumulatif->chunk(4); @endphp
                @foreach ($chunks as $chunkIndex => $chunk)
                    <div class="carousel-item {{ $chunkIndex === 0 ? 'active' : '' }}">
                        <div class="row g-5 px-3 justify-content-center">
                            @foreach ($chunk as $nama_meteran => $data)
                                <div class="col-md-4 mx-2 ">
                                    <div class="card card-modern border border-5 {{ $warna($nama_meteran) }}">
                                        <div class="card-body d-flex align-items-center">
                                            <div class="me-3">
                                                <i class="bi {{ $ikon($nama_meteran) }} display-3"
                                                    style="text-shadow: 0 4px 2px rgba(0, 0, 0, 0.3);"></i>
                                            </div>
                                            <div>
                                                <h6 class="card-subtitle mb-1 fw-bold text-muted">{{ $nama_meteran }}</h6>
                                                <h5 class="card-title mb-0 fw-bold">
                                                    {{ number_format($data['nilai'], 2) }}
                                                    <small class="text-muted">{{ $satuan($nama_meteran) }}</small>
                                                </h5>
                                                @if ($data['tanggal'])
                                                    <small class="fw-bold" style="color: #00d1b2">Update:
                                                        {{ \Carbon\Carbon::parse($data['tanggal'])->format('d M Y') }}</small>
                                                @else
                                                    <small class="fw-bold text-danger">Belum ada data</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

            </div>
        </div>

        {{-- Carousel DCP --}}
        @php
            $chunks = $dcpReports->chunk(3);
        @endphp

        <div id="carouselDcp" class="carousel slide mt-5" data-bs-ride="carousel" data-bs-pause="false"
            data-bs-interval="8000">
            <h4 class="fw-bold text-primary mb-3">
                <i class="bi bi-collection-play me-1"></i> DCP Reports Update
            </h4>

            <div class="carousel-inner">
                @foreach ($chunks as $index => $group)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <div class="row justify-content-center">
                            @foreach ($group as $item)
                                <div class="col-md-3 mb-3">
                                    <div class="card border h-100 card-modern">
                                        <div class="card-body">
                                            <h6 class="card-title text-primary">
                                                <i class="bi bi-film me-1"></i>
                                                {{ $item->film_details[0]['judulFilm'] ?? '-' }}
                                            </h6>
                                            <p class="mb-1">Penerima: <strong>{{ $item->nama_penerima }}</strong></p>
                                            <p class="mb-0">Tanggal:
                                                <strong>{{ \Carbon\Carbon::parse($item->tanggal_penerimaan)->format('d M Y') }}</strong>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            {{-- Tambah card kosong jika kurang dari 3 --}}
                            @for ($i = 0; $i < 2 - $group->count(); $i++)
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100 border-0 bg-transparent"></div>
                                </div>
                            @endfor
                        </div>
                    </div>
                @endforeach
            </div>
        </div>


        {{-- Notifikasi Tambahan --}}
        @if ($notifUmum->count())
            <div class="mt-5">
                <h4 class="fw-bold text-primary mb-3">
                    <i class="bi bi-bell-fill me-1"></i> Notifikasi Terbaru
                </h4>

                <div class="row g-3">
                    @foreach ($notifUmum as $notif)
                        @php
                            // Mapping warna berdasarkan tipe
                            $borderClass = match (strtolower($notif->tipe)) {
                                'penting' => 'border-danger',
                                'informasi' => 'border-info',
                                'umum' => 'border-warning',
                                default => 'border-secondary',
                            };

                            $iconClass = match (strtolower($notif->tipe)) {
                                'penting' => 'bi-exclamation-triangle-fill text-danger',
                                'informasi' => 'bi-info-circle-fill text-info',
                                'umum' => 'bi-chat-left-dots-fill text-warning',
                                default => 'bi-bell-fill text-secondary',
                            };
                        @endphp

                        <div class="col-md-6">
                            <div class="card card-modern border-start border-4 {{ $borderClass }} h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="card-title text-dark mb-1">
                                            <i class="bi {{ $iconClass }} me-1"></i> {{ $notif->judul }}
                                        </h6>
                                    </div>
                                    <p class="mb-0 text-secondary">{{ $notif->isi }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
@endsection

@section('scripts')
    <script>
        new bootstrap.Carousel(document.querySelector('#carouselMeteran'), {
            interval: 4500,
            ride: 'carousel',
            pause: false
        });
        new bootstrap.Carousel(document.querySelector('#carouselDcp'), {
            interval: 8000,
            ride: 'carousel',
            wrap: true,
            pause: false
        });
    </script>

    <style>
        .card-modern {
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background: linear-gradient(to bottom right, #ffffff, #f8f9fa);
        }

        .card-modern:hover {
            transform: translateY(-5px) scale(1.01);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }

        .card-modern .card-title {
            font-weight: bold;
            font-size: 1.1rem;
        }

        .card-modern .card-body {
            padding: 1rem 1.25rem;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
