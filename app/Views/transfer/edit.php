<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<div class="container mt-4">
    <h4>Verifikasi Transfer</h4>

    <form action="<?= base_url('transfer/update/' . $transfer['id_transfer']) ?>" method="POST">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label>Status Transfer</label>
            <select name="status_transfer" class="form-control">
                <option value="pending" <?= $transfer['status_transfer'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                <option value="diterima" <?= $transfer['status_transfer'] == 'diterima' ? 'selected' : '' ?>>Diterima</option>
                <option value="ditolak" <?= $transfer['status_transfer'] == 'ditolak' ? 'selected' : '' ?>>Ditolak</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Keterangan</label>
            <textarea name="keterangan_transfer" class="form-control"><?= esc($transfer['keterangan_transfer']) ?></textarea>
        </div>

        <button type="submit" class="btn btn-success">Simpan Verifikasi</button>
        <a href="<?= base_url('transfer') ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?= $this->endSection(); ?>