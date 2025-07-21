@extends('layouts.custom')

@section('content')
    <main class="flex-grow p-4">
        <div class="container mx-auto">
            <h2 class="mt-4 mb-4 text-primary"><i class="bi bi-pencil-square me-2"></i><strong> Input Data Meteran</strong>
            </h2>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('meteran.store') }}" class="row g-3">
                @csrf

                {{-- Tanggal --}}
                <div class="col-2">
                    <label for="tanggal" class="form-label fw-semibold">
                        <i class="bi bi-calendar-check me-1"></i> Tanggal
                    </label>
                    <input type="date" class="form-control" name="tanggal" id="tanggal"
                        value="{{ now()->format('Y-m-d') }}" required>
                </div>

                {{-- Jenis Meteran --}}
                <div class="col-12">
                    <label for="nama_meteran" class="form-label fw-semibold">
                        <i class="bi bi-file-earmark-text me-1"></i> Jenis Meteran
                    </label>
                    <select class="form-select" name="nama_meteran" id="nama_meteran" required>
                        <option value="">-- Pilih Jenis --</option>
                        @foreach (['Meteran Listrik 1_WBP', 'Meteran Listrik 1_LWBP', 'Meteran Listrik 2_WBP', 'Meteran Listrik 2_LWBP', 'Meteran Listrik Single 1', 'Meteran Listrik Single 2', 'Meteran Air', 'Meteran Gas', 'Meteran Elpiji'] as $jenis)
                            <option value="{{ $jenis }}">{{ $jenis }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Meteran Awal --}}
                <div class="col-12">
                    <label for="awal" class="form-label fw-semibold">
                        <i class="bi bi-box-arrow-in-left me-1"></i> Meteran Awal
                    </label>
                    <div class="input-group">
                        <input type="number" step="0.01" class="form-control" name="awal" id="awal" required>
                        <span class="input-group-text">kWh / m³</span>
                    </div>
                </div>

                {{-- Meteran Akhir --}}
                <div class="col-12">
                    <label for="akhir" class="form-label fw-semibold">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Meteran Akhir
                    </label>
                    <div class="input-group">
                        <input type="number" step="0.01" class="form-control" name="akhir" id="akhir" required>
                        <span class="input-group-text">kWh / m³</span>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save2 me-1"></i> Simpan Data
                    </button>
                </div>
            </form>

        </div>
    </main>

    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const selectMeteran = document.querySelector('select[name="nama_meteran"]');
                const awalInput = document.querySelector('input[name="awal"]');

                selectMeteran.addEventListener('change', async function() {
                    const selected = this.value;
                    if (!selected) return;

                    try {
                        const res = await fetch(
                            `{{ route('meteran.last-akhir') }}?nama_meteran=${encodeURIComponent(selected)}`
                        );
                        const data = await res.json();
                        if (data.akhir !== undefined) {
                            awalInput.value = data.akhir;
                        }
                    } catch (err) {
                        console.error("Gagal mengambil data terakhir:", err);
                    }
                });
            });
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const selectMeteran = document.querySelector('select[name="nama_meteran"]');
                const awalInput = document.querySelector('input[name="awal"]');

                selectMeteran.addEventListener('change', async function() {
                    const selected = this.value;
                    if (!selected) return;

                    try {
                        const res = await fetch(
                            `/meteran/last-akhir?nama_meteran=${encodeURIComponent(selected)}`);
                        const data = await res.json();
                        if (data.akhir !== undefined) {
                            awalInput.value = data.akhir;
                        }
                    } catch (err) {
                        console.error("Gagal mengambil data terakhir:", err);
                    }
                });

                // Auto-hide success alert after 5 seconds
                const successAlert = document.querySelector('.alert-success');
                if (successAlert) {
                    setTimeout(() => {
                        successAlert.classList.add('fade');
                        successAlert.addEventListener('transitionend', () => successAlert.remove());
                    }, 5000);
                }
            });
        </script>
    @endpush
@endsection
