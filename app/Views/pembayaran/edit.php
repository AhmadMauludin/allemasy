<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<div class="container mt-4">
    <h4>Edit Pembayaran</h4>

    <form action="<?= base_url('pembayaran/update/' . $pembayaran['id_pembayaran']) ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <?php if (session('role') === 'admin'): ?>
            <div class="mb-3">
                <label>Status Pembayaran</label>
                <select name="status_pembayaran" class="form-control">
                    <option value="belum dibayar" <?= $pembayaran['status_pembayaran'] == 'belum dibayar' ? 'selected' : '' ?>>Belum Dibayar</option>
                    <option value="dibayar" <?= $pembayaran['status_pembayaran'] == 'dibayar' ? 'selected' : '' ?>>Dibayar</option>
                    <option value="ditolak" <?= $pembayaran['status_pembayaran'] == 'ditolak' ? 'selected' : '' ?>>Ditolak</option>
                </select>
            </div>
        <?php endif; ?>

        <div class="mb-3">
            <label>Metode</label>
            <select name="metode" class="form-control">
                <option value="tunai" <?= $pembayaran['metode'] == 'tunai' ? 'selected' : '' ?>>Tunai</option>
                <option value="transfer" <?= $pembayaran['metode'] == 'transfer' ? 'selected' : '' ?>>Transfer</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Bukti</label>
            <input type="file" name="bukti" class="form-control">
            <?php if ($pembayaran['bukti']): ?>
                <img src="<?= base_url('uploads/pembayaran/' . $pembayaran['bukti']) ?>" width="100">
            <?php endif; ?>
        </div>

        <?php if (session('role') === 'admin'): ?>
            <div class="mb-3">
                <label>Keterangan</label>
                <textarea name="keterangan_bayar" class="form-control"><?= esc($pembayaran['keterangan_bayar']) ?></textarea>
            </div>
        <?php endif; ?>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="<?= base_url('biaya') ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?= $this->endSection(); ?>