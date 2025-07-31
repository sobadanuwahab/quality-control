@extends('layouts.custom')

@section('content')
    <main class="flex-grow p-4">
        <div class="container mx-auto">
            <h2 class="mb-4 fw-bold" style="color: #367fa9">
                <i class="bi bi-pencil-square me-2"></i>Form Input Asset
            </h2>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('asset.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="grouping_asset" class="form-label">Grouping Asset</label>
                    <select name="grouping_asset" class="form-control">
                        <option value="">--Pilih--</option>
                        <option value="IT OPERASIONAL">[CINEMA] IT OPERASIONAL</option>
                        <option value="PROYEKTOR">[CINEMA] PROYEKTOR</option>
                        <option value="CINEMA ADS">[CINEMA] CINEMA ADS</option>
                        <option value="HVAC">[CINEMA] HVAC</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="nama_asset" class="form-label">Nama Asset</label>
                    <select name="nama_asset" class="form-control">
                        <option value="">--Pilih--</option>
                        <option value="Projector">Projector</option>
                        <option value="Server">Server</option>
                        <option value="Sound System">Sound System</option>
                        <option value="HVAC Split Duct">HVAC Split Duct</option>
                        <option value="HVAC Split Wall">HVAC Split Wall</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="brand" class="form-label">Brand / Merek</label>
                    <select name="brand" class="form-control">
                        <option value="">--Pilih--</option>
                        <option value="Barco">Barco</option>
                        <option value="Christie">Christie</option>
                        <option value="Doremi">Doremi</option>
                        <option value="Dolby">Dolby</option>
                        <option value="QSC">QSC</option>
                        <option value="Vive Audio">Vive Audio</option>
                        <option value="Tica">Tica</option>
                        <option value="York">York</option>
                        <option value="TP-Link">TP-Link</option>
                        <option value="D-Link">D-Link</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="model_type" class="form-label">Model/Type</label>
                    <input type="text" name="model_type" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="serial_number" class="form-label">Serial Number</label>
                    <input type="text" name="serial_number" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="label_fungsi" class="form-label">Label / Fungsi</label>
                    <input type="text" name="label_fungsi" class="form-control" placeholder="ex: POS ORDER 1">
                </div>

                <div class="mb-3">
                    <label for="penempatan" class="form-label">Penempatan</label>
                    <select name="penempatan" class="form-control">
                        <option value="">--Pilih--</option>
                        <option value="Ruang Centralize">Ruang Centralize</option>
                        <option value="Ruang Proj.Studio 1">Ruang Proj.Studio 1</option>
                        <option value="Ruang Proj.Studio 2">Ruang Proj.Studio 2</option>
                        <option value="Ruang Proj.Studio 3">Ruang Proj.Studio 3</option>
                        <option value="Ruang Proj.Studio 4">Ruang Proj.Studio 4</option>
                        <option value="Ruang Proj.Studio 5">Ruang Proj.Studio 5</option>
                        <option value="Ruang Proj.Studio 6">Ruang Proj.Studio 6</option>
                        <option value="Ruang Proj.Studio 7">Ruang Proj.Studio 7</option>
                        <option value="Ruang Proj.Studio 8">Ruang Proj.Studio 8</option>
                        <option value="Ruang Proj.Studio 9">Ruang Proj.Studio 9</option>
                        <option value="Ruang Proj.Studio 10">Ruang Proj.Studio 10</option>
                        <option value="Ruang Proj.Studio 11">Ruang Proj.Studio 11</option>
                        <option value="Ruang Proj.Studio Premiere 1">Ruang Proj.Studio Premiere 1</option>
                        <option value="Ruang Proj.Studio Premiere 2">Ruang Proj.Studio Premiere 2</option>
                        <option value="Ruang Proj.Studio Premiere 3">Ruang Proj.Studio Premiere 3</option>
                        <option value="Ruang Proj.Studio Premiere 4">Ruang Proj.Studio Premiere 4</option>
                        <option value="Ruang Proj.Studio IMAX">Ruang Proj.Studio IMAX</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="spesifikasi_detail" class="form-label">Spesifikasi Detail</label>
                    <textarea name="spesifikasi_detail" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label for="foto" class="form-label">Upload Image Asset</label>
                    <input type="file" name="foto" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Simpan Asset</button>
            </form>
        </div>
    </main>
@endsection
