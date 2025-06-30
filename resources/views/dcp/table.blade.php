<table class="table table-bordered table-hover align-middle">
    <thead class="table-dark text-center align-middle">
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Penerima</th>
            <th>Pengirim</th>
            <th>Judul Film</th>
            <th>Aspect Ratio</th>
            <th>Format Sound</th>
            <th>Status KDM</th>
            <th>Lokasi Penyimpanan</th>
            <th>Keterangan</th>
            @if (auth()->user()?->role === 'admin')
                <th>Aksi</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @php $nomor = 1; @endphp
        @forelse($dcpList as $dcp)
            @php
                $details = is_string($dcp->film_details) ? json_decode($dcp->film_details, true) : $dcp->film_details;
            @endphp
            @foreach ($details as $film)
                @php
                    $keterangan = strtolower($film['keterangan'] ?? '');
                    $textClass = '';

                    if ($keterangan === 'sedang tayang') {
                        $textClass = 'text-success fw-semibold';
                    } elseif ($keterangan === 'sudah tayang') {
                        $textClass = 'text-danger fw-semibold';
                    }
                @endphp
                <tr class="text-center">
                    <td class="{{ $textClass }}">{{ $nomor++ }}</td>
                    <td class="{{ $textClass }}">
                        {{ \Carbon\Carbon::parse($dcp->tanggal_penerimaan)->format('d M Y') }}</td>
                    <td class="{{ $textClass }}">{{ $dcp->nama_penerima }}</td>
                    <td class="{{ $textClass }}">{{ $dcp->pengirim }}</td>
                    <td class="{{ $textClass }}">{{ $film['judulFilm'] ?? '-' }}</td>
                    <td class="{{ $textClass }}">{{ $film['formatFilm'] ?? '-' }}</td>
                    <td class="{{ $textClass }}">{{ $film['sound'] ?? '-' }}</td>
                    <td class="{{ $textClass }}">{{ $film['statusKdm'] ?? '-' }}</td>
                    <td class="{{ $textClass }}">{{ $film['lokasiPenyimpanan'] ?? '-' }}</td>
                    <td
                        class="
                        @if (isset($film['keterangan'])) @if (strtolower($film['keterangan']) === 'sudah tayang') text-danger fw-bold
                            @elseif(strtolower($film['keterangan']) === 'sedang tayang') text-success fw-semibold @endif
                        @endif
                    ">
                        {{ $film['keterangan'] ?? '-' }}
                    </td>
                    @if (auth()->check() && auth()->user()->role === 'admin')
                        <td>
                            <a href="{{ route('dcp.edit', $dcp->id) }}" class="btn btn-sm btn-warning me-1">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('dcp.destroy', $dcp->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    @endif
                </tr>
            @endforeach
        @empty
            <tr>
                <td colspan="11" class="text-center text-danger">Belum ada data DCP</td>
            </tr>
        @endforelse
    </tbody>
</table>
