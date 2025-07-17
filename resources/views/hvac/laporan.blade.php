@extends('layouts.custom')

@section('content')
    <main class="flex-grow p-4">
        <div class="container mx-auto">
            {{-- Title Section --}}
            <h2 class="fw-bold text-primary mb-4"><i class="bi bi-tools me-2"></i>Laporan Maintenance HVAC</h2>

            <form method="GET" action="{{ route('maintenance.hvac.laporan') }}" class="row g-2 align-items-end mb-3">
                <div class="col-auto">
                    <label for="tanggal_mulai" class="form-label">Dari Tanggal</label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control"
                        value="{{ request('tanggal_mulai') }}">
                </div>
                <div class="col-auto">
                    <label for="tanggal_sampai" class="form-label">Sampai Tanggal</label>
                    <input type="date" name="tanggal_sampai" id="tanggal_sampai" class="form-control"
                        value="{{ request('tanggal_sampai') }}">
                </div>
                <div class="col-auto d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-funnel me-1"></i> Filter
                    </button>
                    <a href="{{ route('maintenance.hvac.pdf', request()->query()) }}" class="btn btn-danger">
                        <i class="bi bi-file-earmark-pdf me-1"></i> Export PDF
                    </a>
                </div>
            </form>

            <div class="table-responsive card shadow-sm p-3">
                <table class="table table-bordered table-hover align-middle small">
                    <thead class="table-dark text-center align-middle">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Teknisi</th>
                            <th>Unit/Komponen</th>
                            <th>Merk/Type</th>
                            <th>Lokasi</th>
                            <th>Tindakan</th>
                            <th>Keterangan</th>
                            @if (auth()->user()->username !== 'TGRSERO')
                                <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $index => $row)
                            <tr class="text-center">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') }}</td>
                                <td>{{ $row->teknisi }}</td>
                                <td>{{ $row->unit_komponen }}</td>
                                <td>{{ $row->merk_type }}</td>
                                <td>{{ $row->lokasi_area }}</td>
                                <td>{{ $row->tindakan }}</td>
                                <td>{{ $row->keterangan }}</td>
                                @if (auth()->user()->username !== 'TGRSERO')
                                    <td class="text-center">
                                        @if ($row->is_done)
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle me-1"></i> Done
                                            </span>
                                        @elseif (auth()->user()->role === 'admin')
                                            <form method="POST" action="{{ route('maintenance.hvac.done', $row->id) }}"
                                                onsubmit="return confirm('Tandai data ini sebagai selesai?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    style="padding: 4px 8px; font-size: 0.7rem;">
                                                    <i class="bi bi-check-circle me-1"></i> Action
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                @endif

                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-danger">Belum ada data maintenance HVAC</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
@endsection
