@extends('layouts.custom')

@section('content')
    <main class="flex-grow p-4">
        <div class="container mx-auto">
            <h2 class="mt-4 mb-4 text-primary fw-bold">
                <i class="bi bi-file-earmark-bar-graph me-2"></i> Laporan Data Meteran
            </h2>

            {{-- Filter Form --}}
            <form class="mb-4" method="get">
                <div class="row gx-2 gy-2">
                    <div class="col-md-3">
                        <label for="tanggal_awal" class="form-label">Dari:</label>
                        <input type="date" id="tanggal_awal" name="tanggal_awal" class="form-control form-control-sm"
                            value="{{ $tanggal_awal ?? '' }}" required>
                    </div>

                    <div class="col-md-3">
                        <label for="tanggal_akhir" class="form-label">Sampai:</label>
                        <input type="date" id="tanggal_akhir" name="tanggal_akhir" class="form-control form-control-sm"
                            value="{{ $tanggal_akhir ?? '' }}" required>
                    </div>
                </div>

                {{-- Tombol di bawah --}}
                <div class="d-flex justify-content-start align-items-center mt-3 gap-2">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="bi bi-funnel me-1"></i> Tampilkan
                    </button>

                    @if ($raw_data && count($raw_data))
                        <a href="{{ route('laporan.pdf', request()->query()) }}" target="_blank"
                            class="btn btn-danger btn-sm">
                            <i class="bi bi-file-earmark-pdf me-1"></i> Export PDF
                        </a>
                    @endif
                </div>
            </form>


            @if ($raw_data && count($raw_data))
                @foreach ($raw_data as $nama => $rows)
                    <div class="card mb-5 shadow-sm">
                        <div class="card-header bg-light border-bottom d-flex align-items-center">
                            <i class="bi bi-clipboard-data me-2 text-secondary"></i>
                            <strong class="text-dark">Laporan {{ $nama }}</strong>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-bordered table-hover table-sm mb-0">
                                <thead class="table-dark text-center">
                                    <tr>
                                        <th scope="col" class="text-center">Tanggal</th>
                                        <th scope="col" class="text-center">Awal</th>
                                        <th scope="col" class="text-center">Akhir</th>
                                        <th scope="col" class="text-center">Pemakaian</th>
                                        <th scope="col" class="text-center">Satuan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rows as $row)
                                        @php
                                            $satuan =
                                                str_contains($row->nama_meteran, 'Air') ||
                                                str_contains($row->nama_meteran, 'Gas')
                                                    ? 'm³/kubik'
                                                    : 'kWh';
                                        @endphp
                                        <tr
                                            class="
                                    @if (str_contains($row->nama_meteran, 'Air')) table-info
                                    @elseif(str_contains($row->nama_meteran, 'Gas')) table-warning
                                    @else table-success @endif
                                ">
                                            <td class="text-center">{{ $row->tanggal }}</td>
                                            <td class="text-center">{{ $row->awal }}</td>
                                            <td class="text-center">{{ $row->akhir }}</td>
                                            <td class="text-center">{{ $row->pemakaian }}</td>
                                            <td class="text-center">{{ $satuan }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach

                {{-- Ringkasan Total Kumulatif --}}
                <div class="card bg-light mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><i class="bi bi-bar-chart-fill me-2"></i> Total Kumulatif Pemakaian</h5>
                        <ul class="list-group list-group-flush">
                            @foreach ($total_kumulatif as $nama => $total)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <strong>{{ $nama }}</strong>
                                    @php
                                        $satuan =
                                            str_contains($nama, 'Air') || str_contains($nama, 'Gas')
                                                ? 'm³/kubik'
                                                : 'kWh';
                                    @endphp
                                    <span class="badge bg-primary rounded-pill">{{ number_format($total, 2) }}
                                        {{ $satuan }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @else
                <div class="alert alert-warning mt-4">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Tidak ada data untuk rentang tanggal tersebut.
                </div>
            @endif
        </div>
    </main>
@endsection
