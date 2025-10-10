<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h2>Tambah Jadwal Pelajaran</h2>

    <form action="<?= base_url('jadwal/store'); ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field(); ?>

        <div class="mb-3">
            <label>Kontrak Jadwal (Guru - Mapel - Kelas)</label>
            <select name="id_kontrak_jadwal" class="form-select" required>
                <option value="">-- Pilih Kontrak Jadwal --</option>
                <?php foreach ($kontrak as $k): ?>
                    <option value="<?= $k['id_kontrak_jadwal']; ?>">
                        <?= esc($k['nama_guru'] . ' - ' . $k['nama_mapel'] . ' - ' . $k['nama_kelas']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Hari</label>
            <select name="hari" class="form-select" required>
                <option value="">-- Pilih Hari --</option>
                <?php foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari): ?>
                    <option value="<?= $hari; ?>"><?= $hari; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Jam Pelajaran</label>
            <input type="text" name="jampel" class="form-control" placeholder="Contoh: 1-2" required>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Waktu Mulai</label>
                <input type="time" name="waktu_mulai" class="form-control" required>
            </div>
            <div class="col">
                <label>Waktu Selesai</label>
                <input type="time" name="waktu_selesai" class="form-control" required>
            </div>
        </div>

        <div class="mb-3">
            <label>Ruangan</label>
            <select name="id_ruangan" class="form-select">
                <option value="">-- Pilih Ruangan --</option>
                <?php foreach ($ruangan as $r): ?>
                    <option value="<?= $r['id_ruangan']; ?>"><?= esc($r['nama_ruangan']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select">
                <option value="aktif">Aktif</option>
                <option value="nonaktif">Nonaktif</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Keterangan</label>
            <textarea name="ket" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Foto</label>
            <input type="file" name="foto" class="form-control">
        </div>

        <button class="btn btn-success">Simpan</button>
        <a href="<?= base_url('jadwal'); ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?= $this->endSection() ?>