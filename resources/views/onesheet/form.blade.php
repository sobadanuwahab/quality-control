@extends('layouts.custom')

@section('content')
    <main class="flex-grow p-4">
        <div class="container mx-auto">

            <h2 class="mb-4 fw-bold text-primary">
                <i class="bi bi-pencil-square me-2"></i> Form Penerimaan Onesheet/Poster
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

            <form method="POST" action="{{ route('onesheet.store') }}">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="tanggal" class="form-label">Tanggal Penerimaan</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control"
                            value="{{ old('tanggal', \Carbon\Carbon::now()->format('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="penerima" class="form-label">Penerima</label>
                        <input type="text" name="penerima" id="penerima" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label for="pengirim" class="form-label">Pengirim</label>
                        <input type="text" name="pengirim" id="pengirim" class="form-control" required>
                    </div>
                </div>

                <hr class="my-4">
                <h5 class="mb-3">Detail Onesheet/Poster</h5>

                <div class="mb-3">
                    <label for="judul_film" class="form-label">Judul Film</label>
                    <input type="text" name="judul_film" id="judul_film" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah</label>
                    <input type="number" name="jumlah" id="jumlah" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <select name="keterangan" id="keterangan" class="form-select" required>
                        <option value="" disabled selected>Pilih keterangan</option>
                        <option value="BELUM TAYANG">BELUM TAYANG</option>
                        <option value="SEDANG TAYANG">SEDANG TAYANG</option>
                        <option value="SUDAH TAYANG">SUDAH TAYANG</option>
                    </select>
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
