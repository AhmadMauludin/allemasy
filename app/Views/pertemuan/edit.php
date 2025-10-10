<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Edit Pertemuan</h3>

<form action="<?= base_url('pertemuan/update/' . $pertemuan['id_pertemuan']) ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="foto_lama" value="<?= esc($pertemuan['foto']) ?>">

    <div class="mb-3">
        <label>Jadwal</label>
        <select name="id_jadwal" class="form-select" required>
            <?php foreach ($jadwal as $j): ?>
                <option value="<?= $j['id_jadwal'] ?>" <?= $j['id_jadwal'] == $pertemuan['id_jadwal'] ? 'selected' : '' ?>>
                    <?= esc($j['nama_mapel']) ?> - <?= esc($j['nama_kelas']) ?> - <?= esc($j['hari']) ?> - Jam ke <?= esc($j['jampel']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label>Tanggal</label>
        <input type="date" name="tanggal" class="form-control" value="<?= esc($pertemuan['tanggal']) ?>">
    </div>
    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-select">
            <option value="Dijadwalkan" <?= $pertemuan['status'] == 'Dijadwalkan' ? 'selected' : '' ?>>Dijadwalkan</option>
            <option value="Hadir" <?= $pertemuan['status'] == 'Hadir' ? 'selected' : '' ?>>Hadir</option>
            <option value="Tugas" <?= $pertemuan['status'] == 'Tugas' ? 'selected' : '' ?>>Tugas</option>
            <option value="Alfa" <?= $pertemuan['status'] == 'Alfa' ? 'selected' : '' ?>>Alfa</option>
        </select>
    </div>
    <div class="mb-3">
        <label>Materi</label>
        <input type="text" name="materi" class="form-control" value="<?= esc($pertemuan['materi']) ?>">
    </div>
    <div class="mb-3">
        <label>Keterangan</label>
        <textarea name="ket" class="form-control"><?= esc($pertemuan['ket']) ?></textarea>
    </div>
    <div class="mb-3">
        <label>Foto</label><br>
        <?php if ($pertemuan['foto']): ?>
            <img src="<?= base_url('uploads/pertemuan/' . $pertemuan['foto']) ?>" width="120" class="mb-2"><br>
        <?php endif; ?>
        <input type="file" name="foto" class="form-control">
    </div>

    <button type="submit" class="btn btn-success">Perbarui</button>
    <a href="<?= base_url('pertemuan') ?>" class="btn btn-secondary">Kembali</a>
</form>

<?= $this->endSection() ?>