<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <p class="mb-0">Daftar Pengumpulan Tugas </p>
        </div>
        <div class="card-body">
            <p>Total Pengumpulan : <?= count($pengumpulan) ?></p>
            <?php if ($role == 'pesdik' && empty($pengumpulan)): ?>
                <a href="<?= base_url('pengumpulan_tugas/create/' . $id_tugas) ?>" class="btn btn-primary mb-3">
                    <i class="bi bi-plus-circle"></i> Kumpulkan Tugas
                </a>
            <?php endif; ?>

            <table class="table table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Pesdik</th>
                        <th>Status</th>
                        <th>Nilai</th>
                        <th>Lampiran</th>
                        <th>Intruksi</th>
                        <?php if ($role == 'guru' || $role == 'pesdik'): ?>
                            <th>Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pengumpulan)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada pengumpulan</td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; ?>
                        <?php foreach ($pengumpulan as $p): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($p['nama_pesdik'] ?? '-') ?></td>
                                <td><span class="badge bg-info"><?= esc($p['status']) ?></span></td>
                                <td><?= esc($p['nilai'] ?? '-') ?></td>
                                <td><?= $p['lampiran'] ? "<a href='" . base_url('uploads/pengumpulan/' . $p['lampiran']) . "' target='_blank'>Lihat</a>" : '-' ?></td>
                                <td><?= esc($p['intruksi'] ?? '-') ?></td>
                                <?php if ($role == 'guru' || $role == 'pesdik'): ?>
                                    <td>
                                        <a href="<?= base_url('pengumpulan_tugas/edit/' . $p['id_pengumpulan_tugas']) ?>" class="btn btn-sm btn-warning">Edit</a>
                                    </td>
                                <?php endif; ?>

                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            <a href="javascript:history.back()" class="btn btn-secondary mt-3">Kembali</a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>