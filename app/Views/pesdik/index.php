<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="card shadow-sm mb-4">
    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
        <p class="mb-0">Data Peserta Didik</p>
        <form class="d-flex" method="get" action="<?= base_url('pesdik') ?>">
            <input type="text" name="keyword" class="form-control form-control-sm me-2" placeholder="Cari nama/NIS..." value="<?= esc($keyword ?? '') ?>">
            <button class="btn btn-light btn-sm" type="submit"><i class="bi bi-search"></i></button>
        </form>
    </div>

    <div class="card-body">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <?php if (session()->get('role') === 'admin'): ?>
            <a href="<?= base_url('pesdik/create'); ?>" class="btn btn-primary mb-3">
                <i class="bi bi-plus-circle"></i> Tambah Peserta Didik
            </a>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead class="table-light">
                    <tr class="text-center">
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>NISN / NIS</th>
                        <th>Kelas Diikuti</th>
                        <th>Status</th>
                        <th style="width: 180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pesdik)): ?>
                        <?php $no = 1;
                        foreach ($pesdik as $row): ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td><?= esc($row['nama']) ?></td>
                                <td class="text-center"><?= esc($row['nisn']) ?> / <?= esc($row['nis']) ?></td>
                                <td><?= esc($row['nama_kelas'] ?? '-') ?></td>
                                <td class="text-center">
                                    <?php if ($row['status'] == 'aktif'): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php elseif ($row['status'] == 'nonaktif'): ?>
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark"><?= esc($row['status']) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('pesdik/detail/' . $row['id_pesdik']) ?>" class="btn btn-info btn-sm">
                                        Detail
                                    </a>
                                    <a href="<?= base_url('pesdik/edit/' . $row['id_pesdik']) ?>" class="btn btn-warning btn-sm">
                                        Edit
                                    </a>
                                    <a href="<?= base_url('pesdik/delete/' . $row['id_pesdik']) ?>" onclick="return confirm('Yakin ingin menghapus data ini?')" class="btn btn-danger btn-sm">
                                        Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">Tidak ada data peserta didik.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end">
            <?= $pager->links(); ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>