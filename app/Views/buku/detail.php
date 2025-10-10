<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h2>Detail Buku</h2>
    <div class="card shadow-sm border-0 mt-3">
        <div class="row g-0">
            <div class="col-md-3 text-center p-3">
                <?php if ($buku['foto']): ?>
                    <img src="<?= base_url('uploads/buku/' . $buku['foto']); ?>" alt="Foto Buku" class="img-fluid rounded">
                <?php else: ?>
                    <img src="<?= base_url('assets/img/no-image.png'); ?>" alt="No Image" class="img-fluid rounded">
                <?php endif; ?>
            </div>
            <div class="col-md-9">
                <div class="card-body">
                    <h4 class="card-title"><?= esc($buku['judul']); ?></h4>
                    <p><strong>Pengarang:</strong> <?= esc($buku['pengarang']); ?></p>
                    <p><strong>Penerbit:</strong> <?= esc($buku['penerbit']); ?></p>
                    <p><strong>Bidang Keilmuan:</strong> <?= esc($buku['keilmuan']); ?></p>
                    <p><strong>Tahun Terbit:</strong> <?= esc($buku['tahun']); ?></p>
                    <p><strong>Status:</strong>
                        <span class="badge bg-<?= $buku['status'] == 'tersedia' ? 'success' : 'danger'; ?>">
                            <?= ucfirst($buku['status']); ?>
                        </span>
                    </p>
                    <p><strong>Keterangan:</strong> <?= esc($buku['ket']); ?></p>

                    <a href="<?= base_url('buku/edit/' . $buku['id_buku']); ?>" class="btn btn-warning">Edit</a>
                    <a href="<?= base_url('buku'); ?>" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>