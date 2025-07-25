@extends('layouts.custom')

@section('content')
    <div class="container">
        <h1 class="mb-4"><strong>Dashboard Hari Ini</strong> - {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
        </h1>

        <form method="GET" action="{{ route('admin.userdata') }}" class="mb-4">
            <label for="admin_id" class="form-label">Pilih Outlet:</label>
            <select name="admin_id" id="admin_id" class="form-select" onchange="this.form.submit()">
                <option value="" disabled selected>-- Pilih Outlet --</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ request('admin_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->nama_bioskop }}
                    </option>
                @endforeach
            </select>
        </form>

        @if ($selectedUser)
            <h2>Data Log Meteran</h2>
            <table class="table table-bordered table-hover table-sm">
                <thead class="table-dark text-center">
                    <tr>
                        <th scope="col" class="text-center">Tanggal</th>
                        <th scope="col" class="text-center">Awal</th>
                        <th scope="col" class="text-center">Akhir</th>
                        <th scope="col" class="text-center">Pemakaian</th>
                        <th scope="col" class="text-center">Satuan</th>
                        @if (auth('admin')->user()->role === 'admin')
                            <th scope="col" class="text-center">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logMeteran as $row)
                        @php
                            $satuan =
                                str_contains($row->nama_meteran, 'Air') || str_contains($row->nama_meteran, 'Gas')
                                    ? 'm³/kubik'
                                    : 'kWh';
                        @endphp
                        <tr
                            class="
                                    @if (str_contains($row->nama_meteran, 'Air')) table-info
                                    @elseif(str_contains($row->nama_meteran, 'Gas')) table-warning
                                    @else table-success @endif
                                ">
                            <td class="text-center">{{ $row->tanggal }}</td>
                            <td class="text-center">{{ $row->awal }}</td>
                            <td class="text-center">{{ $row->akhir }}</td>
                            <td class="text-center">{{ $row->pemakaian }}</td>
                            <td class="text-center">{{ $satuan }}</td>
                            @if (auth('admin')->user()->role === 'admin')
                                <td class="text-center">
                                    <a href="{{ route('meteran.edit', $row->id) }}" class="btn btn-sm btn-warning me-1">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('meteran.destroy', $row->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth('admin')->user()->role === 'admin' ? 6 : 5 }}"
                                class="text-center text-danger">
                                Belum ada data log meteran
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <h2>Data DCP</h2>
            <table class="table table-bordered table-hover align-middle small">
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
                    @forelse($dcpReports as $dcp)
                        @php
                            $details = is_string($dcp->film_details)
                                ? json_decode($dcp->film_details, true)
                                : $dcp->film_details;
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

            <h2>Data Onesheet</h2>
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
                    @forelse($onesheetReports as $index => $item)
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

            <h2>Data Maintenance Projector</h2>
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
                    @forelse($projectorReports as $index => $row)
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
                            <td colspan="8" class="text-center text-danger">Belum ada data maintenance projector & sound
                                system
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <h2>Data Maintenance HVAC</h2>
            <table class="table table-bordered table-hover align-middle small">
                <thead class="table-dark text-center align-middle">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Teknisi</th>
                        <th>Unit/Komponen</th>
                        <th>Merk/Type</th>
                        <th>Lokasi</th>
                        <th>Tindakan</th>
                        <th>Keterangan</th>
                        @if (auth()->user()->username !== 'TGRSERO')
                            <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($hvacReports as $index => $row)
                        <tr class="text-center">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') }}</td>
                            <td>{{ $row->teknisi }}</td>
                            <td>{{ $row->unit_komponen }}</td>
                            <td>{{ $row->merk_type }}</td>
                            <td>{{ $row->lokasi_area }}</td>
                            <td>{{ $row->tindakan }}</td>
                            <td>{{ $row->keterangan }}</td>
                            @if (auth()->user()->username !== 'TGRSERO')
                                <td class="text-center">
                                    @if ($row->is_done)
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i> Done
                                        </span>
                                    @elseif (auth()->user()->role === 'admin')
                                        <form method="POST" action="{{ route('maintenance.hvac.done', $row->id) }}"
                                            onsubmit="return confirm('Tandai data ini sebagai selesai?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                style="padding: 4px 8px; font-size: 0.7rem;">
                                                <i class="bi bi-check-circle me-1"></i> Action
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            @endif

                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-danger">Belum ada data maintenance HVAC</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @endif
    </div>
@endsection
