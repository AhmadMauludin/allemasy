<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Tambah Pertemuan</h3>

<form action="<?= base_url('pertemuan/store') ?>" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label>Jadwal</label>
        <select name="id_jadwal" class="form-select" required>
            <option value="">-- Pilih Jadwal --</option>
            <?php foreach ($jadwal as $j): ?>
                <option value="<?= $j['id_jadwal'] ?>"><?= esc($j['nama_mapel']) ?> - <?= esc($j['hari']) ?> - Jam ke <?= esc($j['jampel']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label>Tanggal</label>
        <input type="date" name="tanggal" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-select">
            <option value="Dijadwalkan">Dijadwalkan</option>
            <option value="Hadir">Hadir</option>
            <option value="Tugas">Tugas</option>
            <option value="Alfa">Alfa</option>
        </select>
    </div>
    <div class="mb-3">
        <label>Materi</label>
        <input type="text" name="materi" class="form-control">
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
    <a href="<?= base_url('pertemuan') ?>" class="btn btn-secondary">Batal</a>
</form>

<?= $this->endSection() ?>