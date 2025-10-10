<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Detail Pertemuan</h3>

<div class="card">
    <div class="card-body">
        <p><strong>Mapel:</strong> <?= esc($j['nama_mapel']) ?> <?= esc($j['nama_kelas']) ?> - Jam ke <?= esc($j['jampel']) ?></p>
        <p><strong>Hari, Tanggal:</strong> <?= esc($j['hari']) ?>, <?= esc($p['tanggal']) ?></p>
        <p><strong>Status:</strong> <?= esc($p['status']) ?></p>
        <p><strong>Materi:</strong> <?= esc($p['materi']) ?></p>
        <p><strong>Keterangan:</strong> <?= esc($p['ket']) ?></p>
        <?php if ($p['foto']): ?>
            <img src="<?= base_url('uploads/pertemuan/' . $p['foto']) ?>" width="250" class="mt-2 rounded">
        <?php endif; ?>
    </div>
</div>

<a href="<?= base_url('pertemuan') ?>" class="btn btn-secondary mt-3">Kembali</a>

<?= $this->endSection() ?>