<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Data Pesdik</h4>
        <a href="<?= base_url('pesdik/create') ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah
        </a>
    </div>

    <!-- Search Form -->
    <form class="row g-3 mb-4" action="<?= base_url('pesdik') ?>" method="GET">
        <div class="col-md-6 col-lg-4">
            <input type="text" name="keyword" class="form-control"
                value="<?= esc($_GET['keyword'] ?? '') ?>" placeholder="Cari pesdik...">
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-outline-primary">Cari</button>
            <a href="<?= base_url('pesdik') ?>" class="btn btn-outline-secondary">Reset</a>
        </div>
    </form>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>


    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>NISN</th>
                        <th>NIS</th>
                        <th>Kelas</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($pesdik as $row): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= esc($row['nama']) ?></td>
                            <td><?= esc($row['nisn']) ?></td>
                            <td><?= esc($row['nis']) ?></td>
                            <td><?= esc($row['nama_kelas']) ?></td>
                            <td><?= esc($row['status']) ?></td>
                            <td>
                                <a href="<?= base_url('pesdik/detail/' . $row['id_pesdik']) ?>" class="btn btn-info btn-sm">Detail</a>
                                <a href="<?= base_url('pesdik/edit/' . $row['id_pesdik']) ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="<?= base_url('pesdik/delete/' . $row['id_pesdik']) ?>" onclick="return confirm('Yakin hapus data ini?')" class="btn btn-danger btn-sm">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                <?= $pager->links() ?>
            </div>

        </div>
    </div>
</div>
<?= $this->endSection() ?>