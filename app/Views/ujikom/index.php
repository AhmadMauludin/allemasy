<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<div class="card shadow-sm mb-4">
    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
        <p class="mb-0">Data Ujikom</p>
    </div>
    <div class="card-body">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <a href="<?= base_url('ujikom/create/' . $kompetensi_pesdik['id_kompetensi_pesdik']); ?>" class="btn btn-primary mb-3">Tambah Ujikom</a>
        <a href="<?= base_url('kompetensi_pesdik/index/' . $kompetensi_pesdik['id_kompetensi']); ?>" class="btn btn-secondary mb-3">Kembali</a>

        <table class="table table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Waktu</th>
                    <th>Status</th>
                    <th>Rincian</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($ujikom as $row): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= esc($row['waktu']); ?></td>
                        <td><?= esc($row['status']); ?></td>
                        <td><?= esc($row['rincian']); ?></td>
                        <td>
                            <?php if ($row['foto']): ?>
                                <a href="<?= base_url('uploads/ujikom/' . $row['foto']); ?>" target="_blank">Lihat Foto</a>
                            <?php else: ?>
                                <span class="text-muted">Tidak ada</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?= base_url('ujikom/edit/' . $row['id_ujikom']); ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="<?= base_url('ujikom/delete/' . $row['id_ujikom']); ?>" onclick="return confirm('Yakin ingin hapus?')" class="btn btn-danger btn-sm">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection(); ?>