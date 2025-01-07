    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mt-2">
                        <h5 class="card-title">Data Absen</h5>
                        <div class="btn-action">
                            <button type="button" class="btn btn-primary d-flex align-items-center gap-1"
                                data-bs-toggle="modal" data-bs-target="#scanAbsen">
                                Scan <i class='bx bx-scan'></i>
                            </button>
                        </div>
                    </div>
                    <table id="datatable" class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>tanggal</th>
                                <th>Absen Masuk</th>
                                <th>Absen Pulang</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($absens as $absen)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-nowrap">
                                        {{ Carbon\Carbon::parse($absen->tanggal)->translatedFormat('d F Y') }}
                                    </td>
                                    @if ($absen->absenMasuk && $absen->absenMasuk->isNotEmpty())
                                        @if ($absen->absenMasuk->first()->status == 1)
                                            <td class="text-nowrap ">
                                                {{ Carbon\Carbon::parse($absen->absenMasuk->first()->checkin)->format('H:i') }}
                                                <span
                                                    class="{{ $absen->absenMasuk->first()->keterangan == 'Terlambat' ? 'text-warning' : 'text-success' }}"
                                                    style="font-size: 12px">({{ $absen->absenMasuk->first()->keterangan }})</span>
                                            </td>
                                        @else
                                            <td class="text-nowrap text-danger">
                                                Alfa
                                            </td>
                                        @endif
                                    @else
                                        <td class="text-nowrap text-danger">
                                            Kosong
                                        </td>
                                    @endif
                                    @if ($absen->absenPulang && $absen->absenPulang->isNotEmpty())
                                        @if ($absen->absenPulang->first()->status == 1)
                                            <td class="text-nowrap">
                                                {{ Carbon\Carbon::parse($absen->absenPulang->first()->checkout)->format('H:i') }}
                                                <span
                                                    class="{{ $absen->absenPulang->first()->keterangan == 'Terlambat' ? 'text-warning' : 'text-success' }}"
                                                    style="font-size: 12px">({{ $absen->absenPulang->first()->keterangan }})</span>
                                            </td>
                                        @else
                                            <td class="text-nowrap text-danger">
                                                Alfa
                                            </td>
                                        @endif
                                    @else
                                        <td class="text-nowrap text-danger">
                                            Kosong
                                        </td>
                                    @endif
                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <x-absen.scan-absen></x-absen.scan-absen>
