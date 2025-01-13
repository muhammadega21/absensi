<x-layouts.main :title="$title" :mainPage="$main_page" :page="$page">
    <div class="row">
        <div class="col-xl-4">

            <div class="card">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                    <div class="profile-img mb-3 ">
                        <img src="{{ asset('img/user/' . $data->image) }}" alt="Profile"
                            class="w-100 h-100 object-fit-cover">
                    </div>
                    <h2 class="text-center">{{ $data->name }}</h2>
                    <h4 class="text-secondary fs-5">
                        {{ $data->role }}</h4>
                </div>
            </div>

        </div>

        <div class="col-xl-8">

            <div class="card">
                <div class="card-body pt-3">
                    <!-- Bordered Tabs -->
                    <ul class="nav nav-tabs nav-tabs-bordered">

                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab"
                                data-bs-target="#profile-overview">Profile</button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit
                                Profile</button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab"
                                data-bs-target="#profile-change-password">Change Password</button>
                        </li>

                    </ul>
                    <div class="tab-content pt-2">

                        <div class="tab-pane fade show active profile-overview mt-3" id="profile-overview">
                            <p class="text-secondary">Note : Sesuaikan identitas anda di halaman "Edit Profile"
                                jika
                                terdapat kesalahan dalam penulisan identitas</p>
                            <div class="row">
                                <div class="col-lg-3 col-md-4 label fw-semibold ">NIP</div>
                                <div class="col-lg-9 col-md-8">: {{ $data->nip }}</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label fw-semibold ">Nama</div>
                                <div class="col-lg-9 col-md-8">: {{ $data->name }}</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label fw-semibold">Username</div>
                                <div class="col-lg-9 col-md-8">: {{ $data->username }}</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label fw-semibold">Tanggal Lahir</div>
                                <div class="col-lg-9 col-md-8">: {{ $data->tanggal_lahir }}</div>
                            </div>

                        </div>

                        <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                            <!-- Profile Edit Form -->
                            <form action="{{ url('profile/update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row mb-3">
                                    <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile
                                        Image</label>
                                    <div style="max-width: max-content">
                                        <img id="profilePreview" src="{{ asset('img/user/' . $data->image) }}"
                                            width="100" height="100"
                                            class="rounded-circle overflow-hidden object-fit-cover" alt="Profile">
                                        <div class="d-flex justify-content-center mt-2">
                                            <label class="btn btn-primary btn-sm px-4" for="inputImage"><i
                                                    class="bi bi-upload"></i></label>
                                            <input type="hidden" name="oldImage" value="{{ $data->image }}">
                                            <input type="file"
                                                class="form-control @error('image') is-invalid @enderror" hidden
                                                name="image" id="inputImage" onchange="previewImage()">
                                            @error('image')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Nama</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="name" type="text"
                                            class="form-control  @error('name') is-invalid @enderror" id="name"
                                            value="{{ old('name', $data->name) }}">
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="username" class="col-md-4 col-lg-3 col-form-label">Username</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="username" type="text"
                                            class="form-control @error('username') is-invalid @enderror" id="username"
                                            value="{{ old('username', $data->username) }}">
                                        @error('username')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="tanggal_lahir" class="col-md-4 col-lg-3 col-form-label">Tanggal
                                        Lahir</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input type="date" id="tanggal_lahir"
                                            class="form-control flatpickr @error('tanggal_lahir') is-invalid @enderror"
                                            name="tanggal_lahir" placeholder="Masukkan Tanggal Lahir"
                                            value="{{ old('tanggal_lahir', $data->tanggal_lahir) }}">
                                        @error('tanggal_lahir')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form><!-- End Profile Edit Form -->

                        </div>

                        <div class="tab-pane fade pt-3" id="profile-change-password">
                            <!-- Change Password Form -->
                            <form method="post" action="{{ url('profile/change_password') }}">
                                @csrf
                                @method('PUT')

                                <div class="row mb-3">
                                    <label for="currentPassword" class="col-md-4 col-lg-4 col-form-label">Current
                                        Password</label>
                                    <div class="col-md-8 col-lg-8">
                                        <input name="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            id="currentPassword" placeholder="Masukkan Password">
                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="newPassword" class="col-md-4 col-lg-4 col-form-label">New
                                        Password</label>
                                    <div class="col-md-8 col-lg-8">
                                        <input name="newpassword" type="password"
                                            class="form-control @error('newpassword') is-invalid @enderror"
                                            id="newPassword" placeholder="Masukkan Password Baru">
                                        @error('newpassword')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password_confirm" class="col-md-4 col-lg-4 col-form-label">Confirm
                                        Password</label>
                                    <div class="col-md-8 col-lg-8">
                                        <input name="password_confirm" type="password"
                                            class="form-control @error('password_confirm') is-invalid @enderror"
                                            id="password_confirm" placeholder="Ulangi Password Baru">
                                        @error('password_confirm')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Change Password</button>
                                </div>
                            </form><!-- End Change Password Form -->

                        </div>

                    </div><!-- End Bordered Tabs -->

                </div>
            </div>

        </div>
    </div>

    {{-- Alert  --}}
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
    @elseif (Session::has('errorToast'))
        <script>
            toastr.error("{{ Session::get('errorToast') }}");
        </script>
    @endif
</x-layouts.main>
