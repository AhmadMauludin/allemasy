<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <p>Edit Pesdik</p>
    <form action="<?= base_url('pesdik/update/' . $pesdik['id_pesdik']) ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="foto_lama" value="<?= $pesdik['foto'] ?>">

        <div class="mb-3">
            <label>Kelas</label>
            <select name="id_kelas" class="form-select" required>
                <option value="">-- Pilih Kelas --</option>
                <?php foreach ($kelas as $k): ?>
                    <option value="<?= $k['id_kelas'] ?>" <?= ($pesdik['id_kelas'] == $k['id_kelas']) ? 'selected' : '' ?>>
                        <?= $k['nama_kelas'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3"><label>NISN</label><input type="text" name="nisn" value="<?= $pesdik['nisn'] ?>" class="form-control"></div>
        <div class="mb-3"><label>NIS</label><input type="text" name="nis" value="<?= $pesdik['nis'] ?>" class="form-control"></div>
        <div class="mb-3"><label>Nama Lengkap</label><input type="text" name="nama" value="<?= $pesdik['nama'] ?>" class="form-control"></div>
        <div class="mb-3">
            <label>Jenis Kelamin</label>
            <select name="jk" class="form-select" required>
                <option value="">-- Pilih jk --</option>
                <option value="l" <?= ($pesdik['jk'] == 'l') ? 'selected' : '' ?>>
                    Laki - laki
                </option>
                <option value="p" <?= ($pesdik['jk'] == 'p') ? 'selected' : '' ?>>
                    Perempuan
                </option>
            </select>
        </div>
        <div class="mb-3"><label>Tanggal Lahir</label><input type="date" name="tanggal_lahir" value="<?= $pesdik['tanggal_lahir'] ?>" class="form-control"></div>
        <div class="mb-3"><label>Telp</label><input type="text" name="telp" value="<?= $pesdik['telp'] ?>" class="form-control"></div>
        <div class="mb-3"><label>Email</label><input type="email" name="email" value="<?= $pesdik['email'] ?>" class="form-control"></div>
        <div class="mb-3"><label>Alamat</label><textarea name="alamat" class="form-control"><?= $pesdik['alamat'] ?></textarea></div>
        <div class="mb-3"><label>Status</label><input type="text" name="status" value="<?= $pesdik['status'] ?>" class="form-control"></div>

        <div class="mb-3">
            <label>Foto</label><br>
            <?php if ($pesdik['foto']): ?>
                <img src="<?= base_url('uploads/pesdik/' . $pesdik['foto']) ?>" width="80" class="mb-2 rounded"><br>
            <?php endif; ?>
            <input type="file" name="foto" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Perbarui</button>
        <a href="<?= base_url('pesdik') ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?= $this->endSection() ?>