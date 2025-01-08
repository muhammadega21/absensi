<div class="modal fade modal-xl" id="selfabsent" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Self-absent</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="datatable" class="table table-bordered table-responsive">
                    <thead style="100% !important">
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
                                                class="{{ $absen->absenMasuk->first()->keterangan == 'Terlambat' || $absen->absenMasuk->first()->keterangan == 'Izin' ? 'text-warning' : 'text-success' }}"
                                                style="font-size: 12px">({{ $absen->absenMasuk->first()->keterangan }})</span>
                                        </td>
                                    @else
                                        <td class="text-nowrap text-danger">
                                            Alfa
                                        </td>
                                    @endif
                                @else
                                    <td class="text-nowrap text-secondary">
                                        Kosong
                                    </td>
                                @endif
                                @if ($absen->absenPulang && $absen->absenPulang->isNotEmpty())
                                    @if ($absen->absenPulang->first()->status == 1)
                                        <td class="text-nowrap">
                                            {{ Carbon\Carbon::parse($absen->absenPulang->first()->checkout)->format('H:i') }}
                                            <span
                                                class="{{ $absen->absenPulang->first()->keterangan == 'Terlambat' || $absen->absenPulang->first()->keterangan == 'Izin' ? 'text-warning' : 'text-success' }}"
                                                style="font-size: 12px">({{ $absen->absenPulang->first()->keterangan }})</span>
                                        </td>
                                    @else
                                        <td class="text-nowrap text-danger">
                                            Alfa
                                        </td>
                                    @endif
                                @else
                                    <td class="text-nowrap text-secondary">
                                        Kosong
                                    </td>
                                @endif
                            </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
