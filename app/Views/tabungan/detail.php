<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4><?= esc($title) ?></h4>
        <a href="<?= base_url('tabungan') ?>" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="mb-3">Informasi Pesdik</h5>
            <table class="table table-borderless">
                <tr>
                    <th width="200px">Nama Pesdik</th>
                    <td><?= esc($pesdik['nama']) ?></td>
                </tr>
                <tr>
                    <th>No. Telepon</th>
                    <td><?= esc($pesdik['no_hp'] ?? '-') ?></td>
                </tr>
                <tr>
                    <th>Saldo Tabungan</th>
                    <td><strong>Rp <?= number_format($saldo, 0, ',', '.') ?></strong></td>
                </tr>
            </table>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <h5 class="mb-3">Riwayat Transaksi</h5>
            <table class="table table-striped align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Bukti</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($tabungan): $no = 1; ?>
                        <?php foreach ($tabungan as $t): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= date('d-m-Y H:i', strtotime($t['tanggal_transaksi'])) ?></td>
                                <td><?= ucfirst($t['jenis_transaksi']) ?></td>
                                <td>Rp <?= number_format($t['jumlah'], 0, ',', '.') ?></td>
                                <td>
                                    <span class="badge 
                                        <?= $t['status_transaksi'] === 'disetujui' ? 'bg-success' : ($t['status_transaksi'] === 'ditolak' ? 'bg-danger' : 'bg-warning') ?>">
                                        <?= ucfirst($t['status_transaksi']) ?>
                                    </span>
                                </td>
                                <td><?= esc($t['keterangan'] ?? '-') ?></td>
                                <td>
                                    <?php if (!empty($t['bukti_transaksi'])): ?>
                                        <a href="<?= base_url('uploads/tabungan/' . $t['bukti_transaksi']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i> Lihat
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada transaksi tabungan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>