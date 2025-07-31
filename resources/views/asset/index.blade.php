@extends('layouts.custom')

@section('content')
    <main class="flex-grow p-4">
        <div class="container mx-auto">
            <h2 class="fw-bold mb-4" style="color: #367fa9"><i class="bi bi-clipboard-data me-2"></i>Data Asset
            </h2>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered table-striped">
                <thead class="table-dark text-center align-middle">
                    <tr>
                        <th>No</th>
                        <th>Grouping Asset</th>
                        <th>Nama Asset</th>
                        <th>Brand / Merek</th>
                        <th>Model / Type</th>
                        <th>Penempatan</th>
                        <th>Foto</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assets as $index => $asset)
                        <tr class="text-center align-middle">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $asset->grouping_asset }}</td>
                            <td>{{ $asset->nama_asset }}</td>
                            <td>{{ $asset->brand }}</td>
                            <td>{{ $asset->model_type }}</td>
                            <td>{{ $asset->penempatan }}</td>
                            <td>
                                @if ($asset->foto)
                                    <img src="{{ asset('storage/' . ltrim($asset->foto, 'public/')) }}" alt="Foto Asset"
                                        width="80" height="auto">
                                @else
                                    <small>- Tidak ada -</small>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center align-middle">Belum ada data asset</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-3">
                {{ $assets->links() }}
            </div>
        </div>
    </main>
@endsection
