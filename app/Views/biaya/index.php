<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
        <p class="mb-0">Data Biaya</p>
        <?php if (session()->get('role') == 'admin'): ?>
            <a href="<?= base_url('biaya/create'); ?>" class="btn btn-sm btn-light">Tambah Biaya</a>
        <?php endif; ?>
    </div>
    <div class="card-body">

        <table class="table table-striped">
            <thead class="table-light text-center">
                <tr>
                    <th>#</th>
                    <th>Pembiayaan</th>
                    <th>Peruntukan</th>
                    <th>Tingkat</th>
                    <th>Biaya</th>
                    <th>Status</th>
                    <th>Ket</th>
                    <?php if (session('role') === 'pesdik'): ?>
                        <th>Status Pembayaran</th>

                        <th>Aksi</th>
                    <?php else: ?>
                        <th>Aksi</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($biaya)): $no = 1;
                    foreach ($biaya as $b): ?>
                        <tr class="text-center">
                            <td><?= $no++ ?></td>
                            <td><?= esc($b['jenis_biaya']) ?></td>
                            <td><?= esc($b['peruntukan']) ?></td>
                            <td><?= esc($b['tingkat']) ?></td>
                            <td><?= number_format($b['biaya'], 0, ',', '.') ?></td>
                            <td><?= esc($b['status_biaya']) ?></td>
                            <td><?= esc($b['keterangan_biaya']) ?></td>

                            <?php if (session('role') === 'pesdik'): ?>
                                <td>
                                    <span class="badge 
                <?= $b['status_pembayaran'] === 'dibayar' ? 'bg-success' : ($b['status_pembayaran'] === 'ditolak' ? 'bg-danger' : 'bg-warning') ?>">
                                        <?= ucfirst($b['status_pembayaran']) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?= site_url('pembayaran/edit/' . $b['id_pembayaran']) ?>" class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </td>
                            <?php else: ?>
                                <td>
                                    <a href="<?= site_url('biaya/detail/' . $b['id_biaya']) ?>" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                                    <a href="<?= site_url('biaya/delete/' . $b['id_biaya']) ?>" onclick="return confirm('Yakin ingin menghapus data ini?')" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i></a>
                                </td>

                            <?php endif; ?>
                        </tr>
                    <?php endforeach;
                else: ?>
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data</td>
                    </tr>
                <?php endif; ?>
            </tbody>

        </table>
    </div>

    <?= $this->endSection(); ?>