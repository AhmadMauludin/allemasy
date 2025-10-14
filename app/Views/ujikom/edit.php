<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<div class="card shadow-sm mb-4">
    <div class="card-header bg-warning text-white">Edit Ujikom</div>
    <div class="card-body">
        <form action="<?= base_url('ujikom/update/' . $ujikom['id_ujikom']); ?>" method="post" enctype="multipart/form-data">

            <div class="mb-3">
                <label>Waktu</label>
                <input type="datetime-local" name="waktu" value="<?= date('Y-m-d\TH:i', strtotime($ujikom['waktu'])); ?>" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="dijadwalkan" <?= $ujikom['status'] == 'dijadwalkan' ? 'selected' : ''; ?>>Dijadwalkan</option>
                    <option value="selesai" <?= $ujikom['status'] == 'selesai' ? 'selected' : ''; ?>>Selesai</option>
                    <option value="ulang" <?= $ujikom['status'] == 'ulang' ? 'selected' : ''; ?>>Ulang</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Rincian</label>
                <textarea name="rincian" class="form-control"><?= esc($ujikom['rincian']); ?></textarea>
            </div>

            <div class="mb-3">
                <label>Foto</label>
                <?php if ($ujikom['foto']): ?>
                    <img src="<?= base_url('uploads/ujikom/' . $ujikom['foto']); ?>" width="100" class="d-block mb-2">
                <?php endif; ?>
                <input type="file" name="foto" class="form-control">
            </div>

            <button type="submit" class="btn btn-success">Perbarui</button>
            <a href="<?= base_url('ujikom/index/' . $ujikom['id_kompetensi_pesdik']); ?>" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
<?= $this->endSection(); ?>