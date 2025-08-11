@extends('layouts.custom')

@section('content')
    <main class="flex-grow p-4">
        <div class="container mx-auto">
            <h2 class="fw-bold mb-4" style="color: #367fa9"><i class="bi bi-clipboard-data me-2"></i>Data Asset
            </h2>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="GET" action="{{ route('asset.index') }}" class="row g-3 mb-4">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Cari Nama Asset"
                        value="{{ request('search') }}">
                </div>

                <div class="col-md-4">
                    <select name="penempatan" class="form-control select2">
                        <option value="">-- Semua Penempatan --</option>
                        @foreach ($penempatanList as $penempatan)
                            <option value="{{ $penempatan }}"
                                {{ request('penempatan') == $penempatan ? 'selected' : '' }}>
                                {{ $penempatan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Search</button>
                    <a href="{{ route('asset.index') }}" class="btn btn-success">Refresh</a>
                </div>
            </form>

            <div class="table-responsive card shadow-sm p-3">
                @include('asset.table', ['assets' => $assets])
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "--Pilih Lokasi--",
                allowClear: true,
                width: '100%',
                dropdownAutoWidth: true,
                minimumResultsForSearch: Infinity // ⛔ Hilangkan kotak pencarian
            });
        });
    </script>

    <style>
        .select2-container--default .select2-selection--single {
            height: 38px !important;
            /* Bootstrap .form-control default height */
            padding: 6px 12px;
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 24px;
            /* teks di tengah */
        }
    </style>
@endpush
