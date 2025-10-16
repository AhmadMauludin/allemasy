<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<div class="container mt-4">
    <h4>Detail Biaya</h4>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Jenis Biaya:</strong> <?= esc($biaya['jenis_biaya']) ?></p>
            <p><strong>Peruntukan:</strong> <?= esc($biaya['peruntukan']) ?></p>
            <p><strong>Tingkat:</strong> <?= esc($biaya['tingkat']) ?></p>
            <p><strong>Biaya:</strong> <?= number_format($biaya['biaya'], 0, ',', '.') ?></p>
            <p><strong>Status:</strong> <?= esc($biaya['status_biaya']) ?></p>
            <p><strong>Keterangan:</strong> <?= esc($biaya['keterangan_biaya']) ?: '-' ?></p>
        </div>
    </div>

    <h5>Daftar Pembayaran</h5>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Pesdik</th>
                <th>Kelas</th>
                <th>Status Pembayaran</th>
                <th>Metode</th>
                <th>Aksi</th>

            </tr>
        </thead>
        <tbody>
            <?php if (!empty($pembayaran)): ?>
                <?php $no = 1;
                foreach ($pembayaran as $p): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($p['nama_pesdik']) ?></td>
                        <td><?= esc($p['nama_kelas']) ?></td>
                        <td>
                            <span class="badge 
                            <?= $p['status_pembayaran'] === 'dibayar' ? 'bg-success' : ($p['status_pembayaran'] === 'ditolak' ? 'bg-danger' : 'bg-warning') ?>">
                                <?= ucfirst($p['status_pembayaran']) ?>
                            </span>
                        </td>
                        <td><?= esc($p['metode']) ?></td>

                        <td>
                            <a href="<?= site_url('pembayaran/edit/' . $p['id_pembayaran']) ?>" class="btn btn-sm btn-primary">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data pembayaran</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="<?= base_url('biaya') ?>" class="btn btn-secondary mt-3">Kembali</a>
</div>

<?= $this->endSection(); ?>