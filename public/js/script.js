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

// Id card
$(document).ready(function () {
    $("#idcard").on("show.bs.modal", function (event) {
        const button = $(event.relatedTarget);
        const user = button.data("karyawan");
        $("#user_qrcode").empty();
        new QRCode("user_qrcode").makeCode(user.qr_code);

        $("#download").click(function (e) {
            e.preventDefault();
            html2canvas(document.getElementById("user_qrcode")).then(function (
                canvas
            ) {
                const link = document.createElement("a");
                link.download = `${user.username}_${user.nip}`; // Set the filename
                link.href = canvas.toDataURL("image/png"); // Convert canvas to data URL
                link.click(); // Trigger the download

                // Show success alert
                swal({
                    title: "Success!",
                    text: "ID Card Berhasil Didownload",
                    icon: "success",
                    button: "OK",
                }).then(() => {
                    location.reload(); // Refresh the page after alert is closed
                });
            });
        });
    });
});
