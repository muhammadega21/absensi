<div class="modal fade" id="scanAbsen" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Scan Absen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="{{ url('/absen/checkin') }}" method="POST">
                    @csrf
                    <div id="reader"></div>
                    <input type="hidden" name="qrcode" id="qrcode">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    const form = document.querySelector("form");
    const qrcodeInput = document.getElementById("qrcode");
    let isScanning = false

    function onScanSuccess(decodedText, decodedResult) {
        if (isScanning) return;

        isScanning = true;

        console.log(`Hasil pemindaian: ${decodedText}`, decodedResult);
        qrcodeInput.value = decodedText;

        html5QrcodeScanner.clear().then(() => {
            form.submit();
        }).catch(error => {
            isScanning = false;
        });
    }

    var html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", {
            fps: 10,
            qrbox: 250,

        });
    html5QrcodeScanner.render(onScanSuccess);
</script>
