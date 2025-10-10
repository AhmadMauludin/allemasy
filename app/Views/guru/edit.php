<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Edit Guru</h3>
<form action="<?= base_url('guru/update/' . $guru['id_guru']) ?>" method="post" enctype="multipart/form-data" class="mt-3">

    <div class="mb-3">
        <label for="id_user" class="form-label">Pilih User (Guru)</label>
        <select name="id_user" class="form-select" required>
            <?php foreach ($users as $user): ?>
                <option value="<?= $user['id_user'] ?>" <?= $guru['id_user'] == $user['id_user'] ? 'selected' : '' ?>>
                    <?= esc($user['username']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label>NIP</label>
        <input type="text" name="nip" class="form-control" value="<?= esc($guru['nip']) ?>">
    </div>

    <div class="mb-3">
        <label>Nama Lengkap</label>
        <input type="text" name="nama" class="form-control" value="<?= esc($guru['nama']) ?>">
    </div>

    <div class="mb-3">
        <label>Alamat</label>
        <textarea name="alamat" class="form-control"><?= esc($guru['alamat']) ?></textarea>
    </div>

    <div class="mb-3">
        <label>Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" class="form-control" value="<?= esc($guru['tanggal_lahir']) ?>">
    </div>

    <div class="mb-3">
        <label>Telp</label>
        <input type="text" name="telp" class="form-control" value="<?= esc($guru['telp']) ?>">
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="<?= esc($guru['email']) ?>">
    </div>

    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-select">
            <option value="aktif" <?= $guru['status'] == 'aktif' ? 'selected' : '' ?>>Aktif</option>
            <option value="nonaktif" <?= $guru['status'] == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Foto</label>
        <input type="file" name="foto" class="form-control">
        <?php if ($guru['foto']): ?>
            <img src="<?= base_url('uploads/guru/' . $guru['foto']) ?>" width="80" class="mt-2">
        <?php endif; ?>
    </div>

    <button class="btn btn-success">Perbarui</button>
    <a href="<?= base_url('guru') ?>" class="btn btn-secondary">Kembali</a>
</form>

<?= $this->endSection() ?>