<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h2>Edit Jadwal</h2>

    <form action="<?= base_url('jadwal/update/' . $jadwal['id_jadwal']); ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field(); ?>

        <div class="mb-3">
            <label>Kontrak Jadwal</label>
            <select name="id_kontrak_jadwal" class="form-select">
                <?php foreach ($kontrak as $k): ?>
                    <option value="<?= $k['id_kontrak_jadwal']; ?>" <?= $k['id_kontrak_jadwal'] == $jadwal['id_kontrak_jadwal'] ? 'selected' : '' ?>>
                        <?= esc($k['nama_guru'] . ' - ' . $k['nama_mapel'] . ' - ' . $k['nama_kelas']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Hari</label>
            <select name="hari" class="form-select">
                <?php foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari): ?>
                    <option value="<?= $hari; ?>" <?= $hari == $jadwal['hari'] ? 'selected' : '' ?>><?= $hari; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Jam Pelajaran</label>
            <input type="text" name="jampel" class="form-control" value="<?= esc($jadwal['jampel']); ?>">
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Waktu Mulai</label>
                <input type="time" name="waktu_mulai" class="form-control" value="<?= esc($jadwal['waktu_mulai']); ?>">
            </div>
            <div class="col">
                <label>Waktu Selesai</label>
                <input type="time" name="waktu_selesai" class="form-control" value="<?= esc($jadwal['waktu_selesai']); ?>">
            </div>
        </div>

        <div class="mb-3">
            <label>Ruangan</label>
            <select name="id_ruangan" class="form-select">
                <?php foreach ($ruangan as $r): ?>
                    <option value="<?= $r['id_ruangan']; ?>" <?= $r['id_ruangan'] == $jadwal['id_ruangan'] ? 'selected' : '' ?>>
                        <?= esc($r['nama_ruangan']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select">
                <option value="aktif" <?= $jadwal['status'] == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                <option value="nonaktif" <?= $jadwal['status'] == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Keterangan</label>
            <textarea name="ket" class="form-control"><?= esc($jadwal['ket']); ?></textarea>
        </div>

        <div class="mb-3">
            <label>Foto</label><br>
            <?php if ($jadwal['foto']): ?>
                <img src="<?= base_url('uploads/jadwal/' . $jadwal['foto']); ?>" width="100" class="mb-2">
            <?php endif; ?>
            <input type="file" name="foto" class="form-control">
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="<?= base_url('jadwal'); ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?= $this->endSection() ?>