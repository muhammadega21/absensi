// qrcode
$(document).ready(function () {
    const qr = $("#qrcode").data("qr");
    const qrCode = new QRCodeStyling({
        width: 300,
        height: 300,
        type: "svg",
        data: qr,
        dotsOptions: {
            type: "square",
        },
        backgroundOptions: {
            color: "#ffffff", // Pastikan background putih
        },
        qrOptions: {
            errorCorrectionLevel: "H", // Tingkatkan ke High untuk koreksi kesalahan
        },
    });
    qrCode.append(document.getElementById("qrcode"));

    $("#absenDownload").click(function () {
        const date = $("#absenDownload").data("date");
        qrCode
            .download({
                name: "qr-code-" + date,
                extension: "png",
            })
            .then(swal("Success!", "QR Code berhasil di download", "success"), {
                button: true,
                button: "ok",
            });
    });
});
