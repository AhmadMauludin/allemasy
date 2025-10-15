<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <p>Tambah Pesdik</p>
    <form action="<?= base_url('pesdik/store') ?>" method="post" enctype="multipart/form-data">
        <div class="mb-3"><label>NISN</label><input type="text" name="nisn" class="form-control"></div>
        <div class="mb-3"><label>NIS</label><input type="text" name="nis" class="form-control"></div>
        <div class="mb-3"><label>Tanggal Lahir</label><input type="date" name="tanggal_lahir" class="form-control"></div>
        <div class="mb-3"><label>Telp</label><input type="text" name="telp" class="form-control"></div>
        <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control"></div>
        <div class="mb-3"><label>Alamat</label><textarea name="alamat" class="form-control"></textarea></div>
        <div class="mb-3"><label>Status</label><input type="text" name="status" class="form-control"></div>
        <div class="mb-3"><label>Foto</label><input type="file" name="foto" class="form-control"></div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="<?= base_url('pesdik') ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?= $this->endSection() ?>