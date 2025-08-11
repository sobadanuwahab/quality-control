@extends('layouts.custom')

@section('content')
    <main class="flex-grow p-4">
        <div class="container mx-auto">
            <h2 class="mb-4 fw-bold" style="color: #367fa9">
                <i class="bi bi-pencil-square me-2"></i>Form Input Asset
            </h2>

            @if (session('success'))
                <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('asset.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="grouping_asset" class="form-label">Grouping Asset</label>
                    <select name="grouping_asset" class="form-control select2">
                        <option value="">--Pilih--</option>
                        <option value="IT OPERASIONAL">[CINEMA] IT OPERASIONAL</option>
                        <option value="PROYEKTOR">[CINEMA] PROYEKTOR</option>
                        <option value="CINEMA ADS">[CINEMA] CINEMA ADS</option>
                        <option value="HVAC">[CINEMA] HVAC</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="nama_asset" class="form-label">Nama Asset</label>
                    <select name="nama_asset" class="form-control select2">
                        <option value="">--Pilih--</option>
                        <option value="PROJECTOR">PROJECTOR</option>
                        <option value="SERVER">SERVER</option>
                        <option value="PROCESSOR">PROCESSOR</option>
                        <option value="POWER AMPLIFIER">POWER AMPLIFIER</option>
                        <option value="AUTOMATION CONTROLLER (ACT)">AUTOMATION CONTROLLER (ACT)</option>
                        <option value="UNINTERRUPTIBLE POWER SUPPLY (UPS)">UNINTERRUPTIBLE POWER SUPPLY (UPS)</option>
                        <option value="LAYAR">LAYAR</option>
                        <option value="HVAC SPLIT DUCT">HVAC SPLIT DUCT</option>
                        <option value="HVAC SPLIT WALL">HVAC SPLIT WALL</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="brand" class="form-label">Brand / Merek</label>
                    <select name="brand" class="form-control select2">
                        <option value="">--Pilih--</option>
                        <option value="BARCO">BARCO</option>
                        <option value="CHRISTIE">CHRISTIE</option>
                        <option value="DOREMI">DOREMI</option>
                        <option value="DOLBY">DOLBY</option>
                        <option value="QSC">QSC</option>
                        <option value="VIVE AUDIO">VIVE AUDIO</option>
                        <option value="TICA">TICA</option>
                        <option value="YORK">YORK</option>
                        <option value="TP-LINK">TP-LINK</option>
                        <option value="D-LINK">D-LINK</option>
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
                    <input type="text" name="label_fungsi" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="penempatan" class="form-label">Penempatan</label>
                    <select name="penempatan" class="form-control select2">
                        <option value="">--Pilih--</option>
                        <option value="R.CENTRALIZE">R.CENTRALIZE</option>
                        <option value="R.PROJ.STUDIO 1">R.PROJ.STUDIO 1</option>
                        <option value="R.PROJ.STUDIO 2">R.PROJ.STUDIO 2</option>
                        <option value="R.PROJ.STUDIO 3">R.PROJ.STUDIO 3</option>
                        <option value="R.PROJ.STUDIO 4">R.PROJ.STUDIO 4</option>
                        <option value="R.PROJ.STUDIO 5">R.PROJ.STUDIO 5</option>
                        <option value="R.PROJ.STUDIO 6">R.PROJ.STUDIO 6</option>
                        <option value="R.PROJ.STUDIO 7">R.PROJ.STUDIO 7</option>
                        <option value="R.PROJ.STUDIO 8">R.PROJ.STUDIO 8</option>
                        <option value="R.PROJ.STUDIO 9">R.PROJ.STUDIO 9</option>
                        <option value="R.PROJ.STUDIO 10">R.PROJ.STUDIO 10</option>
                        <option value="R.PROJ.STUDIO 11">R.PROJ.STUDIO 11</option>
                        <option value="R.PROJ.STUDIO PREMIERE 1">R.PROJ.STUDIO PREMIERE 1</option>
                        <option value="R.PROJ.STUDIO PREMIERE 2">R.PROJ.STUDIO PREMIERE 2</option>
                        <option value="R.PROJ.STUDIO PREMIERE 3">R.PROJ.STUDIO PREMIERE 3</option>
                        <option value="R.PROJ.STUDIO PREMIERE 4">R.PROJ.STUDIO PREMIERE 4</option>
                        <option value="R.PROJ.STUDIO IMAX">R.PROJ.STUDIO IMAX</option>
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

@push('scripts')
    <script>
        // Auto close alert setelah 5 detik
        setTimeout(function() {
            let alertBox = document.getElementById('success-alert');
            if (alertBox) {
                let bsAlert = new bootstrap.Alert(alertBox);
                bsAlert.close();
            }
        }, 5000);
    </script>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "--Pilih--",
                allowClear: true,
                width: '100%',
                dropdownAutoWidth: true,
                minimumResultsForSearch: Infinity
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
