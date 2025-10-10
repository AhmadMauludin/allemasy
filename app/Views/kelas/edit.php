<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h3>Edit Kelas</h3>
    <form action="<?= base_url('kelas/update/' . $kelas['id_kelas']) ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="foto_lama" value="<?= $kelas['foto'] ?>">

        <div class="mb-3"><label>Nama Kelas</label><input type="text" name="nama_kelas" value="<?= $kelas['nama_kelas'] ?>" class="form-control" required></div>
        <div class="mb-3"><label>Tingkat</label><input type="text" name="tingkat" value="<?= $kelas['tingkat'] ?>" class="form-control"></div>

        <div class="mb-3">
            <label>Wali Kelas (Guru)</label>
            <select name="id_user" class="form-select">
                <?php foreach ($guru as $g): ?>
                    <option value="<?= $g['id_user'] ?>" <?= ($kelas['id_user'] == $g['id_user']) ? 'selected' : '' ?>>
                        <?= $g['username'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Ruangan</label>
            <select name="id_ruangan" class="form-select">
                <?php foreach ($ruangan as $r): ?>
                    <option value="<?= $r['id_ruangan'] ?>" <?= ($kelas['id_ruangan'] == $r['id_ruangan']) ? 'selected' : '' ?>>
                        <?= $r['nama_ruangan'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3"><label>Keterangan</label><textarea name="ket" class="form-control"><?= $kelas['ket'] ?></textarea></div>
        <div class="mb-3"><label>Status</label><input type="text" name="status" value="<?= $kelas['status'] ?>" class="form-control"></div>

        <div class="mb-3">
            <label>Foto</label><br>
            <?php if ($kelas['foto']): ?>
                <img src="<?= base_url('uploads/kelas/' . $kelas['foto']) ?>" width="80" class="mb-2 rounded"><br>
            <?php endif; ?>
            <input type="file" name="foto" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Perbarui</button>
        <a href="<?= base_url('kelas') ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?= $this->endSection() ?>