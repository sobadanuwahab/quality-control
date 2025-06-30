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
        </tr>
    </thead>
    <tbody>
        @forelse($data as $index => $row)
            <tr class="text-center">
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') }}</td>
                <td>{{ $row->deskripsi }}</td>
                <td>{{ $row->jenis_perangkat }}</td>
                <td>{{ $row->type_merk }}</td>
                <td>{{ $row->studio }}</td>
                <td>{{ $row->komponen_diganti ?? '-' }}</td>
                <td>{{ $row->keterangan }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center text-danger">Belum ada data maintenance projector & sound system
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
