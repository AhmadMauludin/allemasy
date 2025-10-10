<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h3>Tambah Kelas</h3>
    <form action="<?= base_url('kelas/store') ?>" method="post" enctype="multipart/form-data">
        <div class="mb-3"><label>Nama Kelas</label><input type="text" name="nama_kelas" class="form-control" required></div>
        <div class="mb-3"><label>Tingkat</label><input type="text" name="tingkat" class="form-control"></div>

        <div class="mb-3">
            <label>Wali Kelas (Guru)</label>
            <select name="id_user" class="form-select" required>
                <option value="">-- Pilih Guru --</option>
                <?php foreach ($guru as $g): ?>
                    <option value="<?= $g['id_user'] ?>"><?= $g['username'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Ruangan</label>
            <select name="id_ruangan" class="form-select" required>
                <option value="">-- Pilih Ruangan --</option>
                <?php foreach ($ruangan as $r): ?>
                    <option value="<?= $r['id_ruangan'] ?>"><?= $r['nama_ruangan'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3"><label>Keterangan</label><textarea name="ket" class="form-control"></textarea></div>
        <div class="mb-3"><label>Status</label><input type="text" name="status" class="form-control"></div>
        <div class="mb-3"><label>Foto</label><input type="file" name="foto" class="form-control"></div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="<?= base_url('kelas') ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?= $this->endSection() ?>