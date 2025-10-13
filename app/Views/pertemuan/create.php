<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <p class="mb-0">Tambah Pertemuan </p>
        </div>
        <div class="card-body">
            <?php if (isset($id_jadwal)): ?>
                <p>Jadwal: <?= esc($jadwal['nama_mapel']) ?> - <?= esc($jadwal['nama_kelas']) ?> - <?= esc($jadwal['hari']) ?> - Jam ke <?= esc($jadwal['jampel']) ?></p>
            <?php endif; ?>

            <form action="<?= base_url('pertemuan/store') ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_jadwal" value="<?= $id_jadwal ?>">
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
        </div>
    </div>
</div>
<?= $this->endSection() ?>