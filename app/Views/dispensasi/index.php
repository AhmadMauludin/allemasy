<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
        <p class="mb-0">Data Dispensasi</p>
        <?php if (session()->get('role') == 'admin'): ?>
            <a href="<?= base_url('dispensasi/create'); ?>" class="btn btn-sm btn-light">Tambah Dispensasi</a>
        <?php endif; ?>
    </div>
    <div class="card-body">

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <?php if (session()->get('role') == 'guru'): ?>
            <a href="<?= base_url('dispensasi/create'); ?>" class="btn btn-primary mb-3">Tambah Dispensasi</a>
        <?php endif; ?>

        <table class="table table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Pesdik</th>
                    <th>Guru</th>
                    <th>Tanggal</th>
                    <th>Alasan</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <?php if (session()->get('role') == 'guru'): ?>
                        <th>Aksi</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($dispensasi as $row): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= esc($row['nama_pesdik']); ?></td>
                        <td><?= esc($row['nama_guru']); ?></td>
                        <td><?= esc($row['tanggal']); ?></td>
                        <td><?= esc($row['alasan']); ?></td>
                        <td><span class="badge bg-info"><?= esc($row['status']); ?></span></td>
                        <td><?= esc($row['ket']); ?></td>
                        <?php if (session()->get('role') == 'guru'): ?>
                            <td>
                                <a href="<?= base_url('dispensasi/edit/' . $row['id_dispensasi']); ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="<?= base_url('dispensasi/delete/' . $row['id_dispensasi']); ?>" onclick="return confirm('Yakin ingin hapus?')" class="btn btn-danger btn-sm">Hapus</a>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</div>

<?= $this->endSection(); ?>