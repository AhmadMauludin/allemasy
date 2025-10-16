<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4><?= esc($title) ?></h4>
        <a href="<?= base_url('tabungan') ?>" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="<?= base_url('tabungan/update/' . $tabungan['id_tabungan']) ?>" method="post" enctype="multipart/form-data">

                <?php if ($role === 'admin'): ?>
                    <div class="mb-3">
                        <label for="id_pesdik" class="form-label">Pesdik</label>
                        <select name="id_pesdik" id="id_pesdik" class="form-select" required disabled>
                            <?php foreach ($pesdik as $p): ?>
                                <option value="<?= $p['id_pesdik'] ?>" <?= $p['id_pesdik'] == $tabungan['id_pesdik'] ? 'selected' : '' ?>>
                                    <?= esc($p['nama']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="jenis_transaksi" class="form-label">Jenis Transaksi</label>
                        <select name="jenis_transaksi" id="jenis_transaksi" class="form-select" required disabled>
                            <option value="setor" <?= $tabungan['jenis_transaksi'] == 'setor' ? 'selected' : '' ?>>Setor</option>
                            <option value="tarik" <?= $tabungan['jenis_transaksi'] == 'tarik' ? 'selected' : '' ?>>Tarik</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah (Rp)</label>
                        <input type="number" name="jumlah" id="jumlah" class="form-control" required value="<?= esc($tabungan['jumlah']) ?>">
                    </div>

                    <div class="mb-3">
                        <label for="status_transaksi" class="form-label">Status</label>
                        <select name="status_transaksi" id="status_transaksi" class="form-select" required>
                            <option value="pending" <?= $tabungan['status_transaksi'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="disetujui" <?= $tabungan['status_transaksi'] == 'disetujui' ? 'selected' : '' ?>>Disetujui</option>
                            <option value="ditolak" <?= $tabungan['status_transaksi'] == 'ditolak' ? 'selected' : '' ?>>Ditolak</option>
                        </select>
                    </div>
                <?php endif; ?>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <input type="text" name="keterangan" id="keterangan" class="form-control" value="<?= esc($tabungan['keterangan']) ?>">
                </div>

                <div class="mb-3">
                    <label for="bukti_transaksi" class="form-label">Bukti Transaksi</label>
                    <input type="file" name="bukti_transaksi" id="bukti_transaksi" class="form-control" accept="image/*">
                    <?php if (!empty($tabungan['bukti_transaksi'])): ?>
                        <div class="mt-2">
                            <a href="<?= base_url('uploads/tabungan/' . $tabungan['bukti_transaksi']) ?>" target="_blank">
                                <img src="<?= base_url('uploads/tabungan/' . $tabungan['bukti_transaksi']) ?>" width="100" class="rounded border">
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>