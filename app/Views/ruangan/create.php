<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <p>Tambah Ruangan</p>
    <form action="<?= base_url('ruangan/store') ?>" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Penanggung Jawab</label>
            <select name="id_user" class="form-select">
                <option value="">-- Pilih Penanggung Jawab --</option>
                <?php foreach ($staf as $s): ?>
                    <option value="<?= $s['id_user'] ?>"><?= $s['username'] ?> (<?= $s['role'] ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3"><label>Nama Ruangan</label><input type="text" name="nama_ruangan" class="form-control" required></div>
        <div class="row">
            <div class="col-md-6 mb-3"><label>Latitude</label><input type="text" name="latitude" class="form-control"></div>
            <div class="col-md-6 mb-3"><label>Longitude</label><input type="text" name="longitude" class="form-control"></div>
        </div>
        <div class="mb-3"><label>Status</label><input type="text" name="status" class="form-control"></div>
        <div class="mb-3"><label>Keterangan</label><textarea name="ket" class="form-control"></textarea></div>
        <div class="mb-3"><label>Foto</label><input type="file" name="foto" class="form-control"></div>
        <button class="btn btn-success">Simpan</button>
        <a href="<?= base_url('ruangan') ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?= $this->endSection() ?>