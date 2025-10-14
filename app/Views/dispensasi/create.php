<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        Tambah Dispensasi
    </div>
    <div class="card-body">
        <form action="<?= base_url('dispensasi/store'); ?>" method="post">

            <div class="mb-3">
                <label>Pesdik</label>
                <select name="id_user_pesdik" class="form-select" required>
                    <option value="">-- Pilih Pesdik --</option>
                    <?php foreach ($pesdik as $p): ?>
                        <option value="<?= $p['id_user']; ?>"><?= esc($p['username']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label>Tanggal</label>
                <input type="date" name="tanggal" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Alasan</label>
                <textarea name="alasan" class="form-control" required></textarea>
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-select">
                    <option value="pending">Pending</option>
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Keterangan</label>
                <textarea name="ket" class="form-control"></textarea>
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="<?= base_url('dispensasi'); ?>" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>