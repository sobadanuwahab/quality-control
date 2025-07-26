@extends('layouts.custom')

@section('content')
    <main class="flex-grow p-4">
        <div class="container mx-auto">

            <h2 class="mb-4 fw-bold" style="color: #367fa9">
                <i class="bi bi-pencil-square me-2"></i> Form Penerimaan DCP
            </h2>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" id="success-alert" role="alert">
                    {{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('dcp.store') }}">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="tanggal_penerimaan" class="form-label">Tanggal Penerimaan</label>
                        <input type="date" name="tanggal_penerimaan" id="tanggal_penerimaan" class="form-control"
                            value="{{ old('tanggal_penerimaan', \Carbon\Carbon::now()->format('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="nama_penerima" class="form-label">Penerima</label>
                        <input type="text" name="nama_penerima" id="nama_penerima" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label for="pengirim" class="form-label">Pengirim</label>
                        <input type="text" name="pengirim" id="pengirim" class="form-control" required>
                    </div>
                </div>

                <hr class="my-4">
                <h5 class="mb-3">Detail Digital Cinema Package (DCP)</h5>

                <div id="film-detail-wrapper">
                    <div class="film-row mb-4 border rounded p-3">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label">Judul Film</label>
                                <input type="text" name="film_details[0][judulFilm]" class="form-control" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Aspect Ratio</label>
                                <input type="text" name="film_details[0][formatFilm]" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Format Sound</label>
                                <input type="text" name="film_details[0][sound]" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Status KDM</label>
                                <select name="film_details[0][statusKdm]" class="form-select" required>
                                    <option value="" disabled selected>Pilih status</option>
                                    <option value="Ready">Ready</option>
                                    <option value="Not Ready">Not Ready</option>
                                    <option value="Expired">Expired</option>
                                </select>
                            </div>
                            <div class="col-md-4 my-2">
                                <label class="form-label d-block">Lokasi Penyimpanan</label>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach ($locations as $loc)
                                        <div class="form-check" style="width: 48%;">
                                            <input class="form-check-input" type="checkbox"
                                                name="film_details[0][lokasiPenyimpanan][]" value="{{ $loc }}"
                                                id="lokasi_0_{{ $loop->index }}">
                                            <label class="form-check-label"
                                                for="lokasi_0_{{ $loop->index }}">{{ $loc }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <label class="form-label">Keterangan</label>
                            <select name="film_details[0][keterangan]" class="form-select" required>
                                <option value="" disabled selected>Pilih keterangan</option>
                                <option value="Belum Tayang">Belum Tayang</option>
                                <option value="Sedang Tayang">Sedang Tayang</option>
                                <option value="Sudah Tayang">Sudah Tayang</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <button type="button" class="btn btn-sm btn-outline-primary" id="add-film-row">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Form
                    </button>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save me-1"></i> Simpan
                </button>
            </form>
        </div>
    </main>

@endsection

@push('scripts')
    <script>
        const locations = @json($locations);
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let filmIndex =
                {{ count(old('film_details', [0])) }}; // Hitung index awal berdasarkan jumlah field lama atau default 1

            document.getElementById("add-film-row").addEventListener("click", function() {
                const container = document.getElementById("film-rows");

                let lokasiHTML = '<div class="col-md-4">' +
                    '<label class="form-label d-block">Lokasi Penyimpanan</label>' +
                    '<div class="d-flex flex-wrap gap-2">';

                locations.forEach((loc, locIndex) => {
                    lokasiHTML += `
                    <div class="form-check" style="width: 48%;">
                        <input class="form-check-input" type="checkbox"
                            name="film_details[${filmIndex}][lokasiPenyimpanan][]" value="${loc}"
                            id="lokasi_${filmIndex}_${locIndex}">
                        <label class="form-check-label" for="lokasi_${filmIndex}_${locIndex}">${loc}</label>
                    </div>`;
                });

                lokasiHTML += '</div></div>';

                const html = `
                <div class="row mb-3 border-top pt-3">
                    <div class="col-md-3">
                        <label class="form-label">Judul Film</label>
                        <input type="text" name="film_details[${filmIndex}][judulFilm]" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Format Film</label>
                        <input type="text" name="film_details[${filmIndex}][formatFilm]" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Sound</label>
                        <input type="text" name="film_details[${filmIndex}][sound]" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Status KDM</label>
                        <input type="text" name="film_details[${filmIndex}][statusKdm]" class="form-control">
                    </div>
                    ${lokasiHTML}
                    <div class="col-md-3 mt-3">
                        <label class="form-label">Keterangan</label>
                        <select name="film_details[${filmIndex}][keterangan]" class="form-select">
                            <option value="">-- Pilih --</option>
                            <option value="Sedang Tayang">Sedang Tayang</option>
                            <option value="Sudah Tayang">Sudah Tayang</option>
                        </select>
                    </div>
                </div>
            `;

                container.insertAdjacentHTML("beforeend", html);
                filmIndex++;
            });
        });
    </script>
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
@endpush
