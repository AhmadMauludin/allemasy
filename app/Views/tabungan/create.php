<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4><?= esc($title) ?></h4>
        <a href="<?= base_url('tabungan') ?>" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="<?= base_url('tabungan/store') ?>" method="post" enctype="multipart/form-data">

                <?php if ($role === 'admin'): ?>
                    <div class="mb-3">
                        <label for="id_pesdik" class="form-label">Pesdik</label>
                        <select name="id_pesdik" id="id_pesdik" class="form-select" required>
                            <option value="">-- Pilih Pesdik --</option>
                            <?php foreach ($pesdik as $p): ?>
                                <option value="<?= $p['id_pesdik'] ?>"><?= esc($p['nama']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endif; ?>

                <div class="mb-3">
                    <label for="jenis_transaksi" class="form-label">Jenis Transaksi</label>
                    <select name="jenis_transaksi" id="jenis_transaksi" class="form-select" required>
                        <option value="">-- Pilih Jenis --</option>
                        <option value="setor">Setor</option>
                        <option value="tarik">Tarik</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah (Rp)</label>
                    <input type="number" name="jumlah" id="jumlah" class="form-control" required min="1000" step="100">
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <input type="text" name="keterangan" id="keterangan" class="form-control" placeholder="Opsional">
                </div>

                <div class="mb-3">
                    <label for="bukti_transaksi" class="form-label">Bukti Transaksi</label>
                    <input type="file" name="bukti_transaksi" id="bukti_transaksi" class="form-control" accept="image/*">
                    <?php if ($role === 'pesdik'): ?>
                        <small class="text-muted">* wajib diisi untuk pengajuan setor</small>
                    <?php endif; ?>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan Transaksi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>