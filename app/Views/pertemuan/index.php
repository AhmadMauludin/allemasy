<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<p>Data Pertemuan</p>
<a href="<?= base_url('pertemuan/create') ?>" class="btn btn-primary mb-3">Tambah Pertemuan</a>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<table class="table table-bordered table-striped">
    <thead class="table-light">
        <tr>
            <th>#</th>
            <th>Mapel</th>
            <th>Hari</th>
            <th>Jam</th>
            <th>Status</th>
            <th>Materi</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1;
        foreach ($pertemuan as $p): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= esc($p['nama_mapel']) ?> - <?= esc($p['nama_kelas']) ?></td>
                <td><?= esc($p['hari']) ?>, <?= esc($p['tanggal']) ?></td>
                <td><?= esc($p['jampel']) ?></td>
                <td><?= esc($p['status']) ?></td>
                <td><?= esc($p['materi']) ?></td>
                <td>
                    <a href="<?= base_url('pertemuan/detail/' . $p['id_pertemuan']) ?>" class="btn btn-info btn-sm">Detail</a>
                    <a href="<?= base_url('pertemuan/edit/' . $p['id_pertemuan']) ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="<?= base_url('pertemuan/delete/' . $p['id_pertemuan']) ?>" onclick="return confirm('Yakin?')" class="btn btn-danger btn-sm">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>