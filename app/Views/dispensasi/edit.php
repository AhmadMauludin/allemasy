<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-warning text-dark">
        Edit Dispensasi
    </div>
    <div class="card-body">
        <form action="<?= base_url('dispensasi/update/' . $dispensasi['id_dispensasi']); ?>" method="post">

            <div class="mb-3">
                <label>Pesdik</label>
                <select name="id_user_pesdik" class="form-select" required>
                    <?php foreach ($pesdik as $p): ?>
                        <option value="<?= $p['id_user']; ?>" <?= $p['id_user'] == $dispensasi['id_user_pesdik'] ? 'selected' : ''; ?>>
                            <?= esc($p['username']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label>Tanggal</label>
                <input type="date" name="tanggal" class="form-control" value="<?= esc($dispensasi['tanggal']); ?>" required>
            </div>

            <div class="mb-3">
                <label>Alasan</label>
                <textarea name="alasan" class="form-control" required><?= esc($dispensasi['alasan']); ?></textarea>
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-select">
                    <option value="pending" <?= $dispensasi['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                    <option value="aktif" <?= $dispensasi['status'] == 'aktif' ? 'selected' : ''; ?>>Aktif</option>
                    <option value="nonaktif" <?= $dispensasi['status'] == 'nonaktif' ? 'selected' : ''; ?>>Nonaktif</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Keterangan</label>
                <textarea name="ket" class="form-control"><?= esc($dispensasi['ket']); ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="<?= base_url('dispensasi'); ?>" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>