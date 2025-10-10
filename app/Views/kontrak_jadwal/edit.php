<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h2>Edit Kontrak Jadwal</h2>

    <form action="<?= base_url('kontrak/update/' . $kontrak['id_kontrak_jadwal']); ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field(); ?>

        <div class="mb-3">
            <label>Mata Pelajaran</label>
            <select name="id_mapel" class="form-select">
                <?php foreach ($mapel as $m): ?>
                    <option value="<?= $m['id_mapel']; ?>" <?= $m['id_mapel'] == $kontrak['id_mapel'] ? 'selected' : ''; ?>>
                        <?= esc($m['nama_mapel']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Guru</label>
            <select name="id_user" class="form-select">
                <?php foreach ($guru as $g): ?>
                    <option value="<?= $g['id_user']; ?>" <?= $g['id_user'] == $kontrak['id_user'] ? 'selected' : ''; ?>>
                        <?= esc($g['username']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Kelas</label>
            <select name="id_kelas" class="form-select">
                <?php foreach ($kelas as $k): ?>
                    <option value="<?= $k['id_kelas']; ?>" <?= $k['id_kelas'] == $kontrak['id_kelas'] ? 'selected' : ''; ?>>
                        <?= esc($k['nama_kelas']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>tahun_ajaran</label>
            <select name="id_tahun_ajaran" class="form-select">
                <?php foreach ($tahun_ajaran as $ta): ?>
                    <option value="<?= $ta['id_tahun_ajaran']; ?>" <?= $ta['id_tahun_ajaran'] == $kontrak['id_tahun_ajaran'] ? 'selected' : ''; ?>>
                        <?= esc($ta['tahun']); ?> - <?= esc($ta['semester']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Jumlah Jam</label>
            <input type="number" name="jumlah_jam" class="form-control" value="<?= esc($kontrak['jumlah_jam']); ?>">
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select">
                <option value="aktif" <?= $kontrak['status'] == 'aktif' ? 'selected' : ''; ?>>Aktif</option>
                <option value="nonaktif" <?= $kontrak['status'] == 'nonaktif' ? 'selected' : ''; ?>>Nonaktif</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Keterangan</label>
            <textarea name="ket" class="form-control"><?= esc($kontrak['ket']); ?></textarea>
        </div>

        <div class="mb-3">
            <label>Foto</label><br>
            <?php if ($kontrak['foto']): ?>
                <img src="<?= base_url('uploads/kontrak/' . $kontrak['foto']); ?>" width="100" class="mb-2">
            <?php endif; ?>
            <input type="file" name="foto" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="<?= base_url('kontrak'); ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?= $this->endSection() ?>