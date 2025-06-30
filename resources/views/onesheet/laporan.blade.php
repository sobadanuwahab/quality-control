@extends('layouts.custom')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4 fw-bold text-primary">
            <i class="bi bi-clipboard-data me-2"></i> Laporan Onesheet/Poster
        </h2>

        <div class="card shadow-sm">
            <div class="card-body table-responsive">
                {{-- Input di luar form agar tidak tabrakan dengan result-wrapper --}}
                <div class="row mb-4">
                    <div class="col-md-4">
                        <input type="text" name="search" id="search-input" class="form-control"
                            placeholder="Cari judul film...">
                    </div>
                </div>

                {{-- Hasil tabel AJAX --}}
                <div id="result-wrapper">
                    @include('onesheet.partial_table', ['onesheets' => $onesheets])
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('search-input');

            input.addEventListener('input', function() {
                const keyword = this.value;

                fetch(`{{ route('onesheet.search') }}?search=${encodeURIComponent(keyword)}`)
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('result-wrapper').innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });
    </script>
@endpush
