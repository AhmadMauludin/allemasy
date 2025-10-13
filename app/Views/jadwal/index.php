<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            <p class="mb-0">Data Jadwal Pelajaran</p>
        </div>
        <div class="card-body">

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>

            <?php if (session()->get('role') == 'admin') : ?>
                <a href="<?= base_url('jadwal/create'); ?>" class="btn btn-primary mb-3">Tambah Jadwal</a>
            <?php endif; ?>

            <table class="table table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Hari</th>
                        <th>Mapel</th>
                        <th>Guru</th>
                        <th>Kelas</th>
                        <th>Ruangan</th>
                        <th>Jam</th>
                        <th>Waktu</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($jadwal as $j): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= esc($j['hari']); ?></td>
                            <td><?= esc($j['nama_mapel']); ?></td>
                            <td><?= esc($j['nama_guru']); ?></td>
                            <td><?= esc($j['nama_kelas']); ?></td>
                            <td><?= esc($j['nama_ruangan']); ?></td>
                            <td><?= esc($j['jampel']); ?></td>
                            <td><?= esc($j['waktu_mulai']); ?> - <?= esc($j['waktu_selesai']); ?></td>
                            <td>
                                <span class="badge bg-<?= $j['status'] == 'aktif' ? 'success' : 'secondary' ?>">
                                    <?= ucfirst($j['status']); ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= base_url('jadwal/detail/' . $j['id_jadwal']); ?>" class="btn btn-success btn-sm">Detail</a>
                                <?php if (session()->get('role') == 'admin') : ?>
                                    <a href="<?= base_url('jadwal/edit/' . $j['id_jadwal']); ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="<?= base_url('jadwal/delete/' . $j['id_jadwal']); ?>" onclick="return confirm('Hapus jadwal ini?')" class="btn btn-danger btn-sm">Hapus</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>