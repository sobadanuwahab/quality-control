@extends('layouts.custom')

@section('content')
    <main class="flex-grow p-4">
        <div class="container mx-auto">

            {{-- Title Section --}}
            <h2 class="mb-4 fw-bold" style="color: #367fa9">
                <i class="bi bi-pencil-square me-2"></i>Form Maintenance Projector & Sound System
            </h2>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" id="success-alert" role="alert">
                    {{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('maintenance.projector.store') }}">
                @csrf

                {{-- Input Tanggal --}}
                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal Penerimaan</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control"
                        value="{{ old('tanggal', \Carbon\Carbon::now()->format('Y-m-d')) }}" required>
                </div>

                {{-- Input Deskripsi --}}
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <input type="text" class="form-control" name="deskripsi" id="deskripsi" required>
                </div>

                {{-- Pilihan Jenis Perangkat --}}
                <div class="mb-3">
                    <label for="jenis_perangkat" class="form-label">Jenis Perangkat</label>
                    <select name="jenis_perangkat" id="jenis_perangkat" class="form-control select2" required>
                        <option value="" disabled selected>-- Pilih Jenis Perangkat --</option>
                        <option value="Projector">Projector</option>
                        <option value="Sound System">Sound System</option>
                        <option value="Server">Server</option>
                        <option value="Lain-lain">Lain-lain</option>
                    </select>
                </div>

                {{-- Input Type/Merk --}}
                <div class="mb-3">
                    <label for="type" class="form-label">Type/Merk</label>
                    <input type="text" class="form-control" name="type" id="type" required>
                </div>

                {{-- Pilihan Studio --}}
                <div class="mb-3">
                    <label for="studio" class="form-label">Studio</label>
                    <select name="studio" id="studio" class="form-control select2" required>
                        <option value="" disabled selected>-- Pilih Studio --</option>
                        <option value="Studio 1">Studio 1</option>
                        <option value="Studio 2">Studio 2</option>
                        <option value="Studio 3">Studio 3</option>
                        <option value="Studio 4">Studio 4</option>
                        <option value="Studio 5">Studio 5</option>
                        <option value="Studio 6">Studio 6</option>
                        <option value="Studio 7">Studio 7</option>
                        <option value="Studio 8">Studio 8</option>
                        <option value="Studio 9">Studio 9</option>
                        <option value="Studio 10">Studio 10</option>
                        <option value="Studio Premiere 1">Studio Premiere 1</option>
                        <option value="Studio Premiere 2">Studio Premiere 2</option>
                        <option value="Studio Premiere 3">Studio Premiere 3</option>
                        <option value="Studio Premiere 4">Studio Premiere 4</option>
                        <option value="Studio IMAX">Studio IMAX</option>
                    </select>
                </div>

                {{-- Input Komponen/Barang yang Diganti --}}
                <div class="mb-3">
                    <label for="komponen_diganti" class="form-label">Barang / Komponen yang Diganti</label>
                    <input type="text" class="form-control" name="komponen_diganti" id="komponen_diganti" required>
                </div>

                {{-- Input Keterangan --}}
                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea class="form-control" name="keterangan" id="keterangan" rows="4"
                        placeholder="Tuliskan detail perawatan atau kendala teknis..."></textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Simpan
                </button>
            </form>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        // Auto dismiss alert setelah 3 detik
        setTimeout(function() {
            let alert = document.getElementById('success-alert');
            if (alert) {
                let fadeEffect = new bootstrap.Alert(alert);
                fadeEffect.close();
            }
        }, 3000); // 3000ms = 3 detik
    </script>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "--Pilih--",
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
