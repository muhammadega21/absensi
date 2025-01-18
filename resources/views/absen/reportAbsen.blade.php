<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Absen</title>
    <style>
        * {
            margin: 0;
            padding: 0
        }

        body {
            font-family: Arial, sans-serif;
            padding: 1rem
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .title {
            display: flex;
            flex-direction: column;
            text-align: center;
        }

        .admin {
            width: 100%;
            min-width: 200px;
            max-width: 300px;
            margin-left: auto;
        }

        .admin {
            text-align: center
        }

        .admin-ttd {
            margin: 4rem 0;
            display: flex;
            flex-direction: column;
        }
    </style>
</head>

<body>
    <div class="title">
        <h2>Laporan Absen Karyawan</h2>
        <h4 style="font-weight: 400">{{ $date }}</h4>
    </div>
    <table id="datatable" class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>No</th>
                <th>NIP</th>
                <th>Nama</th>
                <th>tanggal</th>
                <th>Absen Masuk</th>
                <th>Absen Pulang</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $data)
                @php
                    $tanggal = $data->first()->tanggal;
                    $absenID = $data->id;
                @endphp
                @if ($data->absenMasuk->isNotEmpty())
                    @foreach ($data->absenMasuk as $masuk)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>#{{ $masuk->user->nip }}</td>
                            <td>{{ $masuk->user->name }}</td>
                            <td>{{ Carbon\Carbon::parse($data->tanggal)->translatedFormat('d F Y') }}
                            </td>
                            @php
                                $pulang = $data->absenPulang->where('user_id', $masuk->user_id)->first();
                            @endphp
                            @if ($masuk)
                                @if ($masuk->status == 1)
                                    @if ($masuk->checkin)
                                        <td>{{ Carbon\Carbon::parse($masuk->checkin)->format('H:i') }}
                                            <span
                                                class="{{ $masuk->keterangan == 'Terlambat' || $masuk->keterangan == 'Izin' ? 'text-warning' : ($masuk->status == 0 ? 'text-danger' : 'text-success') }}"
                                                style="font-size: 12px">({{ $masuk->keterangan }})</span>
                                        </td>
                                    @else
                                        <td class="text-nowrap text-secondary">Kosong</td>
                                    @endif
                                @else
                                    <td class="text-nowrap text-danger">Alfa</td>
                                @endif
                            @else
                                <td class="text-nowrap text-secondary">Kosong</td>
                            @endif
                            @if ($pulang)
                                @if ($pulang->status == 1)
                                    @if ($pulang->checkout)
                                        <td>
                                            {{ Carbon\Carbon::parse($pulang->checkout)->format('H:i') }}
                                            <span
                                                class=" {{ $pulang->keterangan == 'Terlambat' || $pulang->keterangan == 'Izin' ? 'text-warning' : ($pulang->status == 0 ? 'text-danger' : 'text-success') }}"
                                                style="font-size: 12px">({{ $pulang->keterangan }})</span>
                                        </td>
                                    @else
                                        <td class="text-nowrap text-secondary">Kosong</td>
                                    @endif
                                @else
                                    <td class="text-nowrap text-danger">Alfa</td>
                                @endif
                            @else
                                <td class="text-nowrap text-secondary">Kosong</td>
                            @endif
                        </tr>
                    @endforeach
                @elseif ($data->absenPulang)
                    @foreach ($data->absenPulang as $pulang)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>#{{ $pulang->user->nip }}</td>
                            <td>{{ $pulang->user->name }}</td>
                            <td>{{ Carbon\Carbon::parse($data->tanggal)->translatedFormat('d F Y') }}
                            </td>
                            @php
                                $masuk = $data->absenMasuk->where('user_id', $pulang->user_id)->first();
                            @endphp
                            @if ($masuk)
                                @if ($masuk->status == 1)
                                    @if ($masuk->checkin)
                                        <td>
                                            {{ Carbon\Carbon::parse($masuk->checkin)->format('H:i') }}
                                            <span
                                                class="{{ $masuk->keterangan == 'Terlambat' || $masuk->keterangan == 'Izin' ? 'text-warning' : 'text-success' }}"
                                                style="font-size: 12px">({{ $masuk->keterangan }})</span>
                                        </td>
                                    @else
                                        <td class="text-nowrap text-secondary">Kosong</td>
                                    @endif
                                @else
                                    <td class="text-nowrap text-danger">Alfa</td>
                                @endif
                            @else
                                <td class="text-nowrap text-secondary">Kosong</td>
                            @endif
                            @if ($pulang)
                                @if ($pulang->status == 1)
                                    @if ($pulang->checkout)
                                        <td>{{ Carbon\Carbon::parse($pulang->checkout)->format('H:i') }}
                                            <span
                                                class="{{ $pulang->keterangan == 'Terlambat' || $pulang->keterangan == 'Izin' ? 'text-warning' : 'text-success' }}"
                                                style="font-size: 12px">({{ $pulang->keterangan }})</span>
                                        </td>
                                    @else
                                        <td class="text-nowrap text-secondary">Kosong</td>
                                    @endif
                                @else
                                    <td class="text-nowrap text-danger">Alfa</td>
                                @endif
                            @else
                                <td class="text-nowrap text-secondary">Kosong</td>
                            @endif
                        </tr>
                    @endforeach
                @endif
            @endforeach

        </tbody>
    </table>
    <div class="admin-wrapper">
        <div class="admin">
            <strong class="">Mengetahui</strong>
            <div class="admin-ttd">
                <span>({{ $admin }})</span>
                <span>Admin</span>
            </div>
        </div>
    </div>

</body>

</html>
