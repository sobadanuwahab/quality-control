@extends('layouts.custom')

@section('content')
    <div class="container">
        <h4 class="mb-3 my-3">Identitas Asset (Wajib Diisi)</h4>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('asset.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="grouping_asset">Grouping Asset</label>
                <select name="grouping_asset" class="form-control">
                    <option value="">--Pilih--</option>
                    <option value="IT">IT</option>
                    <option value="Sound">Sound</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="nama_asset">Nama Asset</label>
                <input type="text" name="nama_asset" class="form-control">
            </div>

            <div class="mb-3">
                <label for="brand">Brand / Merek</label>
                <select name="brand" class="form-control">
                    <option value="">--Pilih--</option>
                    <option value="HP">HP</option>
                    <option value="Dell">Dell</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="model_type">Model/Type</label>
                <input type="text" name="model_type" class="form-control">
            </div>

            <div class="mb-3">
                <label for="serial_number">Serial Number</label>
                <input type="text" name="serial_number" class="form-control">
            </div>

            <div class="mb-3">
                <label for="label_fungsi">Label / Fungsi</label>
                <input type="text" name="label_fungsi" class="form-control" placeholder="ex: POS ORDER 1">
            </div>

            <div class="mb-3">
                <label for="penempatan">Penempatan</label>
                <select name="penempatan" class="form-control">
                    <option value="">--Pilih--</option>
                    <option value="Ruang Server">Ruang Server</option>
                    <option value="Lantai 1">Lantai 1</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="spesifikasi_detail">Spesifikasi Detail</label>
                <textarea name="spesifikasi_detail" class="form-control"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Asset</button>
        </form>
    </div>
@endsection
