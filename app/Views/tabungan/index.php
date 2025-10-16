<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4><?= esc($title) ?></h4>
        <?php if (session()->get('role') == 'pesdik') : ?>
            <button class="btn btn-outline-dark me-2">
                Saldo Tabungan Anda : <strong>Rp <?= number_format($saldo, 0, ',', '.') ?></strong>
            </button>
        <?php endif; ?>
        <a href="<?= base_url('tabungan/create') ?>" class="btn btn-outline-success me-1"><i class="bi bi-plus-circle"></i> Tambah</a>

    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <!-- 🔍 Form Pencarian -->
            <form action="<?= base_url('tabungan') ?>" method="get" class="row g-2">
                <?php if (session()->get('role') === 'admin'): ?>
                    <div class="col-md-2">
                        <input type="text" name="keyword" class="form-control" placeholder="Cari nama pesdik..." value="<?= esc($keyword) ?>">
                    </div>
                <?php endif; ?>
                <div class="col-md-2">
                    <input type="date" name="tanggal" class="form-control" value="<?= esc($tanggal) ?>">
                </div>
                <div class="col-md-2">
                    <select name="jenis_transaksi" class="form-select">
                        <option value="">-- Semua Jenis --</option>
                        <option value="setor" <?= $jenis_transaksi === 'setor' ? 'selected' : '' ?>>Setor</option>
                        <option value="tarik" <?= $jenis_transaksi === 'tarik' ? 'selected' : '' ?>>Tarik</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-outline-primary me-1"><i class="bi bi-search"></i> Cari</button>
                    <a href="<?= base_url('tabungan') ?>" class="btn btn-outline-secondary me-1"><i class="bi bi-arrow-repeat"></i> Reset</a>
                </div>

            </form>
        </div>
    </div>
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-striped align-middle">
                <thead class="table-light text-center">
                    <tr>
                        <th>#</th>
                        <?php if (session()->get('role') === 'admin'): ?>
                            <th>Nama Pesdik</th>
                        <?php endif; ?>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Verifikator</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($tabungan): ?>
                        <?php $no = 1 + (10 * ($pager->getCurrentPage() - 1)); ?>
                        <?php foreach ($tabungan as $row): ?>
                            <tr class="text-center">
                                <td><?= $no++ ?></td>
                                <?php if (session()->get('role') === 'admin'): ?>
                                    <td><?= esc($row['nama']) ?></td>
                                <?php endif; ?>
                                <td><?= ucfirst($row['jenis_transaksi']) ?></td>
                                <td>Rp <?= number_format($row['jumlah'], 0, ',', '.') ?></td>
                                <td>
                                    <span class="badge 
                                        <?= $row['status_transaksi'] === 'disetujui' ? 'bg-success' : ($row['status_transaksi'] === 'ditolak' ? 'bg-danger' : 'bg-warning') ?>">
                                        <?= ucfirst($row['status_transaksi']) ?>
                                    </span>
                                </td>
                                <td><?= date('d/m/Y', strtotime($row['tanggal_transaksi'])) ?></td>
                                <td><?= esc($row['nama_verifikator']) ?></td>
                                <td>
                                    <?php if (session()->get('role') === 'admin'): ?>
                                        <a href="<?= base_url('tabungan/edit/' . $row['id_tabungan']) ?>" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="<?= base_url('tabungan/detail/' . $row['id_pesdik']) ?>" class="btn btn-sm btn-info">
                                            <i class="bi bi-list-ul"></i>
                                        </a>
                                        <a href="<?= base_url('tabungan/kirimNotif/' . $row['id_tabungan']) ?>"
                                            class="btn btn-sm btn-success" target="_blank" rel="noopener noreferrer">
                                            <i class="bi bi-whatsapp"></i>
                                        </a>
                                        <a href="<?= base_url('tabungan/delete/' . $row['id_tabungan']) ?>"
                                            onclick="return confirm('Yakin ingin menghapus data ini?')"
                                            class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    <?php else: ?>
                                        <em class="text-muted">-</em>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted">Tidak ada data tabungan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- 📄 Pagination -->
            <div class="d-flex justify-content-center mt-3">
                <?= $pager->links() ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>