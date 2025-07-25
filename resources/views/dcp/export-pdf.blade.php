<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Penerimaan DCP</title>
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
            border: 1px solid #000000;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #367fa9;
        }

        h2 {
            margin-bottom: 0;
        }
    </style>
</head>

<body>
    <h2>LAPORAN DATA FILE FILM</h2>
    <p><strong>Bioskop:</strong> {{ $namaBioskop }}</p>
    <p><strong>Tanggal:</strong> {{ $tanggal }}</p>

    <table>
        <thead>
            <tr>
                <th style="text-align: center; color: white;">No</th>
                <th style="text-align: center; color: white;">Judul Film</th>
                <th style="text-align: center; color: white;">Aspect Ratio</th>
                <th style="text-align: center; color: white;">Format Sound</th>
                <th style="text-align: center; color: white;">Status KDM</th>
                <th style="text-align: center; color: white;">Lokasi Penyimpanan</th>
                <th style="text-align: center; color: white;">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($dcpList as $dcp)
                @php
                    $films = is_string($dcp->film_details) ? json_decode($dcp->film_details, true) : $dcp->film_details;
                @endphp
                @foreach ($films as $film)
                    @php
                        $keterangan = strtolower($film['keterangan'] ?? '');
                        $colorStyle = '';

                        if ($keterangan === 'sedang tayang') {
                            $colorStyle = 'color:green; font-weight:bold;';
                        } elseif ($keterangan === 'sudah tayang') {
                            $colorStyle = 'color:red; font-weight:bold;';
                        }
                    @endphp
                    <tr>
                        <td style="text-align: center; {{ $colorStyle }}">{{ $no++ }}</td>
                        <td style="text-align: center; {{ $colorStyle }}">{{ $film['judulFilm'] ?? '-' }}</td>
                        <td style="text-align: center; {{ $colorStyle }}">{{ $film['formatFilm'] ?? '-' }}</td>
                        <td style="text-align: center; {{ $colorStyle }}">{{ $film['sound'] ?? '-' }}</td>
                        <td style="text-align: center; {{ $colorStyle }}">{{ $film['statusKdm'] ?? '-' }}</td>
                        <td style="text-align: center; {{ $colorStyle }}">{{ $film['lokasiPenyimpanan'] ?? '-' }}
                        </td>
                        <td style="text-align: center; {{ $colorStyle }}">{{ $film['keterangan'] ?? '-' }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>

</html>
