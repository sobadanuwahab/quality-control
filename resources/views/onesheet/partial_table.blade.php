<table class="table table-bordered table-hover align-middle small">
    <thead class="table-dark text-white text-center align-middle">
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Penerima</th>
            <th>Pengirim</th>
            <th>Judul Film</th>
            <th>Jumlah</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @forelse($onesheets as $index => $item)
            <tr class="text-center">
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                <td>{{ $item->penerima }}</td>
                <td>{{ $item->pengirim }}</td>
                <td>{{ $item->judul_film }}</td>
                <td>{{ $item->jumlah }}</td>
                <td>{{ $item->keterangan }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center text-danger">Belum ada data Onesheet/Poster</td>
            </tr>
        @endforelse
    </tbody>
</table>
