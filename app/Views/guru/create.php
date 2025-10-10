<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Tambah Guru</h3>
<form action="<?= base_url('guru/store') ?>" method="post" enctype="multipart/form-data" class="mt-3">

    <div class="mb-3">
        <label for="id_user" class="form-label">Pilih User (Guru)</label>
        <select name="id_user" class="form-select" required>
            <option value="">-- Pilih --</option>
            <?php foreach ($users as $user): ?>
                <option value="<?= $user['id_user'] ?>"><?= esc($user['username']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label>NIP</label>
        <input type="text" name="nip" class="form-control">
    </div>

    <div class="mb-3">
        <label>Alamat</label>
        <textarea name="alamat" class="form-control"></textarea>
    </div>

    <div class="mb-3">
        <label>Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" class="form-control">
    </div>

    <div class="mb-3">
        <label>Telp</label>
        <input type="text" name="telp" class="form-control">
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control">
    </div>

    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-select">
            <option value="aktif">Aktif</option>
            <option value="nonaktif">Nonaktif</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Foto</label>
        <input type="file" name="foto" class="form-control">
    </div>

    <button class="btn btn-primary">Simpan</button>
    <a href="<?= base_url('guru') ?>" class="btn btn-secondary">Kembali</a>
</form>

<?= $this->endSection() ?>