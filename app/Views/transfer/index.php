<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Data Transfer</h4>
        <?php if (session('role') === 'pesdik'): ?>
            <a href="<?= base_url('transfer/create') ?>" class="btn btn-outline-success">
                <i class="bi bi-plus-circle"></i> Tambah Transfer
            </a>
        <?php endif; ?>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php elseif (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <!-- 🔍 Form Pencarian -->
            <form action="<?= base_url('transfer') ?>" method="get" class="row g-3">
                <?php if (session()->get('role') === 'admin'): ?>
                    <div class="col-md-3">
                        <input type="text" name="keyword" class="form-control" placeholder="Cari nama pesdik..." value="<?= esc($keyword) ?>">
                    </div>
                <?php endif; ?>

                <div class="col-md-3">
                    <input type="date" name="tanggal" class="form-control" value="<?= esc($tanggal) ?>">
                </div>
                <div class="col-md-3">
                    <select name="peruntukan" class="form-select">
                        <option value="">-- Semua Peruntukan --</option>
                        <option value="bekal" <?= $peruntukan === 'bekal' ? 'selected' : '' ?>>Bekal</option>
                        <option value="biaya sekolah" <?= $peruntukan === 'biaya sekolah' ? 'selected' : '' ?>>Biaya Sekolah</option>
                        <option value="biaya pesantren" <?= $peruntukan === 'biaya pesantren' ? 'selected' : '' ?>>Biaya Pesantren</option>
                        <option value="biaya lainnya" <?= $peruntukan === 'biaya lainnya' ? 'selected' : '' ?>>Biaya Lainnya</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-outline-primary me-2"><i class="bi bi-search"></i> Cari</button>
                    <a href="<?= base_url('transfer') ?>" class="btn btn-outline-secondary"><i class="bi bi-arrow-repeat"></i> Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <?php if (session()->get('role') === 'admin'): ?>
                            <th>Nama Pesdik</th>
                        <?php endif; ?>
                        <th>Peruntukan</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Waktu</th>
                        <th>Verifikator</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($transfer)): ?>
                        <?php $no = 1 + (10 * ($pager->getCurrentPage('transfer') - 1)); ?>
                        <?php foreach ($transfer as $t): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <?php if (session()->get('role') === 'admin'): ?>
                                    <td><?= esc($t['nama_pesdik']) ?></td>
                                <?php endif; ?>
                                <td><?= esc(ucwords($t['peruntukan'])) ?></td>
                                <td>Rp <?= number_format($t['jumlah'], 0, ',', '.') ?></td>
                                <td>
                                    <span class="badge 
                                        <?= $t['status_transfer'] == 'pending' ? 'bg-warning' : ($t['status_transfer'] == 'diterima' ? 'bg-success' : 'bg-danger') ?>">
                                        <?= ucfirst($t['status_transfer']) ?>
                                    </span>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($t['waktu_transfer'])) ?></td>
                                <td><?= esc($t['nama_verifikator']) ?></td>
                                <td>
                                    <a href="<?= base_url('uploads/transfer/' . $t['bukti_transfer']) ?>" target="_blank" class="btn btn-sm btn-info">
                                        <i class="bi bi-image"></i>
                                    </a>
                                    <?php if (session('role') === 'admin'): ?>
                                        <a href="<?= site_url('transfer/edit/' . $t['id_transfer']) ?>" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="<?= base_url('transfer/kirimNotif/' . $t['id_transfer']) ?>"
                                            class="btn btn-sm btn-success" target="_blank"
                                            rel="noopener noreferrer">
                                            <i class="bi bi-whatsapp"></i>
                                        </a>
                                        <a href="<?= base_url('transfer/delete/' . $t['id_transfer']) ?>"
                                            onclick="return confirm('Yakin ingin menghapus data ini?')"
                                            class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted">Belum ada data transfer</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- 📄 Pagination -->
            <div class="d-flex justify-content-center mt-3">
                <?= $pager->links('transfer') ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>