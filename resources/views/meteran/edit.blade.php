@extends('layouts.custom') {{-- atau layout yang kamu pakai --}}

@section('content')
    <div class="container mt-4">
        <h3>Edit Data Meteran</h3>

        <form action="{{ route('log_meteran.update', $log->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="tanggal">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" value="{{ $log->tanggal }}" required>
            </div>

            <div class="mb-3">
                <label for="nama_meteran">Nama Meteran</label>
                <input type="text" name="nama_meteran" class="form-control" value="{{ $log->nama_meteran }}" required>
            </div>

            <div class="mb-3">
                <label for="awal">Meter Awal</label>
                <input type="number" step="0.01" name="awal" class="form-control" value="{{ $log->awal }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="akhir">Meter Akhir</label>
                <input type="number" step="0.01" name="akhir" class="form-control" value="{{ $log->akhir }}"
                    required>
            </div>

            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('laporan.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection
