@extends('layouts.custom')

@section('content')
    <main class="flex-grow p-4">
        <div class="container mx-auto">

            <h2 class="mb-4 fw-bold text-primary">
                <i class="bi bi-clipboard2-data me-2"></i> Laporan Penerimaan DCP
            </h2>

            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
                <a href="{{ route('dcp.laporan.pdf') }}" class="btn btn-danger">
                    <i class="bi bi-file-earmark-pdf-fill me-1"></i> Export PDF
                </a>

                <div class="col-auto">
                    <input type="text" name="search" id="search-input" class="form-control me-1"
                        placeholder="Search data..." style="max-width: 550px; min-width: 450px;">
                </div>
            </div>

            <div class="table-responsive card shadow-sm p-3">
                <div id="table-container">
                    @include('dcp.table', ['dcpList' => $dcpList])
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        let timeout = null;

        document.getElementById('search-input').addEventListener('input', function() {
            clearTimeout(timeout);
            const keyword = this.value;

            timeout = setTimeout(() => {
                fetch(`{{ route('dcp.laporan') }}?search=${encodeURIComponent(keyword)}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => res.text())
                    .then(html => {
                        document.getElementById('table-container').innerHTML = html;
                    });
            }, 300);
        });
    </script>
@endpush
