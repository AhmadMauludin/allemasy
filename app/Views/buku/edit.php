<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h2>Edit Data Buku</h2>
    <form action="<?= base_url('buku/update/' . $buku['id_buku']); ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field(); ?>

        <div class="mb-3">
            <label for="judul" class="form-label">Judul Buku</label>
            <input type="text" name="judul" id="judul" class="form-control" value="<?= esc($buku['judul']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="pengarang" class="form-label">Pengarang</label>
            <input type="text" name="pengarang" id="pengarang" class="form-control" value="<?= esc($buku['pengarang']); ?>">
        </div>

        <div class="mb-3">
            <label for="penerbit" class="form-label">Penerbit</label>
            <input type="text" name="penerbit" id="penerbit" class="form-control" value="<?= esc($buku['penerbit']); ?>">
        </div>

        <div class="mb-3">
            <label for="keilmuan" class="form-label">Bidang Keilmuan</label>
            <input type="text" name="keilmuan" id="keilmuan" class="form-control" value="<?= esc($buku['keilmuan']); ?>">
        </div>

        <div class="mb-3">
            <label for="tahun" class="form-label">Tahun Terbit</label>
            <input type="number" name="tahun" id="tahun" class="form-control" value="<?= esc($buku['tahun']); ?>">
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select">
                <option value="tersedia" <?= $buku['status'] == 'tersedia' ? 'selected' : ''; ?>>Tersedia</option>
                <option value="dipinjam" <?= $buku['status'] == 'dipinjam' ? 'selected' : ''; ?>>Dipinjam</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="ket" class="form-label">Keterangan</label>
            <textarea name="ket" id="ket" class="form-control"><?= esc($buku['ket']); ?></textarea>
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Foto Buku</label><br>
            <?php if ($buku['foto']): ?>
                <img src="<?= base_url('uploads/buku/' . $buku['foto']); ?>" alt="Foto Buku" class="img-thumbnail mb-2" width="120">
            <?php endif; ?>
            <input type="file" name="foto" id="foto" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="<?= base_url('buku'); ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?= $this->endSection() ?>