@extends('layouts.custom')

@section('content')
    <main class="flex-grow p-4">
        <div class="container mx-auto">
            <h2 class="fw-bold mb-4" style="color: #367fa9"><i class="bi bi-clipboard-data me-2"></i>Data Asset
            </h2>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="GET" action="{{ route('asset.index') }}" class="row g-3 mb-4">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Cari Nama Asset"
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <select name="grouping_asset" class="form-control">
                        <option value="">-- Semua Grouping Asset --</option>
                        @foreach ($groupingOptions as $group)
                            <option value="{{ $group }}" {{ request('grouping_asset') == $group ? 'selected' : '' }}>
                                {{ $group }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('asset.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>

            <table class="table table-bordered table-striped">
                <thead class="table-dark text-center align-middle">
                    <tr>
                        <th>No</th>
                        <th>Serial Number</th>
                        <th>Nama Asset</th>
                        <th>Brand / Merk</th>
                        <th>Model / Type</th>
                        <th>Penempatan</th>
                        <th>Picture</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assets as $index => $asset)
                        <tr class="text-center align-middle">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $asset->serial_number }}</td>
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
                {{ $assets->appends(request()->query())->links() }}
            </div>
        </div>
    </main>
@endsection
