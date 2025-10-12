<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Detail Jadwal</h3>

<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title"><?= esc($jadwal['nama_mapel']) ?></h5>
        <p><strong>Guru Pengampu:</strong> <?= esc($jadwal['nama_guru']) ?></p>
        <p><strong>Kelas:</strong> <?= esc($jadwal['nama_kelas']) ?></p>
        <p><strong>Ruangan:</strong> <?= esc($jadwal['nama_ruangan']) ?></p>
        <p><strong>Hari:</strong> <?= esc($jadwal['hari']) ?></p>
        <p><strong>Jam Pelajaran:</strong> <?= esc($jadwal['jampel']) ?></p>
        <p><strong>Waktu:</strong> <?= esc($jadwal['waktu_mulai']) ?> - <?= esc($jadwal['waktu_selesai']) ?></p>
        <p><strong>Status:</strong> <?= esc($jadwal['status']) ?></p>
        <p><strong>Keterangan:</strong> <?= esc($jadwal['ket']) ?></p>
    </div>
</div>

<h4>Daftar Pertemuan</h4>

<?php if (count($pertemuan) > 0): ?>
    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Tanggal</th>
                <th>Materi</th>
                <th>Status</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($pertemuan as $p): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($p['tanggal']) ?></td>
                    <td><?= esc($p['materi']) ?></td>
                    <td><?= esc($p['status']) ?></td>
                    <td><?= esc($p['ket']) ?></td>
                    <td>
                        <a href="<?= base_url('pertemuan/detail/' . $p['id_pertemuan']) ?>" class="btn btn-sm btn-info">Detail</a>
                        <a href="<?= base_url('pertemuan/edit/' . $p['id_pertemuan']) ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="<?= base_url('pertemuan/delete/' . $p['id_pertemuan']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="alert alert-secondary">Belum ada pertemuan untuk jadwal ini.</div>
<?php endif; ?>

<a href="<?= base_url('jadwal') ?>" class="btn btn-secondary mt-3">Kembali</a>

<?= $this->endSection() ?>