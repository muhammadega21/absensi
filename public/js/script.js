// qrcode
$(document).ready(function () {
    const qr = $("#qrcode").data("qr");
    const qrCode = new QRCodeStyling({
        width: 300,
        height: 300,
        type: "svg",
        data: qr,
        dotsOptions: {
            type: "rounded",
        },
    });
    qrCode.append(document.getElementById("qrcode"));
});

$(document).ready(function () {
    function onScanSuccess(decodedText, decodedResult) {
        // handle the scanned code as you like, for example:
        console.log(`Code matched = ${decodedText}`, decodedResult);
    }

    function onScanFailure(error) {
        // handle scan failure, usually better to ignore and keep scanning.
        // for example:
        console.warn(`Code scan error = ${error}`);
    }

    let html5QrcodeScanner = new Html5QrcodeScanner("reader", {
        fps: 10,
        qrbos: 250,
    });
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
});
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
