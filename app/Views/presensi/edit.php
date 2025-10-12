<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<div class="container mt-4">
    <h2>Edit Presensi</h2>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form action="<?= base_url('presensi/update/' . $presensi['id_presensi']) ?>" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Status Kehadiran</label>
            <select name="status" class="form-control" required>
                <option value="pending" <?= $presensi['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                <option value="hadir" <?= $presensi['status'] == 'hadir' ? 'selected' : '' ?>>Hadir</option>
                <option value="sakit" <?= $presensi['status'] == 'sakit' ? 'selected' : '' ?>>Sakit</option>
                <option value="ijin" <?= $presensi['status'] == 'ijin' ? 'selected' : '' ?>>Ijin</option>
                <option value="alfa" <?= $presensi['status'] == 'alfa' ? 'selected' : '' ?>>Alfa</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Keterangan</label>
            <textarea name="ket" class="form-control" rows="3" placeholder="Masukkan keterangan (contoh: Surat dokter, izin keluarga, dll)"><?= esc($presensi['ket']) ?></textarea>
        </div>

        <div class="mb-3">
            <label>Lampiran Surat (foto/pdf)</label>
            <input type="file" name="foto" class="form-control">

            <?php if (!empty($presensi['foto'])): ?>
                <div class="mt-2">
                    <a href="<?= base_url('uploads/bukti/' . $presensi['foto']) ?>" target="_blank" class="btn btn-sm btn-info">Lihat Lampiran</a>
                </div>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>

<?= $this->endSection(); ?>