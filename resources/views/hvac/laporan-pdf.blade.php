<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Maintenance HVAC</title>
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
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #eee;
        }
    </style>
</head>

<body>
    <h2>Laporan Maintenance HVAC</h2>
    <p><strong>Bioskop : </strong>{{ $namaBioskop }}</p>
    @if ($tanggal_mulai && $tanggal_sampai)
        <p><strong>Periode : </strong>{{ $tanggal_mulai }} s.d. {{ $tanggal_sampai }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Teknisi</th>
                <th>Unit/Komponen</th>
                <th>Merk/Type</th>
                <th>Serial Number</th>
                <th>Deskripsi Pekerjaan</th>
                <th>Lokasi</th>
                <th>Tindakan</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $item->teknisi }}</td>
                    <td>{{ $item->unit_komponen }}</td>
                    <td>{{ $item->merk_type }}</td>
                    <td>{{ $item->serial_number }}</td>
                    <td>{{ $item->deskripsi_pekerjaan }}</td>
                    <td>{{ $item->lokasi_area }}</td>
                    <td>{{ $item->tindakan }}</td>
                    <td>{{ $item->keterangan }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
