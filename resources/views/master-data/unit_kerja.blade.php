<x-layouts.main :title="$title" :mainPage="$main_page" :page="$page">
    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mt-2">
                        <h5 class="card-title">Data Unit Kerja</h5>
                        <div class="btn-action">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#addUnitKerja">
                                Tambah <span class="fw-semibold">+</span>
                            </button>
                        </div>
                    </div>
                    <table id="datatable" class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Unit</th>
                                <th>Kode</th>
                                <th data-sortable="false">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-nowrap">{{ $data->name }}</td>
                                    <td class="text-nowrap">{{ $data->code }}</td>
                                    <td class="text-nowrap">
                                        <div class="d-flex gap-1">
                                            <a href="{{ url('unit_kerja/delete/' . $data->id) }}"
                                                class="badge border-danger border" onclick="confirm(event)"><i
                                                    class='bx bxs-trash text-danger'></i></a>
                                            <button type="button" class="badge bg-light border-warning border"
                                                data-bs-toggle="modal" data-bs-target="#updateUnitKerja"
                                                data-unit_kerja="{{ $data }}">
                                                <span class="fw-semibold"><i
                                                        class="bx bxs-edit text-warning"></i></span>
                                            </button>
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
    <x-modal modalTitle="Tambah Unit Kerja" modalID="addUnitKerja" btn="Tambah" action="{{ url('unit_kerja') }}"
        method="POST" method2="POST">
        <div class="row mb-3">
            <div class="input-group justify-content-between">
                <div class="input-box col-sm-12">
                    <label for="name" class="mb-2 required">Nama Unit Kerja</label>
                    <input type="text" id="name" class="form-control @error('name') is-invalid @enderror"
                        name="name" placeholder="Masukkan Nama Unit Kerja" value="{{ old('name') }}">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="input-box col-sm-12">
                    <label for="code" class="mb-2 required">Kode Unit Kerja</label>
                    <input type="text" id="code" class="form-control @error('code') is-invalid @enderror"
                        name="code" placeholder="Masukkan Kode Unit Kerja" value="{{ old('code') }}">
                    @error('code')
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
    @if (session('addUnitKerja'))
        <script>
            toastr.error("{{ Session::get('addUnitKerja') }}");
            $(document).ready(function() {
                $('#addUnitKerja').modal('show');
            });
        </script>
    @endif


    @if (session('updateUnitKerja'))
        <script>
            swal("Error!", "{{ Session::get('updateUnitKerja') }}", "error"), {
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
