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
