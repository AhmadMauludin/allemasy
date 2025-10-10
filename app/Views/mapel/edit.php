<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h2>Edit Mata Pelajaran</h2>

    <form action="<?= base_url('mapel/update/' . $mapel['id_mapel']); ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field(); ?>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Kode Mapel</label>
                <input type="text" name="kode_mapel" class="form-control" value="<?= esc($mapel['kode_mapel']); ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label>Nama Mapel</label>
                <input type="text" name="nama_mapel" class="form-control" value="<?= esc($mapel['nama_mapel']); ?>">
            </div>
        </div>

        <div class="mb-3">
            <label>Golongan</label>
            <input type="text" name="golongan" class="form-control" value="<?= esc($mapel['golongan']); ?>">
        </div>

        <div class="mb-3">
            <label>Tingkat</label>
            <select name="tingkat" class="form-select">
                <option value="1" <?= $mapel['tingkat'] == '1' ? 'selected' : ''; ?>>10</option>
                <option value="2" <?= $mapel['tingkat'] == '2' ? 'selected' : ''; ?>>11</option>
                <option value="3" <?= $mapel['tingkat'] == '3' ? 'selected' : ''; ?>>12</option>
                <option value="4" <?= $mapel['tingkat'] == '4' ? 'selected' : ''; ?>>10</option>
                <option value="5" <?= $mapel['tingkat'] == '5' ? 'selected' : ''; ?>>11</option>
                <option value="6" <?= $mapel['tingkat'] == '6' ? 'selected' : ''; ?>>12</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Buku</label>
            <select name="id_buku" class="form-select">
                <option value="">-- Pilih Buku --</option>
                <?php foreach ($buku as $b): ?>
                    <option value="<?= $b['id_buku']; ?>" <?= $b['id_buku'] == $mapel['id_buku'] ? 'selected' : ''; ?>>
                        <?= esc($b['judul']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select">
                <option value="aktif" <?= $mapel['status'] == 'aktif' ? 'selected' : ''; ?>>Aktif</option>
                <option value="nonaktif" <?= $mapel['status'] == 'nonaktif' ? 'selected' : ''; ?>>Nonaktif</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Keterangan</label>
            <textarea name="ket" class="form-control"><?= esc($mapel['ket']); ?></textarea>
        </div>

        <div class="mb-3">
            <label>Foto</label><br>
            <?php if ($mapel['foto']): ?>
                <img src="<?= base_url('uploads/mapel/' . $mapel['foto']); ?>" width="100" class="mb-2">
            <?php endif; ?>
            <input type="file" name="foto" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="<?= base_url('mapel'); ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?= $this->endSection() ?>