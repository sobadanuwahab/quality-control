@extends('layouts.custom')

@section('content')
    <main class="flex-grow p-4">
        <div class="container mx-auto">
            <h2 class="fw-bold mb-4" style="color: #367fa9">
                <i class="bi bi-pencil-square me-2"></i>Edit Asset
            </h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('asset.update', $asset->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="serial_number" class="form-label">Serial Number</label>
                    <input type="text" name="serial_number" class="form-control" id="serial_number"
                        value="{{ old('serial_number', $asset->serial_number) }}" required>
                </div>

                <div class="mb-3">
                    <label for="nama_asset" class="form-label">Nama Asset</label>
                    <input type="text" name="nama_asset" class="form-control" id="nama_asset"
                        value="{{ old('nama_asset', $asset->nama_asset) }}" required>
                </div>

                <div class="mb-3">
                    <label for="brand" class="form-label">Brand / Merk</label>
                    <input type="text" name="brand" class="form-control" id="brand"
                        value="{{ old('brand', $asset->brand) }}">
                </div>

                <div class="mb-3">
                    <label for="model_type" class="form-label">Model / Type</label>
                    <input type="text" name="model_type" class="form-control" id="model_type"
                        value="{{ old('model_type', $asset->model_type) }}">
                </div>

                <div class="mb-3">
                    <label for="penempatan" class="form-label">Penempatan</label>
                    <input type="text" name="penempatan" class="form-control" id="penempatan"
                        value="{{ old('penempatan', $asset->penempatan) }}">
                </div>

                <div class="mb-3">
                    <label for="label_fungsi" class="form-label">Label / Fungsi</label>
                    <input type="text" name="label_fungsi" class="form-control" id="label_fungsi"
                        value="{{ old('label_fungsi', $asset->label_fungsi) }}">
                </div>

                <div class="mb-3">
                    <label for="spesifikasi_detail" class="form-label">Spesifikasi Detail</label>
                    <textarea name="spesifikasi_detail" id="spesifikasi_detail" class="form-control" rows="4">{{ old('spesifikasi_detail', $asset->spesifikasi_detail) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="foto" class="form-label">Foto (jika ingin ganti)</label>
                    <input type="file" name="foto" class="form-control" id="foto" accept="image/*">

                    @if ($asset->foto)
                        <a href="{{ asset('storage/' . ltrim($asset->foto, 'public/')) }}" data-lightbox="asset-image"
                            data-title="Foto Asset">
                            <img src="{{ asset('storage/' . ltrim($asset->foto, 'public/')) }}" alt="Foto Asset"
                                width="150" class="mt-2" style="cursor: pointer;">
                        </a>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">Update Asset</button>
                <a href="{{ route('asset.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </main>
@endsection
