<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-success text-white">
        <p class="mb-0">Tambah Kompetensi</p>
    </div>
    <div class="card-body">
        <form action="<?= base_url('kompetensi/store') ?>" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Jenis Kompetensi</label>
                <select name="jenis_kompetensi" class="form-select" required>
                    <option value="">-- Pilih Jenis --</option>
                    <option value="hafalan">Hafalan</option>
                    <option value="lughotan">Lughotan</option>
                    <option value="praktik">Praktik</option>
                    <option value="tes tulis">Tes Tulis</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Mapel</label>
                <select name="id_mapel" class="form-select">
                    <option value="">-- Pilih Mapel --</option>
                    <?php foreach ($mapel as $m): ?>
                        <option value="<?= $m['id_mapel'] ?>"><?= esc($m['nama_mapel']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Buku</label>
                <select name="id_buku" class="form-select">
                    <option value="">-- Pilih Buku --</option>
                    <?php foreach ($buku as $b): ?>
                        <option value="<?= $b['id_buku'] ?>"><?= esc($b['judul']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Status</label>
                <input type="text" name="status" class="form-control" value="aktif">
            </div>
            <div class="mb-3">
                <label>Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label>Foto</label>
                <input type="file" name="foto" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="<?= base_url('kompetensi') ?>" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>