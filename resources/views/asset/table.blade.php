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
                <td>{{ ($assets->currentPage() - 1) * $assets->perPage() + $index + 1 }}</td>
                <td>{{ $asset->serial_number }}</td>
                <td>{{ $asset->nama_asset }}</td>
                <td>{{ $asset->brand }}</td>
                <td>{{ $asset->model_type }}</td>
                <td>{{ $asset->penempatan }}</td>
                <td>
                    @if ($asset->foto)
                        <img src="{{ asset('storage/' . ltrim($asset->foto, 'public/')) }}" alt="Foto Asset" width="80"
                            height="auto">
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
    {{ $assets->links('pagination::bootstrap-5') }}
</div>
