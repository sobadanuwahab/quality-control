@extends('layouts.custom')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4 text-primary"><i class="bi bi-pencil-square me-2"></i>Edit Data Maintenance</h2>

        <form action="{{ route('maintenance.projector.update', $data->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" name="tanggal" class="form-control"
                    value="{{ \Carbon\Carbon::parse($data->tanggal)->format('Y-m-d') }}">
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <input type="text" name="deskripsi" class="form-control" value="{{ $data->deskripsi }}" required>
            </div>

            <div class="mb-3">
                <label for="jenis_perangkat" class="form-label">Jenis Perangkat</label>
                <input type="text" name="jenis_perangkat" class="form-control" value="{{ $data->jenis_perangkat }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="type_merk" class="form-label">Type/Merk</label>
                <input type="text" name="type_merk" class="form-control" value="{{ $data->type_merk }}" required>
            </div>

            <div class="mb-3">
                <label for="studio" class="form-label">Studio</label>
                <input type="text" name="studio" class="form-control" value="{{ $data->studio }}" required>
            </div>

            <div class="mb-3">
                <label for="komponen_diganti" class="form-label">Komponen yang Diganti</label>
                <input type="text" name="komponen_diganti" class="form-control" value="{{ $data->komponen_diganti }}">
            </div>

            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="3">{{ $data->keterangan }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('maintenance.projector.laporan') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
