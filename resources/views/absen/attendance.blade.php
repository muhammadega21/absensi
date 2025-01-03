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

    {{-- CDN --}}
    <script src='https://code.jquery.com/jquery-3.7.0.min.js'
        integrity='sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=' crossorigin='anonymous'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">


    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body>

    <div class="container vh-100">
        <div class="row d-flex align-items-center justify-content-center h-100">
            <div>
                <div class="col-9 mx-auto">
                    <div class="text-center">
                        <h1>Sistem Absensi Pegawai Online</h1>
                        <h1>Sorum Yamaha Tjahaja Baru</h1>
                    </div>
                </div>
                <div class="countdown mt-3">
                    <div class="card">
                        <div class="row text-center justify-content-center mt-2">
                            <div class="col-2">
                                <h3 id="hours" class="display-4">00</h3>
                                <p>Hours</p>
                            </div>
                            <div class="col-2">
                                <h3 id="minutes" class="display-4">00</h3>
                                <p>Minutes</p>
                            </div>
                            <div class="col-2">
                                <h3 id="seconds" class="display-4">00</h3>
                                <p>Seconds</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function timeToSeconds(timeStr) {
            const [hours, minutes, seconds] = timeStr.split(':').map(Number);
            return hours * 3600 + minutes * 60 + seconds;
        }
        let now = new Date().toLocaleTimeString().replace('AM', '')
        const startTime = now;
        const endTime = "{{ $absen->checkin_over }}";

        let countdownTime = timeToSeconds(endTime) - timeToSeconds(startTime);

        const hoursElement = document.getElementById('hours');
        const minutesElement = document.getElementById('minutes');
        const secondsElement = document.getElementById('seconds');

        function updateCountdown() {
            const hours = Math.floor(countdownTime / 3600);
            const minutes = Math.floor((countdownTime % 3600) / 60);
            const seconds = countdownTime % 60;

            hoursElement.textContent = String(hours).padStart(2, '0');
            minutesElement.textContent = String(minutes).padStart(2, '0');
            secondsElement.textContent = String(seconds).padStart(2, '0');
        }

        const interval = setInterval(() => {
            if (countdownTime <= 0) {
                clearInterval(interval);
                alert("Time's up!");
            } else {
                updateCountdown();
                countdownTime--;
            }
        }, 1000);
        updateCountdown();
    </script>

    <!-- Vendor JS Files -->
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('js/main.js') }}">
        < />

        <
        !--My JS File-- >
        <
        script src = "{{ asset('js/script.js') }}" >
            <
            /> < /
        body >

            <
            /html>
