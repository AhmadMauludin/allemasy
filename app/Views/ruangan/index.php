<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
        <span>Data Ruangan</span>
        <a href="<?= base_url('ruangan/create') ?>" class="btn btn-light btn-sm">Tambah Ruangan</a>
    </div>
    <div class="card-body">

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <table class="table table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Ruangan</th>
                    <th>Penanggung Jawab</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th>Status</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($ruangan as $r): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($r['nama_ruangan']) ?></td>
                        <td><?= esc($r['penanggung_jawab'] ?? '-') ?></td>
                        <td><?= esc($r['latitude']) ?></td>
                        <td><?= esc($r['longitude']) ?></td>
                        <td><?= esc($r['status']) ?></td>
                        <td>
                            <?php if ($r['foto']): ?>
                                <img src="<?= base_url('uploads/ruangan/' . $r['foto']) ?>" width="50" class="rounded">
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?= base_url('ruangan/edit/' . $r['id_ruangan']) ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="<?= base_url('ruangan/delete/' . $r['id_ruangan']) ?>" onclick="return confirm('Yakin hapus data ini?')" class="btn btn-danger btn-sm">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?= $this->endSection() ?>