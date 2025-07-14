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

    {{-- Carousel DCP --}}
    @php
        // Ubah JSON string menjadi array
        $dcpReports->transform(function ($item) {
            $item->film_details = is_string($item->film_details)
                ? json_decode($item->film_details, true)
                : $item->film_details;
            return $item;
        });

        // Bagi semua data DCP jadi grup isi 6
        $chunks = $dcpReports->chunk(6);
    @endphp

    <div class="container-fluid px-4">
        <h2 class="fw-bold display-6 text-center text-md-center mb-4"
            style="font-size: clamp(35px, 6vw, 50px); color: rgb(216, 194, 68); letter-spacing: 1px; font-family: 'Roboto Slab', sans-serif; text-shadow: 2px 3px 2px rgba(0, 0, 0, 0.5);">
            {{ Auth::user()->nama_bioskop ?? 'Dashboard' }}
        </h2>
        <div id="carouselDcp" class="carousel slide mb-5" data-bs-ride="carousel" data-bs-pause="false" data-bs-interval="8000">
            <h4 class="fw-bold text-primary mb-3">
                <i class="bi bi-collection-play me-1"></i> DCP Reports Update
            </h4>

            <div class="carousel-inner rounded shadow overflow-hidden">
                @foreach ($chunks as $index => $group)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <div class="d-flex justify-content-center gap-3 flex-wrap py-4 px-3">
                            @foreach ($group as $item)
                                <div class="card card-modern dcp-card">
                                    @if (!empty($item->poster_url))
                                        <div class="poster-wrapper">
                                            <img src="{{ $item->poster_url }}"
                                                alt="Poster {{ $item->film_details[0]['judulFilm'] ?? 'Film' }}"
                                                class="poster-img">
                                        </div>
                                    @endif
                                    <div class="card-body">
                                        <h6 class="card-title text-primary mb-2">
                                            <i class="bi bi-film me-1"></i> {{ $item->film_details[0]['judulFilm'] ?? '-' }}
                                        </h6>
                                        <p class="mb-1 text-muted">Penerima:
                                            <strong>{{ $item->nama_penerima ?? '-' }}</strong>
                                        </p>
                                        <p class="mb-0 text-muted">Tanggal:
                                            <strong>{{ \Carbon\Carbon::parse($item->tanggal_penerimaan)->format('d M Y') }}</strong>
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($chunks->count() > 1)
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselDcp" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselDcp" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            @endif
        </div>
    </div>
    {{-- End Carousel DCP --}}

    {{-- Carousel Meteran --}}
    <div class="container-fluid px-4">
        <h4 class="fw-bold text-primary mb-3">
            <i class="bi bi-speedometer2 me-1"></i> Meteran Reports Update
        </h4>

        {{-- Grid Card Meteran --}}
        <div class="row g-4 mb-5">
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

            @foreach ($total_kumulatif as $nama_meteran => $data)
                <div class="col-md-4">
                    <div class="card card-modern border border-4 {{ $warna($nama_meteran) }}">
                        <div class="card-body d-flex align-items-center">
                            <div class="me-3">
                                <i class="bi {{ $ikon($nama_meteran) }} display-4"
                                    style="text-shadow: 0 4px 2px rgba(0, 0, 0, 0.3);"></i>
                            </div>
                            <div>
                                <h6 class="text-muted fw-bold">{{ $nama_meteran }}</h6>
                                <h5 class="fw-bold">
                                    {{ number_format($data['nilai'], 2) }}
                                    <small>{{ $satuan($nama_meteran) }}</small>
                                </h5>
                                @if ($data['tanggal'])
                                    <small class="fw-semibold text-success">
                                        Update: {{ \Carbon\Carbon::parse($data['tanggal'])->format('d M Y') }}
                                    </small>
                                @else
                                    <small class="text-danger fw-bold">Belum ada data</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{-- End Grid Card Meteran --}}



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
    {{-- End Carousel Meteran --}}
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const carousel = document.querySelector('#carouselDcp');
            if (carousel) {
                new bootstrap.Carousel(carousel, {
                    interval: 4000,
                    ride: 'carousel',
                    wrap: true
                });
            }
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

    <style>
        .text-shadow {
            text-shadow: 2px 3px 5px rgba(0, 0, 0, 0.8);
        }

        .object-fit-cover {
            object-fit: cover;
        }
    </style>

    <style>
        .dcp-card {
            width: 250px !important;
            flex-shrink: 0;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .poster-wrapper {
            width: 100%;
            height: 280px !important;
            /* Diperkecil dari sebelumnya */
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f8f9fa;
            overflow: hidden;
            border-bottom: 1px solid #dee2e6;
        }

        .poster-img {
            height: 100%;
            width: auto;
            object-fit: contain;
            image-rendering: auto;
        }

        @media (max-width: 768px) {
            .dcp-card {
                width: 150px;
            }

            .poster-wrapper {
                height: 220px;
            }
        }
    </style>
@endpush
