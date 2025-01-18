<x-layouts.main :title="$title" :mainPage="$main_page" :page="$page">
    @if (Session::has('toastSuccess'))
        <script>
            toastr.success("{{ Session::get('toastSuccess') }}");
        </script>
    @endif

    @php
        $today = \Carbon\Carbon::now()->format('Y-m-d');
        $absensi = $absen->where('tanggal', $today)->first();
    @endphp

    <x-cards.card-absent :absen="$absensi != null ? $absensi->absenMasuk->where('keterangan', 'Hadir')->count() : '0'" title='Absen Masuk' classCard='present-card'>
        Hadir
    </x-cards.card-absent>

    <x-cards.card-absent :absen="$absensi != null ? $absensi->absenMasuk->where('keterangan', 'Izin')->count() : '0'" title='Izin' classCard='late-card'>
        Izin
    </x-cards.card-absent>

    <x-cards.card-absent :absen="$absensi != null ? $absensi->absenMasuk->where('keterangan', 'Terlambat')->count() : '0'" title='Terlambat' classCard='permit-card'>
        Terlambat
    </x-cards.card-absent>

    <x-cards.card-absent :absen="$absensi != null ? $absensi->absenPulang->where('keterangan', 'Hadir')->count() : '0'" title='Absen Pulang' classCard='present-card'>
        Hadir
    </x-cards.card-absent>

    <x-cards.card-absent :absen="$absensi != null ? $absensi->absenPulang->where('keterangan', 'Izin')->count() : '0'" title='Izin' classCard='late-card'>
        Izin
    </x-cards.card-absent>

    <x-cards.card-absent :absen="$absensi != null ? $absensi->absenPulang->where('keterangan', 'Terlambat')->count() : '0'" title='Terlambat' classCard='permit-card'>
        Terlambat
    </x-cards.card-absent>

    <x-charts.report></x-charts.report>
</x-layouts.main>
