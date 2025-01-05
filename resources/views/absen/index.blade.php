<x-layouts.main :title="$title" :mainPage="$main_page" :page="$page">

    @can('admin')
        <x-absen.admin-absen :datas="$datas"></x-absen.admin-absen>
    @endcan
    @can('karyawan')
        <x-absen.karyawan-absen :absens="$absens"></x-absen.karyawan-absen>
    @endcan

    {{-- Alert --}}
    @if (Session::has('success'))
        <script>
            swal("Success!", "{{ Session::get('success') }}", "success"), {
                button: true,
                button: 'ok'
            }
        </script>
    @elseif (Session::has('warning'))
        <script>
            swal("Success!", "{{ Session::get('warning') }}", "warning"), {
                button: true,
                button: 'ok',
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
