<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h3>Edit Pengumpulan Tugas</h3>
    <hr>

    <form action="<?= base_url('pengumpulan_tugas/update/' . $pengumpulan['id_pengumpulan_tugas']) ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="lampiran_lama" value="<?= $pengumpulan['lampiran'] ?>">

        <div class="mb-3">
            <label class="form-label fw-bold">Status Saat Ini:</label>
            <div><?= esc(ucfirst($pengumpulan['status'])) ?></div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Nilai:</label>
            <div><?= $pengumpulan['nilai'] ? esc($pengumpulan['nilai']) : '-' ?></div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Catatan Guru:</label>
            <div><?= $pengumpulan['intruksi'] ? esc($pengumpulan['intruksi']) : '-' ?></div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Lampiran Sebelumnya:</label><br>
            <?php if ($pengumpulan['lampiran']): ?>
                <a href="<?= base_url('uploads/pengumpulan/' . $pengumpulan['lampiran']) ?>" target="_blank" class="btn btn-sm btn-info">
                    <i class="bi bi-file-earmark-text"></i> Lihat Lampiran
                </a>
            <?php else: ?>
                <span class="text-muted">Belum ada lampiran</span>
            <?php endif; ?>
        </div>

        <hr>

        <?php if (session()->get('role') == 'guru'): ?>
            <div class="mb-3">
                <label class="form-label">Ubah Status</label>
                <select name="status" class="form-control">
                    <option value="dikirim" <?= $pengumpulan['status'] == 'dikirim' ? 'selected' : '' ?>>Dikirim</option>
                    <option value="diterima" <?= $pengumpulan['status'] == 'diterima' ? 'selected' : '' ?>>Diterima</option>
                    <option value="ditolak" <?= $pengumpulan['status'] == 'ditolak' ? 'selected' : '' ?>>Ditolak</option>
                    <option value="selesai" <?= $pengumpulan['status'] == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Nilai</label>
                <input type="number" step="0.1" name="nilai" class="form-control" value="<?= esc($pengumpulan['nilai']) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Catatan / Intruksi</label>
                <textarea name="intruksi" class="form-control" rows="3"><?= esc($pengumpulan['intruksi']) ?></textarea>
            </div>

        <?php elseif (session()->get('role') == 'pesdik'): ?>
            <div class="alert alert-warning">
                <i class="bi bi-info-circle"></i> Anda hanya dapat mengubah lampiran tugas.
            </div>

            <div class="mb-3">
                <label class="form-label">Unggah Lampiran Baru</label>
                <input type="file" name="lampiran" class="form-control">
                <small class="text-muted">Kosongkan jika tidak ingin mengganti.</small>
            </div>
        <?php endif; ?>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Simpan Perubahan
            </button>
            <a href="javascript:history.back()" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>