<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h2>Tambah Kontrak Jadwal</h2>

    <form action="<?= base_url('kontrak/store'); ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field(); ?>

        <div class="mb-3">
            <label>Mata Pelajaran</label>
            <select name="id_mapel" class="form-select" required>
                <option value="">-- Pilih Mapel --</option>
                <?php foreach ($mapel as $m): ?>
                    <option value="<?= $m['id_mapel']; ?>"><?= esc($m['nama_mapel']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Guru</label>
            <select name="id_user" class="form-select" required>
                <option value="">-- Pilih Guru --</option>
                <?php foreach ($guru as $g): ?>
                    <option value="<?= $g['id_user']; ?>"><?= esc($g['username']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Kelas</label>
            <select name="id_kelas" class="form-select" required>
                <option value="">-- Pilih Kelas --</option>
                <?php foreach ($kelas as $k): ?>
                    <option value="<?= $k['id_kelas']; ?>"><?= esc($k['nama_kelas']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Kelas</label>
            <select name="id_tahun_ajaran" class="form-select" required>
                <option value="">-- Pilih Tahun Ajaran --</option>
                <?php foreach ($tahun_ajaran as $ta): ?>
                    <option value="<?= $ta['id_tahun_ajaran']; ?>"><?= esc($ta['tahun']); ?> - <?= esc($ta['semester']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Jumlah Jam</label>
            <input type="number" name="jumlah_jam" class="form-control" required>
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

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="<?= base_url('kontrak'); ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?= $this->endSection() ?>