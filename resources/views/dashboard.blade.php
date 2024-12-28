<x-layouts.main :title="$title" :mainPage="$main_page" :page="$page">
    @if (Session::has('toastSuccess'))
        <script>
            toastr.success("{{ Session::get('toastSuccess') }}");
        </script>
    @endif
    <x-cards.card-absent classCard='present-card'>Hadir</x-cards.card-absent>
    <x-cards.card-absent classCard='late-card'>Terlambat</x-cards.card-absent>
    <x-cards.card-absent classCard='permit-card'>Izin</x-cards.card-absent>
    <x-charts.report></x-charts.report>
</x-layouts.main>
