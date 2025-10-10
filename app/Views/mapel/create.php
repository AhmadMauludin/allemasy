<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h2>Tambah Mata Pelajaran</h2>

    <form action="<?= base_url('mapel/store'); ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field(); ?>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Kode Mapel</label>
                <input type="text" name="kode_mapel" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Nama Mapel</label>
                <input type="text" name="nama_mapel" class="form-control" required>
            </div>
        </div>

        <div class="mb-3">
            <label>Golongan</label>
            <input type="text" name="golongan" class="form-control">
        </div>

        <div class="mb-3">
            <label>Tingkat</label>
            <select name="tingkat" class="form-select">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>

            </select>
        </div>

        <div class="mb-3">
            <label>Buku</label>
            <select name="id_buku" class="form-select">
                <option value="">-- Pilih Buku --</option>
                <?php foreach ($buku as $b): ?>
                    <option value="<?= $b['id_buku']; ?>"><?= esc($b['judul']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select">
                <option value="aktif">Aktif</option>
                <option value="nonaktif">Nonaktif</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Keterangan</label>
            <textarea name="ket" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Foto</label>
            <input type="file" name="foto" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="<?= base_url('mapel'); ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?= $this->endSection() ?>