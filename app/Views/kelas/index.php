<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <p class="mb-0">Data Rombel</p>
        </div>
        <div class="card-body">

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>

            <?php if (session()->get('role') == 'admin') : ?>
                <a href="<?= base_url('kelas/create') ?>" class="btn btn-primary mb-3">Tambah Kelas</a>
            <?php endif; ?>

            <table class="table table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Kelas</th>
                        <th>Tingkat</th>
                        <th>Wali Kelas</th>
                        <th>Ruangan</th>
                        <th>Status</th>
                        <th>Foto</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($kelas as $row): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= esc($row['nama_kelas']) ?></td>
                            <td><?= esc($row['tingkat']) ?></td>
                            <td><?= esc($row['wali_kelas']) ?></td>
                            <td><?= esc($row['nama_ruangan']) ?></td>
                            <td><?= esc($row['status']) ?></td>
                            <td>
                                <?php if ($row['foto']): ?>
                                    <img src="<?= base_url('uploads/kelas/' . $row['foto']) ?>" width="50" class="rounded">
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?= base_url('kelas/detail/' . $row['id_kelas']) ?>" class="btn btn-success btn-sm">Detail</a>
                                <?php if (session()->get('role') == 'admin') : ?>
                                    <a href="<?= base_url('kelas/edit/' . $row['id_kelas']) ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="<?= base_url('kelas/delete/' . $row['id_kelas']) ?>" onclick="return confirm('Yakin hapus data ini?')" class="btn btn-danger btn-sm">Hapus</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>