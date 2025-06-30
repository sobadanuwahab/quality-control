<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Meteran</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #444;
            padding: 5px;
            text-align: center;
        }

        h2,
        h4 {
            margin: 0;
        }
    </style>
</head>

<body>

    <h2 style="text-align:center;">LAPORAN DATA METERAN (LISTRIK-AIR-GAS-ELPIJI)</h2>
    <h4 style="text-align:center;">{{ $nama_bioskop }}</h4>
    <p><strong>Periode:</strong> {{ $tanggal_awal }} s/d {{ $tanggal_akhir }}</p>

    @foreach ($raw_data as $nama => $rows)
        <h4 style="margin-top: 20px;">Laporan {{ $nama }}</h4>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Awal</th>
                    <th>Akhir</th>
                    <th>Pemakaian</th>
                    <th>Satuan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rows as $row)
                    @php
                        $satuan =
                            str_contains($row->nama_meteran, 'Air') || str_contains($row->nama_meteran, 'Gas')
                                ? 'm³'
                                : 'kWh';
                    @endphp
                    <tr>
                        <td>{{ $row->tanggal }}</td>
                        <td>{{ $row->awal }}</td>
                        <td>{{ $row->akhir }}</td>
                        <td>{{ $row->pemakaian }}</td>
                        <td>{{ $satuan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach

    <h4 style="margin-top: 20px;">Total Kumulatif</h4>
    <table>
        <thead>
            <tr>
                <th>Nama Meteran</th>
                <th>Total</th>
                <th>Satuan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($total_kumulatif as $nama => $total)
                @php
                    $satuan = str_contains($nama, 'Air') || str_contains($nama, 'Gas') ? 'm³' : 'kWh';
                @endphp
                <tr>
                    <td>{{ $nama }}</td>
                    <td>{{ number_format($total, 2) }}</td>
                    <td>{{ $satuan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
