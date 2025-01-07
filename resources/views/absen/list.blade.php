<x-layouts.main :title="$title" :mainPage="$main_page" :page="$page">
    @can('admin')
        <div class="row">
            <div class="col-lg">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mt-2">
                            <h5 class="card-title">List Absen</h5>
                            <div class="btn-action">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addListAbsen">
                                    Tambah <span class="fw-semibold">+</span>
                                </button>
                            </div>
                        </div>
                        <table id="datatable" class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>tanggal</th>
                                    <th>Absen Masuk</th>
                                    <th>Absen Pulang</th>
                                    <th data-sortable="false">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                    @php
                                        $tanggal = $data->first()->tanggal;
                                        $absenID = $data->id;
                                    @endphp
                                    @if ($data->absenMasuk)
                                        @foreach ($data->absenMasuk as $masuk)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>#{{ $masuk->user->nip }}</td>
                                                <td>{{ $masuk->user->name }}</td>
                                                <td>{{ Carbon\Carbon::parse($data->tanggal)->translatedFormat('d F Y') }}
                                                </td>
                                                @php
                                                    $pulang = $data->absenPulang
                                                        ->where('user_id', $masuk->user_id)
                                                        ->first();
                                                @endphp
                                                @if ($masuk)
                                                    @if ($masuk->status == 1)
                                                        @if ($masuk->checkin)
                                                            <td>{{ Carbon\Carbon::parse($masuk->checkin)->format('H:i') }}
                                                                <span
                                                                    class="{{ $masuk->keterangan == 'Terlambat' ? 'text-warning' : ($masuk->status == 0 ? 'text-danger' : 'text-success') }}"
                                                                    style="font-size: 12px">({{ $masuk->keterangan }})</span>
                                                            </td>
                                                        @else
                                                            <td class="text-nowrap text-danger">Kosong</td>
                                                        @endif
                                                    @else
                                                        <td class="text-nowrap text-danger">Alfa</td>
                                                    @endif
                                                @else
                                                    <td class="text-nowrap text-danger">Kosong</td>
                                                @endif
                                                @if ($pulang)
                                                    @if ($pulang->status == 1)
                                                        @if ($pulang->checkout)
                                                            <td>
                                                                {{ Carbon\Carbon::parse($pulang->checkout)->format('H:i') }}
                                                                <span
                                                                    class=" {{ $pulang->keterangan == 'Terlambat' ? 'text-warning' : ($pulang->status == 0 ? 'text-danger' : 'text-success') }}"
                                                                    style="font-size: 12px">({{ $pulang->keterangan }})</span>
                                                            </td>
                                                        @else
                                                            <td class="text-nowrap text-danger">Kosong</td>
                                                        @endif
                                                    @else
                                                        <td class="text-nowrap text-danger">Alfa</td>
                                                    @endif
                                                @else
                                                    <td class="text-nowrap text-danger">Kosong</td>
                                                @endif
                                                <td class="text-nowrap">
                                                    <div class="d-flex gap-1">
                                                        <a href="{{ url('absen/delete/' . $masuk->absen->id) }}"
                                                            class="badge border-danger border" onclick="confirm(event)"><i
                                                                class='bx bxs-trash text-danger'></i></a>
                                                        <button type="button" class="badge bg-light border-warning border"
                                                            data-bs-toggle="modal" data-bs-target="#updateUserAbsen"
                                                            data-userAbsen="{{ $masuk }}">
                                                            <span class="fw-semibold"><i
                                                                    class="bx bxs-edit text-warning"></i></span>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        @foreach ($data->absenPulang as $pulang)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>#{{ $pulang->user->nip }}</td>
                                                <td>{{ $pulang->user->name }}</td>
                                                <td>{{ Carbon\Carbon::parse($data->tanggal)->translatedFormat('d F Y') }}
                                                </td>
                                                @php
                                                    $masuk = $data->absenMasuk
                                                        ->where('user_id', $pulang->user_id)
                                                        ->first();
                                                @endphp
                                                @if ($masuk)
                                                    @if ($masuk->status == 1)
                                                        @if ($masuk->checkin)
                                                            <td>
                                                                {{ Carbon\Carbon::parse($masuk->checkin)->format('H:i') }}
                                                                <span
                                                                    class="{{ $masuk->keterangan == 'Terlambat' ? 'text-warning' : 'text-success' }}"
                                                                    style="font-size: 12px">({{ $masuk->keterangan }})</span>
                                                            </td>
                                                        @else
                                                            <td class="text-nowrap text-danger">Kosong</td>
                                                        @endif
                                                    @else
                                                        <td class="text-nowrap text-danger">Alfa</td>
                                                    @endif
                                                @else
                                                    <td class="text-nowrap text-danger">Kosong</td>
                                                @endif
                                                @if ($pulang)
                                                    @if ($pulang->status == 1)
                                                        @if ($pulang->checkout)
                                                            <td>{{ Carbon\Carbon::parse($pulang->checkout)->format('H:i') }}
                                                                <span
                                                                    class="{{ $pulang->keterangan == 'Terlambat' ? 'text-warning' : 'text-success' }}"
                                                                    style="font-size: 12px">({{ $pulang->keterangan }})</span>
                                                            </td>
                                                        @else
                                                            <td class="text-nowrap text-danger">Kosong</td>
                                                        @endif
                                                    @else
                                                        <td class="text-nowrap text-danger">Alfa</td>
                                                    @endif
                                                @else
                                                    <td class="text-nowrap text-danger">Kosong</td>
                                                @endif
                                                <td class="text-nowrap">
                                                    <div class="d-flex gap-1">
                                                        <a href="{{ url('absen/delete/' . $pulang->absen->id) }}"
                                                            class="badge border-danger border" onclick="confirm(event)"><i
                                                                class='bx bxs-trash text-danger'></i></a>
                                                        <button type="button" class="badge bg-light border-warning border"
                                                            data-bs-toggle="modal" data-bs-target="#updateUserAbsen"
                                                            data-userAbsen="{{ $pulang }}">
                                                            <span class="fw-semibold"><i
                                                                    class="bx bxs-edit text-warning"></i></span>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Add --}}
        <x-modal modalTitle="Tambah Absen Karyawan" modalID="addListAbsen" btn="Tambah"
            action="{{ url('absen/addListAbsen/' . $absenID) }}" method="POST" method2="POST">
            <div class="row mb-3">
                <div class="input-group justify-content-between">
                    <div class="input-box col-sm-12">
                        <label for="user_id" class="mb-2 required">Karyawan</label>
                        <select id="user_id" name="user_id" class="form-control select2" data-parent="addListAbsen">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->nip }} - {{ $user->name }}</option>
                            @endforeach
                        </select>

                    </div>
                </div>
                <div class="input-group justify-content-between mt-3">
                    <div class="input-box col-sm-6" style="max-width: 48%">
                        <label for="tanggal" class="mb-2 required">Tanggal</label>
                        <input type="date" id="tanggal" class="form-control" name="tanggal"
                            value="{{ $tanggal }}" disabled>
                    </div>
                    <div class="input-box col-sm-6" style="max-width: 48%">
                        <label for="keterangan" class="mb-2 required">Keterangan</label>
                        <select id="role" name="role" class="form-select">
                            @php
                                $roles = ['Hadir', 'Terlambat', 'Izin'];
                            @endphp
                            @foreach ($roles as $item)
                                <option value="{{ $item }}" {{ old('role') == $item ? 'selected' : '' }}>
                                    {{ $item }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="input-group justify-content-between mt-3">
                    <div class="input-box col-sm-6" style="max-width: 48%">
                        <label for="checkin" class="mb-2 required">Jam Masuk (Checkin)</label>
                        <input type="time" id="checkin" class="form-control  @error('checkin') is-invalid @enderror"
                            name="checkin" placeholder="Masukkan Jam Masuk" value="{{ old('checkin') }}">
                        @error('checkin')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="input-box col-sm-6" style="max-width: 48%">
                        <label for="checkout" class="mb-2 required">Jam Pulang (Checkout)</label>
                        <input type="time" id="checkout" class="form-control @error('checkout') is-invalid @enderror"
                            name="checkout" placeholder="Masukkan Jam Pulang" value="{{ old('checkout') }}">
                        @error('checkout')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
        </x-modal>
        {{-- Modal Add --}}

        {{-- Modal Error --}}
        @if (session('addAbsen'))
            <script>
                toastr.error("{{ Session::get('addAbsen') }}");
                $(document).ready(function() {
                    $('#addAbsen').modal('show');
                });
            </script>
        @endif


        @if (session('updateAbsen'))
            <script>
                swal("Error!", "{{ Session::get('updateAbsen') }}", "error"), {
                    button: true,
                    button: 'ok'
                }
                @foreach ($errors->all() as $error)
                    toastr.error("{{ $error }}");
                @endforeach
            </script>
        @endif

        {{-- Alert --}}
        @if (Session::has('success'))
            <script>
                swal("Success!", "{{ Session::get('success') }}", "success"), {
                    button: true,
                    button: 'ok'
                }
            </script>
        @elseif (Session::has('error'))
            <script>
                swal("Error!", "{{ Session::get('error') }}", "error"), {
                    button: true,
                    button: 'ok'
                }
            </script>
        @endif

    @endcan
</x-layouts.main>
