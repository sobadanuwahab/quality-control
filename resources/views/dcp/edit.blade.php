@extends('layouts.custom')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4 text-primary fw-bold">
            <i class="bi bi-pencil-square me-2"></i>Edit Data DCP
        </h2>

        {{-- Tampilkan validasi error jika ada --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Terjadi kesalahan:</strong>
                <ul class="mb-0 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Update --}}
        <form method="POST" action="{{ route('dcp.update', $dcp->id) }}">
            @csrf
            @method('PUT')

            {{-- Informasi Umum --}}
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Tanggal Penerimaan</label>
                    <input type="date" name="tanggal_penerimaan" class="form-control"
                        value="{{ old('tanggal_penerimaan', \Carbon\Carbon::parse($dcp->tanggal_penerimaan)->format('Y-m-d')) }}"
                        readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Penerima</label>
                    <input type="text" name="nama_penerima" class="form-control"
                        value="{{ old('nama_penerima', $dcp->nama_penerima) }}" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Pengirim</label>
                    <input type="text" name="pengirim" class="form-control" value="{{ old('pengirim', $dcp->pengirim) }}"
                        readonly>
                </div>
            </div>

            <hr class="my-4">
            <h5 class="fw-bold">Detail Film</h5>

            {{-- Rincian Film --}}
            <div id="film-detail-wrapper">
                @foreach ($dcp->film_details as $index => $film)
                    <div class="film-row mb-4 border p-3 rounded bg-light">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Judul Film</label>
                                <input type="text" name="film_details[{{ $index }}][judulFilm]"
                                    class="form-control" value="{{ $film['judulFilm'] ?? '' }}" required>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Aspect Ratio</label>
                                <input type="text" name="film_details[{{ $index }}][formatFilm]"
                                    class="form-control" value="{{ $film['formatFilm'] ?? '' }}" required>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Format Sound</label>
                                <input type="text" name="film_details[{{ $index }}][sound]" class="form-control"
                                    value="{{ $film['sound'] ?? '' }}" required>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Status KDM</label>
                                <select name="film_details[{{ $index }}][statusKdm]" class="form-select" required>
                                    @foreach (['Ready', 'Not Ready', 'Expired'] as $status)
                                        <option value="{{ $status }}"
                                            {{ ($film['statusKdm'] ?? '') == $status ? 'selected' : '' }}>
                                            {{ $status }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Lokasi Penyimpanan</label>
                                <input type="text" name="film_details[{{ $index }}][lokasiPenyimpanan]"
                                    class="form-control" value="{{ $film['lokasiPenyimpanan'] ?? '' }}">
                            </div>
                        </div>
                        <div class="mt-2">
                            <label class="form-label">Keterangan</label>
                            <select name="film_details[{{ $index }}][keterangan]" class="form-select" required>
                                @foreach (['Belum Tayang', 'Sedang Tayang', 'Sudah Tayang'] as $status)
                                    <option value="{{ $status }}"
                                        {{ ($film['keterangan'] ?? '') == $status ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Tombol Aksi --}}
            <div class="mt-4">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save me-1"></i> Simpan Perubahan
                </button>
                <a href="{{ route('dcp.laporan') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-1"></i> Batal
                </a>
            </div>
        </form>
    </div>
@endsection
