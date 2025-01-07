// Data table
new DataTable("#datatable", {
    layout: {
        bottomEnd: {
            paging: {
                firstLast: false,
            },
        },
    },
    scrollX: true,
});

// flatpickr
$(document).ready(function () {
    flatpickr(".flatpickr"),
        {
            dateFormat: "Y-m-d",
            defaultDate: "today",
            wrap: true,
        };
});

// Confirm Delete
function confirm(e) {
    e.preventDefault();
    const url = e.currentTarget.getAttribute("href");

    swal({
        title: "Anda Yakin?",
        text: "Data ini akan dihapus permanent",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((cancel) => {
        if (cancel) {
            window.location.href = url;
        }
    });
}

// Confirm Close Absen
function confirmCloseAbsen(e) {
    e.preventDefault();
    const url = e.currentTarget.getAttribute("href");

    swal({
        title: "Tutup Absen?",
        text: "Semua Karyawan Yang Belum Absen Akan Ditandai Alfa",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((cancel) => {
        if (cancel) {
            window.location.href = url;
        }
    });
}

// Select2
$(document).ready(function () {
    const parent = $(".select2").data("parent");

    $(".select2").select2({
        theme: "bootstrap",
        dropdownParent: $("#" + parent),
    });
});

// Modal Update
$(document).ready(function () {
    $("#updateUnitKerja").on("show.bs.modal", function (event) {
        const button = $(event.relatedTarget);
        const unit_kerja = button.data("unit_kerja");
        const idUnitKerja = unit_kerja.id;

        $("#updateUnitKerja form").attr(
            "action",
            "unit_kerja/update/" + idUnitKerja
        );

        $("#name").val(unit_kerja.name);
        $("#code").val(unit_kerja.code);
    });

    $("#updateKaryawan").on("show.bs.modal", function (event) {
        const button = $(event.relatedTarget);
        const karyawan = button.data("karyawan");
        const idKaryawan = karyawan.id;

        $("#updateKaryawan form").attr(
            "action",
            "karyawan/update/" + idKaryawan
        );

        $("#name").val(karyawan.name);
        $("#username").val(karyawan.username);
        $("#tanggal_lahir").val(karyawan.tanggal_lahir);
        $("#unit_kerja_id").val(karyawan.unit_kerja_id);
        $("#role").val(karyawan.role);
    });
});
