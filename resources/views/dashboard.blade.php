<x-layouts.main :title="$title" :mainPage="$main_page" :page="$page">
    @if (Session::has('toastSuccess'))
        <script>
            toastr.success("{{ Session::get('toastSuccess') }}");
        </script>
    @endif

    @php
        $today = Carbon\Carbon::now()->format('Y-m-d');
    @endphp

    <x-cards.card-absent :absen="$absen->where('tanggal', $today)->first()->absenMasuk->where('keterangan', 'Hadir')" title='Absen Masuk' classCard='present-card'>
        Hadir
    </x-cards.card-absent>

    <x-cards.card-absent :absen="$absen->where('tanggal', $today)->first()->absenMasuk->where('keterangan', 'Izin')" title='Absen Masuk' classCard='late-card'>
        Izin
    </x-cards.card-absent>

    <x-cards.card-absent :absen="$absen->where('tanggal', $today)->first()->absenMasuk->where('keterangan', 'Terlambat')" title='Absen Masuk' classCard='permit-card'>
        Terlambat
    </x-cards.card-absent>

    <x-cards.card-absent :absen="$absen->where('tanggal', $today)->first()->absenPulang->where('keterangan', 'Hadir')" title='Absen Pulang' classCard='present-card'>
        Hadir
    </x-cards.card-absent>

    <x-cards.card-absent :absen="$absen->where('tanggal', $today)->first()->absenPulang->where('keterangan', 'Izin')" title='Absen Pulang' classCard='late-card'>
        Izin
    </x-cards.card-absent>

    <x-cards.card-absent :absen="$absen->where('tanggal', $today)->first()->absenPulang->where('keterangan', 'Terlambat')" title='Absen Pulang' classCard='permit-card'>
        Terlambat
    </x-cards.card-absent>

    <x-charts.report></x-charts.report>
</x-layouts.main>
