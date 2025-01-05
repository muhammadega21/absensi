<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500;600;700;800&display=swap');
    </style>

    <!-- Vendor CSS Files -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    {{-- <link href="{{ asset('vendor/quill/quill.snow.css') }}" rel="stylesheet"> --}}
    {{-- <link href="{{ asset('vendor/quill/quill.bubble.css') }}" rel="stylesheet"> --}}
    {{-- <link href="{{ asset('vendor/remixicon/remixicon.css') }}" rel="stylesheet"> --}}

    {{-- CDN --}}
    <script src='https://code.jquery.com/jquery-3.7.0.min.js'
        integrity='sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=' crossorigin='anonymous'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script type="text/javascript" src="https://unpkg.com/qr-code-styling@1.5.0/lib/qr-code-styling.js"></script>


    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body>
    <x-layouts.navbar></x-layouts.navbar>

    <x-layouts.sidebar></x-layouts.sidebar>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>{{ $title }}</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    @if ($mainPage)
                        <li class="breadcrumb-item"><a
                                href="{{ url('/' . Str::lower($mainPage)) }}">{{ $mainPage }}</a></li>
                    @endif
                    <li class="breadcrumb-item active">{{ $page }}</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">
                {{ $slot }}
            </div>
        </section>

    </main>
    <x-layouts.footer></x-layouts.footer>

    <!-- Vendor JS Files -->
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('/vendor/qrcode/qrcode.min.js') }}"></script>
    <script src="{{ asset('/vendor/scanqrcode/html5-qrcode.min.js') }}"></script>
    {{-- <script src="{{ asset('vendor/quill/quill.js') }}"></script> --}}
    {{-- <script src="{{ asset('vendor/tinymce/tinymce.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('vendor/php-email-form/validate.js') }}"></script> --}}

    {{-- CDN --}}
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('js/main.js') }}"></script>

    <!-- My JS File -->
    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
