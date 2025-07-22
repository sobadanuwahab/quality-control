@extends('layouts.custom')

@section('content')
    <main class="flex-grow p-4">
        <div class="container mx-auto">

            {{-- Title Section --}}
            <h2 class="mb-4 fw-bold" style="color: #367fa9"><i class="bi bi-pencil-square me-2"></i>Form Maintenance HVAC</h2>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" id="success-alert" role="alert">
                    {{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('maintenance.hvac.store') }}">
                @csrf

                {{-- Tanggal --}}
                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal Penerimaan</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control"
                        value="{{ old('tanggal', \Carbon\Carbon::now()->format('Y-m-d')) }}" required>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="enable_service_date" id="enable_service_date">
                    <label class="form-check-label" for="enable_service_date">
                        Jadwalkan service rutin?
                    </label>
                </div>

                {{-- Nama Teknisi --}}
                <div class="mb-3">
                    <label for="teknisi" class="form-label">Nama Teknisi</label>
                    <input type="text" class="form-control" name="teknisi" id="teknisi" required>
                </div>

                {{-- Unit/Komponen --}}
                <div class="mb-3">
                    <label for="unit_komponen" class="form-label">Unit / Komponen</label>
                    <input type="text" class="form-control" name="unit_komponen" id="unit_komponen" required>
                </div>

                {{-- Merk/Type --}}
                <div class="mb-3">
                    <label for="merk_type" class="form-label">Merk / Type</label>
                    <input type="text" class="form-control" name="merk_type" id="merk_type" required>
                </div>

                {{-- Lokasi / Area --}}
                <div class="mb-3">
                    <label for="lokasi_area" class="form-label">Lokasi / Area</label>
                    <select name="lokasi_area" id="lokasi_area" class="form-select" required>
                        <option value="" disabled selected>-- Pilih Lokasi / Area --</option>
                        <option value="All Area">All Area</option>
                        <option value="Studio 1">Studio 1</option>
                        <option value="Studio 2">Studio 2</option>
                        <option value="Studio 3">Studio 3</option>
                        <option value="Studio 4">Studio 4</option>
                        <option value="Studio 5">Studio 5</option>
                        <option value="Studio 6">Studio 6</option>
                        <option value="Studio Premiere 1">Studio Premiere 1</option>
                        <option value="Studio Premiere 2">Studio Premiere 2</option>
                        <option value="Studio IMAX">Studio IMAX</option>
                        <option value="Lobby Deluxe">Lobby Deluxe</option>
                        <option value="Lobby Premiere">Lobby Premiere</option>
                        <option value="Lobby IMAX 1">Lobby IMAX 1</option>
                        <option value="Lobby IMAX 2">Lobby IMAX 2</option>
                        <option value="Kor. Studio 1 & 2">Kor. Studio 1 & 2</option>
                        <option value="Kor. Studio 5 & 6">Kor. Studio 5 & 6</option>
                        <option value="Kor. Exit Studio 6">Kor. Exit Studio 6</option>
                    </select>
                </div>


                {{-- Tindakan yang Dilakukan --}}
                <div class="mb-3">
                    <label for="tindakan" class="form-label">Tindakan yang Dilakukan</label>
                    <input type="text" class="form-control" name="tindakan" id="tindakan" required>
                </div>

                {{-- Keterangan Tambahan --}}
                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan Tambahan</label>
                    <textarea class="form-control" name="keterangan" id="keterangan" rows="4"
                        placeholder="Tuliskan detail perawatan atau kendala teknis..."></textarea>
                </div>

                <!-- Input tersembunyi untuk tanggal service berikutnya -->
                <input type="hidden" name="next_service_date" id="next_service_date">

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Simpan
                </button>
            </form>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tanggalInput = document.getElementById('tanggal');
            const nextServiceInput = document.getElementById('next_service_date');
            const enableServiceCheckbox = document.getElementById('enable_service_date');

            function updateNextServiceDate() {
                if (enableServiceCheckbox.checked) {
                    const tanggal = new Date(tanggalInput.value);
                    if (!isNaN(tanggal.getTime())) {
                        tanggal.setDate(tanggal.getDate() + 30); // +30 hari
                        const nextDate = tanggal.toISOString().split('T')[0];
                        nextServiceInput.value = nextDate;
                    }
                } else {
                    nextServiceInput.value = '';
                }
            }

            // Event listeners
            tanggalInput.addEventListener('change', updateNextServiceDate);
            enableServiceCheckbox.addEventListener('change', updateNextServiceDate);

            // Trigger on load
            updateNextServiceDate();
        });
    </script>

    <script>
        // Auto-dismiss success alert
        setTimeout(() => {
            const alert = document.getElementById('success-alert');
            if (alert) new bootstrap.Alert(alert).close();
        }, 3000);
    </script>
@endpush
