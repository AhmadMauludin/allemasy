<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Data Guru</h4>
        <a href="<?= base_url('guru/create') ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah
        </a>
    </div>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-striped">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($guru as $row): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= esc($row['nama'] ?? '-') ?></td>
                            <td><?= esc($row['nip'] ?? '-') ?></td>
                            <td><span class="badge bg-<?= $row['status'] == 'aktif' ? 'success' : 'secondary' ?>">
                                    <?= ucfirst($row['status']) ?>
                                </span></td>
                            <td>
                                <a href="<?= base_url('guru/detail/' . $row['id_guru']) ?>" class="btn btn-info btn-sm">Detail</a>
                                <a href="<?= base_url('guru/edit/' . $row['id_guru']) ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="<?= base_url('guru/delete/' . $row['id_guru']) ?>" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>