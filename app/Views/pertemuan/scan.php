<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<p>Scan Barcode Kehadiran</p>
<p>Silakan arahkan kamera ke barcode ID Peserta Didik. Setelah berhasil, status kehadiran otomatis akan diperbarui menjadi <b>Hadir</b>.</p>

<div id="scanner" style="width:100%; max-width:500px; margin:auto;"></div>

<div class="text-center mt-3">
    <a href="<?= base_url('pertemuan/detail/' . $idPertemuan) ?>" class="btn btn-secondary">Selesai</a>
</div>

<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    const idPertemuan = <?= json_encode($idPertemuan) ?>;
    const scanner = new Html5Qrcode("scanner");

    Html5Qrcode.getCameras().then(cameras => {
        if (cameras && cameras.length) {
            scanner.start(
                cameras[0].id, {
                    fps: 10,
                    qrbox: 250
                },
                qrCodeMessage => {
                    fetch("<?= base_url('pertemuan/scanProcess') ?>", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/x-www-form-urlencoded"
                            },
                            body: `id_pesdik=${qrCodeMessage}&id_pertemuan=${idPertemuan}`
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                alert("✅ Presensi berhasil untuk ID: " + qrCodeMessage);
                            } else {
                                alert("⚠️ " + data.message);
                            }
                        });
                },
                errorMessage => {}
            );
        }
    }).catch(err => alert("Kamera tidak terdeteksi: " + err));
</script>

<?= $this->endSection() ?>