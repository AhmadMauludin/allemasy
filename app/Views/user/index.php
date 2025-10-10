<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<div class="container mt-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Data user</h4>
        <a href="<?= base_url('user/create') ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah User
        </a>
    </div>

    <!-- Search Form -->
    <form class="row g-3 mb-4" action="<?= base_url('user') ?>" method="GET">
        <div class="col-md-6 col-lg-4">
            <input type="text" name="keyword" class="form-control"
                value="<?= esc($_GET['keyword'] ?? '') ?>" placeholder="Cari user...">
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-outline-primary">Cari</button>
            <a href="<?= base_url('user') ?>" class="btn btn-outline-secondary">Reset</a>
        </div>
    </form>

    <!-- Flash Message -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php elseif (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Table -->
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-striped align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th width="5%">#</th>
                        <th width="10%">Foto</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($user)): ?>
                        <?php $no = 1 + (5 * ($pager->getCurrentPage() - 1)); ?>
                        <?php foreach ($user as $row): ?>
                            <tr class="text-center">
                                <td><?= $no++ ?></td>
                                <td>
                                    <?php if (!empty($row['foto'])): ?>
                                        <img src="<?= base_url('uploads/user/' . $row['foto']) ?>" class="rounded-circle" width="50" height="50" alt="Foto">
                                    <?php else: ?>
                                        <img src="<?= base_url('uploads/default.png') ?>" class="rounded-circle" width="50" height="50" alt="Default">
                                    <?php endif; ?>
                                </td>
                                <td class="text-start">
                                    <?php if ($row['role'] === 'pesdik'): ?>
                                        <?= esc($row['nama_pesdik']) ?>
                                    <?php elseif ($row['role'] === 'guru'): ?>
                                        <?= esc($row['nama_guru']) ?>
                                    <?php else: ?>
                                        <em class="text-muted">(Tidak ada nama)</em>
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($row['username']) ?></td>
                                <td>
                                    <span class="badge 
                                        <?= $row['role'] === 'admin' ? 'bg-danger' : ($row['role'] === 'guru' ? 'bg-success' : ($row['role'] === 'siswa' ? 'bg-primary' : 'bg-secondary')) ?>">
                                        <?= ucfirst($row['role']) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="<?= site_url('user/edit/' . $row['id_user']) ?>" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="<?= site_url('user/delete/' . $row['id_user']) ?>"
                                            onclick="return confirm('Yakin ingin menghapus data ini?')"
                                            class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">Tidak ada data user</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                <?= $pager->links() ?>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection(); ?>