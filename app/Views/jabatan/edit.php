<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<p>Edit Jabatan</p>
<form action="<?= base_url('jabatan/update/' . $jabatan['id_jabatan']) ?>" method="post">

    <div class="mb-3">
        <label>User</label>
        <select name="id_user" class="form-select">
            <?php foreach ($users as $user): ?>
                <option value="<?= $user['id_user'] ?>" <?= $jabatan['id_user'] == $user['id_user'] ? 'selected' : '' ?>>
                    <?= esc($user['nama']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label>Jabatan</label>
        <input type="text" name="jabatan" class="form-control" value="<?= esc($jabatan['jabatan']) ?>">
    </div>

    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-select">
            <option value="aktif" <?= $jabatan['status'] == 'aktif' ? 'selected' : '' ?>>Aktif</option>
            <option value="nonaktif" <?= $jabatan['status'] == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
        </select>
    </div>

    <button class="btn btn-success">Update</button>
    <a href="<?= base_url('jabatan') ?>" class="btn btn-secondary">Kembali</a>
</form>

<?= $this->endSection() ?>