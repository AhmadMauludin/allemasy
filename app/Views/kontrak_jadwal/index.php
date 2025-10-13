<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <p class="mb-0">Data Kontrak Jadwal</h2>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>

            <?php if (session()->get('role') == 'admin') : ?>
                <a href="<?= base_url('kontrak/create'); ?>" class="btn btn-primary mb-3">Tambah Kontrak Jadwal</a>
            <?php endif; ?>

            <table class="table table-striped">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Mapel</th>
                        <th>Guru</th>
                        <th>Kelas</th>
                        <th>Tahun Ajaran</th>
                        <th>Jam</th>
                        <th>Status</th>
                        <?php if (session()->get('role') == 'admin') : ?>
                            <th>Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($kontrak as $k): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= esc($k['nama_mapel']); ?></td>
                            <td><?= esc($k['nama_guru']); ?></td>
                            <td><?= esc($k['nama_kelas']); ?></td>
                            <td><?= esc($k['tahun']); ?> - <?= esc($k['semester']); ?></td>
                            <td><?= esc($k['jumlah_jam']); ?></td>
                            <td>
                                <span class="badge bg-<?= $k['status'] == 'aktif' ? 'success' : 'secondary'; ?>">
                                    <?= ucfirst($k['status']); ?>
                                </span>
                            </td>
                            <?php if (session()->get('role') == 'admin') : ?>
                                <td>
                                    <a href="<?= base_url('kontrak/edit/' . $k['id_kontrak_jadwal']); ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="<?= base_url('kontrak/delete/' . $k['id_kontrak_jadwal']); ?>" onclick="return confirm('Yakin ingin hapus?')" class="btn btn-danger btn-sm">Hapus</a>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>