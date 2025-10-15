<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<h2>Scan Presensi Sholat</h2>
<p><b>Sholat:</b> <?= esc($sholat['sholat']); ?> |
    <b>Tanggal:</b> <?= esc($sholat['tanggal']); ?> |
    <b>Waktu:</b> <?= esc($sholat['waktu_mulai']); ?> - <?= esc($sholat['waktu_selesai']); ?>
</p>

<div class="card p-4 shadow-sm text-center" style="max-width: 400px; margin: 0 auto;">
    <h5 class="mb-3">Scan QR Santri</h5>

    <!-- ✅ Area scanner diperkecil dan ditengah -->
    <div id="qr-reader-container" style="display: flex; justify-content: center;">
        <div id="qr-reader" style="width: 300px; height: 300px; border: 2px solid #ccc; border-radius: 10px;"></div>
    </div>

    <p class="mt-3 text-muted">Arahkan kamera ke QR santri...</p>

    <div id="result" class="alert mt-3 d-none"></div>
</div>


<form id="scanForm" method="post" action="<?= base_url('sholat/prosesScan'); ?>">
    <input type="hidden" name="id_sholat" value="<?= esc($sholat['id_sholat']); ?>">
    <input type="hidden" name="kode" id="kode">
</form>

<a href="<?= base_url('sholat/detail/' . $sholat['id_sholat']); ?>" class="btn btn-secondary mt-3">Selesai</a>

<!-- ✅ CDN resmi html5-qrcode -->
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const resultDiv = document.getElementById('result');
        const kodeInput = document.getElementById('kode');
        const form = document.getElementById('scanForm');
        const qrReader = new Html5Qrcode("qr-reader");

        // Dapatkan kamera
        Html5Qrcode.getCameras().then(devices => {
            if (devices && devices.length) {
                // Pilih kamera belakang jika ada
                const cameraId = devices.length > 1 ? devices[1].id : devices[0].id;

                qrReader.start(
                    cameraId, {
                        fps: 10,
                        qrbox: 250
                    },
                    qrCodeMessage => {
                        kodeInput.value = qrCodeMessage.trim();
                        fetch(form.action, {
                                method: 'POST',
                                body: new FormData(form)
                            })
                            .then(res => res.json())
                            .then(data => {
                                resultDiv.classList.remove('d-none', 'alert-danger', 'alert-success');
                                resultDiv.classList.add(data.success ? 'alert-success' : 'alert-danger');
                                resultDiv.textContent = data.message;
                            })
                            .catch(() => {
                                resultDiv.classList.remove('d-none');
                                resultDiv.classList.add('alert-danger');
                                resultDiv.textContent = 'Gagal mengirim data ke server.';
                            });
                    },
                    errorMessage => {
                        // Tidak perlu menampilkan error scanning setiap frame
                    }
                );
            } else {
                alert("Kamera tidak ditemukan pada perangkat ini.");
            }
        }).catch(err => {
            alert("Gagal mengakses kamera: " + err);
        });
    });
</script>

<?= $this->endSection(); ?>