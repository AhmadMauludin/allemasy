<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-success text-white">
        <p class="mb-0">Edit Kompetensi</p>
    </div>
    <div class="card-body">
        <form action="<?= base_url('kompetensi/update/' . $kompetensi['id_kompetensi']) ?>" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Jenis Kompetensi</label>
                <select name="jenis_kompetensi" class="form-select" required>
                    <option value="hafalan" <?= $kompetensi['jenis_kompetensi'] == 'hafalan' ? 'selected' : '' ?>>Hafalan</option>
                    <option value="lughotan" <?= $kompetensi['jenis_kompetensi'] == 'lughotan' ? 'selected' : '' ?>>Lughotan</option>
                    <option value="praktik" <?= $kompetensi['jenis_kompetensi'] == 'praktik' ? 'selected' : '' ?>>Praktik</option>
                    <option value="tes tulis" <?= $kompetensi['jenis_kompetensi'] == 'tes tulis' ? 'selected' : '' ?>>Tes Tulis</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Mapel</label>
                <select name="id_mapel" class="form-select">
                    <?php foreach ($mapel as $m): ?>
                        <option value="<?= $m['id_mapel'] ?>" <?= $kompetensi['id_mapel'] == $m['id_mapel'] ? 'selected' : '' ?>><?= esc($m['nama_mapel']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Buku</label>
                <select name="id_buku" class="form-select">
                    <?php foreach ($buku as $b): ?>
                        <option value="<?= $b['id_buku'] ?>" <?= $kompetensi['id_buku'] == $b['id_buku'] ? 'selected' : '' ?>><?= esc($b['judul']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Status</label>
                <input type="text" name="status" class="form-control" value="<?= esc($kompetensi['status']) ?>">
            </div>
            <div class="mb-3">
                <label>Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="3"><?= esc($kompetensi['keterangan']) ?></textarea>
            </div>
            <div class="mb-3">
                <label>Foto</label>
                <?php if ($kompetensi['foto']): ?>
                    <a href="<?= base_url('uploads/kompetensi/' . $kompetensi['foto']) ?>" target="_blank">Lihat Foto Lama</a>
                <?php endif; ?>
                <input type="file" name="foto" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="<?= base_url('kompetensi') ?>" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>