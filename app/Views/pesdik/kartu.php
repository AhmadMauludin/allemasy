<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kartu Peserta Didik</title>
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <style>
        .kartu {
            width: 300px;
            border: 2px solid #198754;
            border-radius: 10px;
            padding: 15px;
            margin: 40px auto;
            background: #f8f9fa;
            text-align: left;
        }

        .qr img {
            width: 120px;
            height: 120px;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="kartu shadow-sm">
        <h5 class="text-success fw-bold mb-3">KARTU PESERTA DIDIK</h5>
        <p><b>ID:</b> <?= esc($pesdik['id_pesdik']) ?></p>
        <p><b>Nama:</b> <?= esc($pesdik['nama']) ?></p>
        <p><b>NISN:</b> <?= esc($pesdik['nisn']) ?> - <?= esc($pesdik['nis']) ?></p>
        <p><b>Tanggal Lahir:</b> <?= esc($pesdik['tanggal_lahir']) ?></p>
        <p><b>Alamat:</b> <?= esc($pesdik['alamat']) ?></p>
        <div class="qr">
            <img src="data:image/png;base64,<?= $qrCode ?>" alt="QR Code">
        </div>
    </div>
</body>

</html>