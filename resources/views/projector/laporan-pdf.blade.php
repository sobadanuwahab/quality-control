<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Maintenance Projector & Sound System</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h2>Laporan Maintenance Projector & Sound System</h2>
    <p><strong>Bioskop : </strong>{{ $namaBioskop }}</p>
    @if ($tanggal_mulai && $tanggal_sampai)
        <p><strong>Periode : </strong>{{ $tanggal_mulai }} s.d. {{ $tanggal_sampai }}</p>
    @endif

    @php
        $studioList = $data->pluck('studio')->unique()->filter()->values();
    @endphp

    @if ($studioList->count())
        <p><strong>Lokasi : </strong>{{ $studioList->implode(', ') }}</p>
    @endif


    <table>
        <thead style="background-color: #007bff; color: white;">
            <tr>
                <th style="width: 3%; text-align: center; vertical-align: middle;">No</th>
                <th style="width: 8%; text-align: center; vertical-align: middle;">Tanggal</th>
                <th style="text-align: center; vertical-align: middle;">Deskripsi</th>
                <th style="text-align: center; vertical-align: middle;">Jenis Perangkat</th>
                <th style="text-align: center; vertical-align: middle;">Type/Merk</th>
                <th style="text-align: center; vertical-align: middle;">Studio</th>
                <th style="text-align: center; vertical-align: middle;">Unit Part Yang Diganti</th>
                <th style="width: 5%; font-size: 10px; text-align: center; vertical-align: middle;">Paraf Teknisi</th>
                <th style="width: 5%; font-size: 10px; text-align: center; vertical-align: middle;">Paraf Chiko/Team
                    Lead</th>
                <th style="width: 5%; font-size: 10px; text-align: center; vertical-align: middle;">Paraf Manager</th>
                <th style="width: 20%; text-align: center; vertical-align: middle;">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $i => $item)
                <tr>
                    <td style="text-align: center; vertical-align: middle;">{{ $i + 1 }}</td>
                    <td style="text-align: center; vertical-align: middle;">
                        {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                    <td style="text-align: center; vertical-align: middle;">{{ $item->deskripsi }}</td>
                    <td style="text-align: center; vertical-align: middle;">{{ $item->jenis_perangkat }}</td>
                    <td style="text-align: center; vertical-align: middle;">{{ $item->type_merk }}</td>
                    <td style="text-align: center; vertical-align: middle;" width="12%">{{ $item->studio }}</td>
                    <td style="text-align: center; vertical-align: middle;">{{ $item->komponen_diganti ?? '-' }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{ $item->keterangan }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="11" style="text-align: center;">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
