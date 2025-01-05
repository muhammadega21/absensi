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
                            @forelse ($absens as $key => $absen)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td class="text-nowrap">
                                        {{ Carbon\Carbon::parse($absen->tanggal)->translatedFormat('d F Y') }}
                                    </td>
                                    @if ($absen->absenMasuk)
                                        <td class="text-nowrap ">
                                            {{ Carbon\Carbon::parse($absen->absenMasuk->checkin)->format('H:i') }}
                                            <span
                                                class="{{ $absen->absenMasuk->keterangan == 'Terlambat' ? 'text-warning' : '' }}"
                                                style="font-size: 12px">({{ $absen->absenMasuk->keterangan }})</span>
                                        </td>
                                    @else
                                        <td class="text-nowrap text-danger">
                                            Kosong
                                    @endif
                                    </td>
                                    <td class="text-nowrap">
                                        @if ($absen->absenPulang)
                                            {{ Carbon\Carbon::parse($absen->absenPulang->checkout)->format('H:i') }}
                                            <span
                                                class="{{ $absen->absenPulang->keterangan == 'Terlambat' ? 'text-warning' : '' }}"
                                                style="font-size: 12px">({{ $absen->absenPulang->keterangan }})</span>
                                        @else
                                            Kosong
                                        @endif
                                    </td>
                                </tr>
                            @empty
                            @endforelse


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <x-absen.scan-absen></x-absen.scan-absen>
