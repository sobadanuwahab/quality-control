@extends('layouts.custom')

@section('content')
    <main class="flex-grow p-4">
        <div class="container mx-auto">

            <h2 class="mb-4 fw-bold" style="color: #367fa9">
                <i class="bi bi-clipboard-data me-2"></i> Laporan Penerimaan DCP
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
        document.addEventListener("DOMContentLoaded", function() {
            const input = document.getElementById('search-input');
            const container = document.getElementById('table-container');

            function fetchData(url) {
                fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => res.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');

                        const newTbody = doc.querySelector('tbody');
                        const newPagination = doc.querySelector('.pagination');

                        // Replace tbody
                        const currentTbody = container.querySelector('tbody');
                        if (currentTbody && newTbody) {
                            currentTbody.replaceWith(newTbody);
                        }

                        // Replace pagination
                        const currentPagination = container.querySelector('.pagination');
                        if (currentPagination && newPagination) {
                            currentPagination.replaceWith(newPagination);
                        }

                        attachPagination(); // re-attach pagination listeners
                    });
            }

            let timeout = null;

            input.addEventListener('input', function() {
                clearTimeout(timeout);
                const keyword = this.value;

                timeout = setTimeout(() => {
                    const url =
                        `{{ route('dcp.laporan') }}?search=${encodeURIComponent(keyword)}&page=1`;
                    fetchData(url);
                }, 300);
            });

            function attachPagination() {
                container.querySelectorAll('.pagination a').forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        fetchData(this.href);
                    });
                });
            }

            attachPagination(); // initial
        });
    </script>
@endpush
