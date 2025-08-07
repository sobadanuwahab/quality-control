<table class="table table-bordered table-hover align-middle small">
    <thead class="table-dark text-center align-middle">
        <tr>
            <th>No</th>
            <th style="width: 8%;">Tanggal</th>
            <th>Deskripsi</th>
            <th>Jenis Perangkat</th>
            <th style="width: 12%;">Type/Merk</th>
            <th style="width: 12%;">Studio</th>
            <th>Barang/Komponen Diganti</th>
            <th>Keterangan</th>
            @auth
                @if (auth()->user()->role === 'admin')
                    <th>Aksi</th>
                @endif
            @endauth
        </tr>
    </thead>
    <tbody>
        @forelse($data as $index => $row)
            <tr class="text-center">
                <td>{{ $data->firstItem() + $index }}</td>
                <td>{{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') }}</td>
                <td>{{ $row->deskripsi }}</td>
                <td>{{ $row->jenis_perangkat }}</td>
                <td>{{ $row->type_merk }}</td>
                <td>{{ $row->studio }}</td>
                <td>{{ $row->komponen_diganti ?? '-' }}</td>
                <td>{{ $row->keterangan }}</td>
                @auth
                    @if (auth()->user()->role === 'admin')
                        <td>
                            <a href="{{ route('maintenance.projector.edit', $row->id) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>

                            <form action="{{ route('maintenance.projector.destroy', $row->id) }}" method="POST"
                                class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Hapus</button>
                            </form>
                        </td>
                    @endif
                @endauth
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center text-danger">Belum ada data maintenance projector & sound system
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
<div class="mt-3">
    {{ $data->links('pagination::bootstrap-5') }}
</div>
