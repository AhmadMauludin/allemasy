<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<p>Tambah Buku</p>
<form action="<?= base_url('buku/store') ?>" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label>Judul</label>
        <input type="text" name="judul" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Pengarang</label>
        <input type="text" name="pengarang" class="form-control">
    </div>
    <div class="mb-3">
        <label>Penerbit</label>
        <input type="text" name="penerbit" class="form-control">
    </div>
    <div class="mb-3">
        <label>Keilmuan</label>
        <input type="text" name="keilmuan" class="form-control">
    </div>
    <div class="mb-3">
        <label>Tahun</label>
        <input type="number" name="tahun" class="form-control">
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
    <a href="<?= base_url('buku') ?>" class="btn btn-secondary">Kembali</a>
</form>

<?= $this->endSection() ?>