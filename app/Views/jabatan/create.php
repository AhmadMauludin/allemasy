<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<p>Tambah Jabatan</p>
<form action="<?= base_url('jabatan/store') ?>" method="post">

    <div class="mb-3">
        <label>User</label>
        <select name="id_user" class="form-select">
            <option value="">-- Pilih User --</option>
            <?php foreach ($users as $user): ?>
                <option value="<?= $user['id_user'] ?>"><?= esc($user['nama']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label>Jabatan</label>
        <input type="text" name="jabatan" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-select">
            <option value="aktif">Aktif</option>
            <option value="nonaktif">Nonaktif</option>
        </select>
    </div>

    <button class="btn btn-primary">Simpan</button>
    <a href="<?= base_url('jabatan') ?>" class="btn btn-secondary">Kembali</a>
</form>

<?= $this->endSection() ?>