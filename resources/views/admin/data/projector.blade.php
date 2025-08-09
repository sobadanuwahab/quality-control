@extends('layouts.custom')

@section('content')
    <main class="flex-grow p-4">
        <div class="container mx-auto">

            {{-- Title --}}
            <h2 class="fw-bold mb-4 text-primary">
                <i class="bi bi-clipboard-data me-2"></i>
                Laporan Maintenance Projector & Sound System
            </h2>

            {{-- Filter Form --}}
            <form method="GET" action="{{ route('maintenance.projector.laporan') }}" class="row g-3 align-items-end mb-4">
                <div class="col-md-3">
                    <label for="tanggal_mulai" class="form-label">Dari Tanggal</label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control"
                        value="{{ request('tanggal_mulai') }}">
                </div>
                <div class="col-md-3">
                    <label for="tanggal_sampai" class="form-label">Sampai Tanggal</label>
                    <input type="date" name="tanggal_sampai" id="tanggal_sampai" class="form-control"
                        value="{{ request('tanggal_sampai') }}">
                </div>
                <div class="col-md-3">
                    <label for="search" class="form-label">Pilih Studio</label>
                    <select name="search" id="search" class="form-select">
                        <option value="">-- Semua Studio --</option>
                        @foreach (['Studio 1', 'Studio 2', 'Studio 3', 'Studio 4', 'Studio 5', 'Studio 6', 'Studio Premiere 1', 'Studio Premiere 2', 'Studio IMAX'] as $studio)
                            <option value="{{ $studio }}" {{ request('search') == $studio ? 'selected' : '' }}>
                                {{ $studio }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="d-flex gap-2">
                    <!-- Tombol Cari -->
                    <button type="submit" class="btn btn-primary btn-sm d-flex align-items-center">
                        <i class="bi bi-search me-1"></i> Cari
                    </button>
                    <!-- Tombol Refresh -->
                    <a href="{{ route('maintenance.projector.laporan') }}"
                        class="btn btn-success btn-sm d-flex align-items-center">
                        <i class="bi bi-arrow-repeat me-1"></i> Refresh
                    </a>
                    <!-- Tombol PDF -->
                    <a href="{{ route('maintenance.projector.pdf', request()->query()) }}"
                        class="btn btn-danger btn-sm d-flex align-items-center">
                        <i class="bi bi-file-earmark-pdf me-1"></i>Export PDF
                    </a>
                </div>
            </form>

            {{-- Table --}}
            <div class="table-responsive card shadow-sm p-3">
                <table class="table table-bordered table-hover align-middle small">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>No</th>
                            <th style="width: 8%;">Tanggal</th>
                            <th>Deskripsi</th>
                            <th>Jenis Perangkat</th>
                            <th style="width: 12%;">Type/Merk</th>
                            <th style="width: 12%;">Studio</th>
                            <th>Barang/Komponen Diganti</th>
                            <th>Keterangan</th>
                            @auth
                                @if (auth()->user()->role === 'admin')
                                    <th>Aksi</th>
                                @endif
                            @endauth
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $index => $row)
                            <tr class="text-center">
                                <td>{{ method_exists($data, 'firstItem') ? $data->firstItem() + $index : $index + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') }}</td>
                                <td>{{ $row->deskripsi }}</td>
                                <td>{{ $row->jenis_perangkat }}</td>
                                <td>{{ $row->type_merk }}</td>
                                <td>{{ $row->studio }}</td>
                                <td>{{ $row->komponen_diganti ?? '-' }}</td>
                                <td>{{ $row->keterangan }}</td>
                                @auth
                                    @if (auth()->user()->role === 'admin')
                                        <td>
                                            <a href="{{ route('maintenance.projector.edit', $row->id) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="{{ route('maintenance.projector.destroy', $row->id) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    @endif
                                @endauth
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ auth()->user()->role === 'admin' ? 9 : 8 }}"
                                    class="text-center text-danger">
                                    Belum ada data maintenance projector & sound system
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="mt-3">
                    {{ method_exists($data, 'links') ? $data->links('pagination::bootstrap-5') : '' }}
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const studioSelect = document.getElementById('search');
            if (studioSelect) {
                studioSelect.addEventListener('change', function() {
                    this.form.submit();
                });
            }
        });
    </script>
@endpush
