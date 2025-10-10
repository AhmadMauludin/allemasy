<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h3>Edit Ruangan</h3>
    <form action="<?= base_url('ruangan/update/' . $ruangan['id_ruangan']) ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="foto_lama" value="<?= $ruangan['foto'] ?>">

        <div class="mb-3">
            <label>Penanggung Jawab</label>
            <select name="id_user" class="form-select">
                <option value="">-- Pilih Penanggung Jawab --</option>
                <?php foreach ($staf as $s): ?>
                    <option value="<?= $s['id_user'] ?>" <?= ($ruangan['id_user'] == $s['id_user']) ? 'selected' : '' ?>>
                        <?= $s['username'] ?> (<?= $s['role'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3"><label>Nama Ruangan</label><input type="text" name="nama_ruangan" value="<?= $ruangan['nama_ruangan'] ?>" class="form-control"></div>
        <div class="row">
            <div class="col-md-6 mb-3"><label>Latitude</label><input type="text" name="latitude" value="<?= $ruangan['latitude'] ?>" class="form-control"></div>
            <div class="col-md-6 mb-3"><label>Longitude</label><input type="text" name="longitude" value="<?= $ruangan['longitude'] ?>" class="form-control"></div>
        </div>
        <div class="mb-3"><label>Status</label><input type="text" name="status" value="<?= $ruangan['status'] ?>" class="form-control"></div>
        <div class="mb-3"><label>Keterangan</label><textarea name="ket" class="form-control"><?= $ruangan['ket'] ?></textarea></div>

        <div class="mb-3">
            <label>Foto</label><br>
            <?php if ($ruangan['foto']): ?>
                <img src="<?= base_url('uploads/ruangan/' . $ruangan['foto']) ?>" width="80" class="mb-2 rounded"><br>
            <?php endif; ?>
            <input type="file" name="foto" class="form-control">
        </div>

        <button class="btn btn-primary">Perbarui</button>
        <a href="<?= base_url('ruangan') ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?= $this->endSection() ?>