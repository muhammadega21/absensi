<x-layouts.main :title="$title" :mainPage="$main_page" :page="$page">
    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mt-2">
                        <h5 class="card-title">Data Absen</h5>
                        <div class="btn-action">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#addAbsen">
                                Tambah <span class="fw-semibold">+</span>
                            </button>
                        </div>
                    </div>
                    <table id="datatable" class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Absen</th>
                                <th>tanggal</th>
                                <th>Absen Masuk</th>
                                <th>Absen Pulang</th>
                                <th>status</th>
                                <th data-sortable="false">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-nowrap">#{{ $data->id }}</td>
                                    <td class="text-nowrap">
                                        {{ Carbon\Carbon::parse($data->tanggal)->translatedFormat('d F Y') }}
                                    </td>
                                    <td class="text-nowrap">
                                        {{ Carbon\Carbon::parse($data->checkin_start)->format('H:i') }} -
                                        {{ Carbon\Carbon::parse($data->checkin_over)->format('H:i') }} WIB</td>
                                    <td class="text-nowrap">
                                        {{ Carbon\Carbon::parse($data->checkout_start)->format('H:i') }} -
                                        {{ Carbon\Carbon::parse($data->checkout_over)->format('H:i') }} WIB
                                    </td>
                                    @if ($data->status)
                                        <td class="text-nowrap"><button type="button" disabled
                                                class="btn btn-sm btn-warning" style="font-size: 12px">Tutup</button>
                                        </td>
                                    @else
                                        <form action="">
                                            <td class="text-nowrap"><button class="btn btn-sm btn-primary"
                                                    style="font-size: 12px">Buka</button>
                                            </td>
                                        </form>
                                    @endif
                                    <td class="text-nowrap">
                                        <div class="d-flex gap-1">
                                            <a href="{{ url('absen/attendace/' . $data->id) }}" target="_blank"
                                                class="badge border-primary border"><i
                                                    class='bx bx-show text-primary'></i></a>
                                            <button type="button" class="badge bg-light border-warning border"
                                                data-bs-toggle="modal" data-bs-target="#updateUnitKerja"
                                                data-unit_kerja="{{ $data }}">
                                                <span class="fw-semibold"><i
                                                        class="bx bxs-edit text-warning"></i></span>
                                            </button>
                                            <a href="{{ url('unit_kerja/delete/' . $data->id) }}"
                                                class="badge border-danger border" onclick="confirm(event)"><i
                                                    class='bx bxs-trash text-danger'></i></a>
                                            <a href="{{ url('absen/list/' . $data->id) }}"
                                                class="badge border-success border"><i
                                                    class='bx bx-list-ul text-success'></i></a>

                                        </div>
                                    </td>
                                </tr>



                                {{-- modal update --}}

                                <x-modal modalTitle="Update Unit Kerja" modalID="updateUnitKerja" btn="Update"
                                    action="" method="POST" method2="PUT">

                                    <div class="row mb-3">
                                        <div class="input-group justify-content-between">
                                            <div class="input-box col-12">
                                                <label for="name" class="col-sm-5 mb-2 required">Nama
                                                    Unit Kerja</label>
                                                <input type="text" id="name" class="form-control" name="name"
                                                    placeholder="Masukkan Nama Unit Kerja">
                                            </div>
                                        </div>
                                        <div class="input-group justify-content-between">
                                            <div class="input-box col-12">
                                                <label for="code" class="col-sm-5 mb-2 required">Kode
                                                    Unit Kerja</label>
                                                <input type="text" id="code" class="form-control" name="code"
                                                    placeholder="Masukkan Nama Kode Unit Kerja">
                                            </div>
                                        </div>
                                    </div>
                                </x-modal>

                                {{-- modal update --}}
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Add --}}
    <x-modal modalTitle="Tambah Absen" modalID="addAbsen" btn="Tambah" action="{{ url('absen') }}" method="POST"
        method2="POST">
        <div class="row mb-3">
            <div class="input-group justify-content-between">
                <div class="input-box col-sm-12">
                    <label for="tanggal" class="mb-2 required">Tanggal</label>
                    <input type="date" id="tanggal"
                        class="form-control flatpickr @error('tanggal') is-invalid @enderror" name="tanggal"
                        placeholder="Masukkan Jam Mulai" value="{{ old('tanggal', now()->format('Y-m-d')) }}">
                    @error('tanggal')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="input-group justify-content-between mt-3">
                <div class="input-box col-sm-6" style="max-width: 48%">
                    <label for="checkin_start" class="mb-2 required">Absen Masuk (Mulai)</label>
                    <input type="time" id="checkin_start"
                        class="form-control  @error('checkin_start') is-invalid @enderror" name="checkin_start"
                        placeholder="Masukkan Jam Mulai" value="{{ old('checkin_start', '08:00') }}">
                    @error('checkin_start')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="input-box col-sm-6" style="max-width: 48%">
                    <label for="checkin_over" class="mb-2 required">Absen Masuk (Berakhir)</label>
                    <input type="time" id="checkin_over"
                        class="form-control @error('checkin_over') is-invalid @enderror" name="checkin_over"
                        placeholder="Masukkan Jam Mulai" value="{{ old('checkin_over', '09:00') }}">
                    @error('checkin_over')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="input-group justify-content-between mt-3">
                <div class="input-box col-sm-6" style="max-width: 48%">
                    <label for="checkout_start" class="mb-2 required">Absen Pulang (Mulai)</label>
                    <input type="time" id="checkout_start"
                        class="form-control @error('checkout_start') is-invalid @enderror" name="checkout_start"
                        placeholder="Masukkan Jam Mulai" value="{{ old('checkout_start', '16:00') }}">
                    @error('checkout_start')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="input-box col-sm-6" style="max-width: 48%">
                    <label for="checkout_over" class="mb-2 required">Absen Pulang (Berakhir)</label>
                    <input type="time" id="checkout_over"
                        class="form-control @error('checkout_over') is-invalid @enderror" name="checkout_over"
                        placeholder="Masukkan Jam Mulai" value="{{ old('checkout_over', '17:00') }}">
                    @error('checkout_over')
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

</x-layouts.main>
