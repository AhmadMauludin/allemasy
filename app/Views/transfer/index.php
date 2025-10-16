<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Data Transfer</h4>
        <?php if (session('role') === 'pesdik'): ?>
            <a href="<?= base_url('transfer/create') ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Transfer
            </a>
        <?php endif; ?>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php elseif (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama Pesdik</th>
                        <th>Peruntukan</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Waktu</th>
                        <th>Verifikator</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($transfer)): $no = 1;
                        foreach ($transfer as $t): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($t['nama_pesdik']) ?></td>
                                <td><?= esc($t['peruntukan']) ?></td>
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
                                    <?php else: ?>
                                        <em class="text-muted">-</em>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach;
                    else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada data transfer</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>