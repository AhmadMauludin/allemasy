<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Detail Pertemuan</h3>

<div class="card mb-4">
    <div class="card-body">
        <p><strong>Mapel:</strong> <?= esc($j['nama_mapel']) ?> <?= esc($j['nama_kelas']) ?> - Jam ke <?= esc($j['jampel']) ?></p>
        <p><strong>Hari, Tanggal:</strong> <?= esc($j['hari']) ?>, <?= esc($p['tanggal']) ?></p>
        <p><strong>Status:</strong> <?= esc($p['status']) ?></p>
        <p><strong>Materi:</strong> <?= esc($p['materi']) ?></p>
        <p><strong>Keterangan:</strong> <?= esc($p['ket']) ?></p>
    </div>
</div>

<div class="d-flex justify-content-between mb-3">
    <h5>Daftar Kehadiran</h5>
    <a href="<?= base_url('pertemuan/scan/' . $p['id_pertemuan']) ?>" class="btn btn-primary btn-sm">
        <i class="bi bi-upc-scan"></i> Scan Kehadiran
    </a>
</div>

<table class="table table-bordered table-striped">
    <thead class="table-primary">
        <tr>
            <th>Nama Peserta Didik</th>
            <th>Status</th>
            <th>Ket</th>
            <th>Lampiran</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($presensi as $r): ?>
            <tr>
                <td><?= esc($r['nama_pesdik']) ?></td>
                <td>
                    <?php if ($r['status'] == 'pending'): ?>
                        <span class="badge bg-warning text-dark">Pending</span>
                    <?php elseif ($r['status'] == 'hadir'): ?>
                        <span class="badge bg-success">Hadir</span>
                    <?php else: ?>
                        <span class="badge bg-secondary"><?= esc($r['status']) ?></span>
                    <?php endif; ?>
                </td>
                <td><?= esc($r['ket'] ?? '-'); ?></td>
                <td>
                    <?php if (!empty($r['foto'])): ?>
                        <a href="<?= base_url('uploads/bukti/' . $r['foto']) ?>" target="_blank" class="btn btn-sm btn-info">Lihat Surat</a>
                    <?php else: ?>
                        <span class="text-muted">Belum ada</span>
                    <?php endif; ?>
                </td>

                <td>
                    <a href="<?= base_url('presensi/edit/' . $r['id_presensi']) ?>" class="btn btn-sm btn-secondary">Edit</a>
                </td>

            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="<?= base_url('jadwal/detail/' . $j['id_jadwal']) ?>" class="btn btn-secondary mt-3">Kembali</a>

<?= $this->endSection() ?>