<x-layouts.main :title="$title" :mainPage="$main_page" :page="$page">
    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mt-2">
                        <h5 class="card-title">Data Karyawan</h5>
                        <div class="btn-action">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#addKaryawan">
                                Tambah <span class="fw-semibold">+</span>
                            </button>
                        </div>
                    </div>

                    <table id="datatable" class="table w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Unit Kerja</th>
                                <th>Role</th>
                                <th data-sortable="false">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-nowrap">{{ $data->nip }}</td>
                                    <td class="">{{ $data->name }}</td>
                                    <td class="text-nowrap">{{ $data->unitKerja->name }}</td>
                                    <td class="text-nowrap">{{ $data->role }}</td>
                                    <td class="text-nowrap">
                                        <div class="d-flex gap-1">
                                            <button type="button" class="badge bg-light border-primary border"
                                                data-bs-toggle="modal" data-bs-target="#idcard"
                                                data-karyawan="{{ $data }}"><i
                                                    class='bx bx-show text-primary'></i></button>
                                            <a href="{{ url('karyawan/delete/' . $data->id) }}"
                                                class="badge border-danger border" onclick="confirm(event)"><i
                                                    class='bx bxs-trash text-danger'></i></a>
                                            <button type="button" class="badge bg-light border-warning border"
                                                data-bs-toggle="modal" data-bs-target="#updateKaryawan"
                                                data-karyawan="{{ $data }}">
                                                <span class="fw-semibold"><i
                                                        class="bx bxs-edit text-warning"></i></span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>



                                {{-- modal update --}}

                                <x-modal modalTitle="Update Karyawan" modalID="updateKaryawan" btn="Update"
                                    action="" method="POST" method2="PUT" enctype="multipart/form-data">

                                    <div class="row mb-3">
                                        <div class="input-group justify-content-between">
                                            <div class="input-box col-sm-6" style="max-width: 48%">
                                                <label for="name" class="mb-2 required">Nama</label>
                                                <input type="text" id="name" class="form-control" name="name"
                                                    placeholder="Masukkan Nama" value="{{ old('name') }}">
                                            </div>
                                            <div class="input-box col-sm-6" style="max-width: 48%">
                                                <label for="username" class="mb-2 required">Nama Panggilan</label>
                                                <input type="text" id="username" class="form-control"
                                                    name="username" placeholder="Masukkan Nama Panggilan Karyawan"
                                                    value="{{ old('username') }}">
                                            </div>
                                        </div>
                                        <div class="input-group justify-content-between mt-3">
                                            <div class="input-box col-sm-6" style="max-width: 48%">
                                                <label for="password" class="mb-2 required">New Password</label>
                                                <input type="text" id="password" class="form-control"
                                                    name="password" placeholder="Masukkan Password"
                                                    value="{{ old('password') }}">
                                            </div>
                                            <div class="input-box col-sm-6" style="max-width: 48%">
                                                <label for="tanggal_lahir" class="mb-2 required ">Tanggal Lahir</label>
                                                <input type="date" id="tanggal_lahir" class="form-control flatpickr"
                                                    name="tanggal_lahir" placeholder="Masukkan Tanggal Lahir"
                                                    value="{{ old('tanggal_lahir') }}">
                                            </div>
                                        </div>
                                        <div class="input-group justify-content-between mt-3">
                                            <div class="input-box col-sm-6" style="max-width: 48%">
                                                <label for="unit_kerja_id" class="mb-2 required">Unit Kerja</label>
                                                <select id="unit_kerja_id" name="unit_kerja_id" class="form-select">
                                                    @foreach ($unit_kerja as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ old('unit_kerja_id', $data->unitKerja->id) == $item->id ? 'selected' : '' }}>
                                                            {{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="input-box col-sm-6" style="max-width: 48%">
                                                <label for="role" class="mb-2 required">Role</label>
                                                <select id="role" name="role" class="form-select">
                                                    @php
                                                        $roles = ['admin', 'karyawan'];
                                                    @endphp
                                                    @foreach ($roles as $item)
                                                        <option value="{{ $item }}"
                                                            {{ old('role', $data->role) == $item ? 'selected' : '' }}>
                                                            {{ $item }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="input-group justify-content-between mt-3">
                                            <div class="input-box col-12">
                                                <label for="image" class="mb-2 required">Photo Profile</label>
                                                <input type="file" name="image" id="image"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </x-modal>

                                {{-- modal update --}}

                                {{-- Modal Idcard --}}
                                <x-idcard></x-idcard>
                                {{-- Modal Idcard --}}
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Add --}}
    <x-modal modalTitle="Tambah Karyawan" modalID="addKaryawan" btn="Tambah" action="{{ url('karyawan') }}"
        method="POST" method2="POST" enctype="multipart/form-data">
        <div class="row mb-3">
            <div class="input-group justify-content-between">
                <div class="input-box col-sm-6" style="max-width: 48%">
                    <label for="name" class="mb-2 required">Nama</label>
                    <input type="text" id="name" class="form-control @error('name') is-invalid @enderror"
                        name="name" placeholder="Masukkan Nama" value="{{ old('name') }}">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="input-box col-sm-6" style="max-width: 48%">
                    <label for="username" class="mb-2 required">Nama Panggilan</label>
                    <input type="text" id="username" class="form-control @error('username') is-invalid @enderror"
                        name="username" placeholder="Masukkan Nama Panggilan Karyawan"
                        value="{{ old('username') }}">
                    @error('username')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="input-group justify-content-between mt-3">
                <div class="input-box col-sm-6" style="max-width: 48%">
                    <label for="password" class="mb-2 required">Password</label>
                    <input type="text" id="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" placeholder="Masukkan Password"
                        value="{{ rand(1000, 9999), old('password') }}">
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="input-box col-sm-6" style="max-width: 48%">
                    <label for="tanggal_lahir" class="mb-2 required">Tanggal Lahir</label>
                    <input type="date" id="tanggal_lahir"
                        class="form-control flatpickr @error('tanggal_lahir') is-invalid @enderror"
                        name="tanggal_lahir" placeholder="Masukkan Tanggal Lahir"
                        value="{{ old('tanggal_lahir') }}">
                    @error('tanggal_lahir')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="input-group justify-content-between mt-3">
                <div class="input-box col-sm-6" style="max-width: 48%">
                    <label for="unit_kerja_id" class="mb-2 required">Unit Kerja</label>
                    <select id="unit_kerja_id" name="unit_kerja_id" class="form-select">
                        @foreach ($unit_kerja as $item)
                            <option value="{{ $item->id }}"
                                {{ old('unit_kerja_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-box col-sm-6" style="max-width: 48%">
                    <label for="role" class="mb-2 required">Role</label>
                    <select id="role" name="role" class="form-select">
                        @php
                            $roles = ['admin', 'karyawan'];
                        @endphp
                        @foreach ($roles as $item)
                            <option value="{{ $item }}" {{ old('role') == $item ? 'selected' : '' }}>
                                {{ $item }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="input-group justify-content-between mt-3">
                <div class="input-box col-12">
                    <label for="image" class="mb-2 required">Photo Profile</label>
                    <input type="file" name="image" id="image"
                        class="form-control @error('image') is-invalid @enderror"">
                    @error('image')
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
    @if (session('addKaryawan'))
        <script>
            toastr.error("{{ Session::get('addKaryawan') }}");
            $(document).ready(function() {
                $('#addKaryawan').modal('show');
            });
        </script>
    @endif


    @if (session('updateKaryawan'))
        <script>
            swal("Error!", "{{ Session::get('updateKaryawan') }}", "error"), {
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
