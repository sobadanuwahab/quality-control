@extends('layouts.custom')

@section('content')
    <main class="flex-grow p-4">
        <div class="container mx-auto">

            {{-- Title Section --}}
            <h2 class="fw-bold text-primary mb-4"><i class="bi bi-tools me-2"></i>Laporan Maintenance Projector & Sound System
            </h2>

            {{-- Form Filter --}}
            <form method="GET" action="{{ route('maintenance.projector.laporan') }}" class="row g-2 align-items-end mb-3">
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
                <div class="col-auto">
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
                <div class="col-auto d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search me-1"></i> Cari
                    </button>

                    <a href="{{ route('maintenance.projector.laporan') }}" class="btn btn-success">
                        <i class="bi bi-arrow-repeat me-1"></i> Refresh
                    </a>

                    <a href="{{ route('maintenance.projector.pdf', request()->query()) }}" class="btn btn-danger">
                        <i class="bi bi-file-earmark-pdf me-1"></i> Export PDF
                    </a>
                </div>
            </form>
            <div class="table-responsive card shadow-sm p-3">
                <div id="result-wrapper">
                    @include('projector.partial_table', ['data' => $data])
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Live search input
            const input = document.getElementById('search-input');
            if (input) {
                input.addEventListener('input', function() {
                    const keyword = this.value;
                    const tanggalMulai = document.getElementById('tanggal_mulai').value;
                    const tanggalSampai = document.getElementById('tanggal_sampai').value;

                    const url = new URL("{{ route('maintenance.projector.search') }}", window.location
                        .origin);
                    url.searchParams.set('search', keyword);
                    if (tanggalMulai) url.searchParams.set('tanggal_mulai', tanggalMulai);
                    if (tanggalSampai) url.searchParams.set('tanggal_sampai', tanggalSampai);

                    fetch(url)
                        .then(response => response.text())
                        .then(html => {
                            document.getElementById('result-wrapper').innerHTML = html;
                        })
                        .catch(error => console.error(error));
                });
            }

            // Dropdown "search" (Studio) change submit
            const studioSelect = document.getElementById('search');
            if (studioSelect) {
                studioSelect.addEventListener('change', function() {
                    this.form.submit();
                });
            }
        });
    </script>
@endpush
