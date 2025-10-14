<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-warning text-white">Edit Kompetensi Peserta Didik</div>
    <div class="card-body">
        <form action="<?= base_url('kompetensi_pesdik/update/' . $kp['id_kompetensi_pesdik']) ?>" method="post">
            <div class="mb-3">
                <label>Pesdik</label>
                <select name="id_pesdik" class="form-select" required>
                    <?php foreach ($pesdik as $p): ?>
                        <option value="<?= $p['id_user'] ?>" <?= $kp['id_pesdik'] == $p['id_user'] ? 'selected' : '' ?>>
                            <?= esc($p['username']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label>Guru</label>
                <select name="id_guru" class="form-select" required>
                    <?php foreach ($guru as $g): ?>
                        <option value="<?= $g['id_user'] ?>" <?= $kp['id_guru'] == $g['id_user'] ? 'selected' : '' ?>>
                            <?= esc($g['username']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label>Nomor SK</label>
                <input type="text" name="nomor_sk" class="form-control" value="<?= esc($kp['nomor_sk']) ?>">
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-select">
                    <?php foreach (['pending', 'berjalan', 'selesai'] as $s): ?>
                        <option value="<?= $s ?>" <?= $kp['status'] == $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label>Predikat</label>
                <select name="predikat" class="form-select">
                    <?php foreach (['cukup', 'baik', 'sempurna'] as $p): ?>
                        <option value="<?= $p ?>" <?= $kp['predikat'] == $p ? 'selected' : '' ?>><?= ucfirst($p) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label>Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" class="form-control" value="<?= esc($kp['tanggal_selesai']) ?>">
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="<?= base_url('kompetensi_pesdik/index/' . $kp['id_kompetensi']) ?>" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>