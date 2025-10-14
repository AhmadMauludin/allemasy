<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">Tambah Kompetensi Peserta Didik</div>
    <div class="card-body">
        <form action="<?= base_url('kompetensi_pesdik/store') ?>" method="post">
            <input type="hidden" name="id_kompetensi" value="<?= $id_kompetensi ?>">

            <div class="mb-3">
                <label>Pesdik</label>
                <select name="id_pesdik" class="form-select" required>
                    <option value="">-- Pilih Pesdik --</option>
                    <?php foreach ($pesdik as $p): ?>
                        <option value="<?= $p['id_user'] ?>"><?= esc($p['username']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label>Guru</label>
                <select name="id_guru" class="form-select" required>
                    <option value="">-- Pilih Guru --</option>
                    <?php foreach ($guru as $g): ?>
                        <option value="<?= $g['id_user'] ?>"><?= esc($g['username']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label>Nomor SK</label>
                <input type="text" name="nomor_sk" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-select" required>
                    <option value="pending">Pending</option>
                    <option value="berjalan">Berjalan</option>
                    <option value="selesai">Selesai</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Predikat</label>
                <select name="predikat" class="form-select">
                    <option value="cukup">Cukup</option>
                    <option value="baik">Baik</option>
                    <option value="sempurna">Sempurna</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" class="form-control">
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="<?= base_url('kompetensi_pesdik/index/' . $id_kompetensi) ?>" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>