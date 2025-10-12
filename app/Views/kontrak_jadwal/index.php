<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h2>Data Kontrak Jadwal</h2>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <?php if (session()->get('role') == 'admin') : ?>
        <a href="<?= base_url('kontrak/create'); ?>" class="btn btn-primary mb-3">Tambah Kontrak Jadwal</a>
    <?php endif; ?>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Mapel</th>
                <th>Guru</th>
                <th>Kelas</th>
                <th>Tahun Ajaran</th>
                <th>Jam</th>
                <th>Status</th>
                <th>Aksi</th>
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
                    <td>
                        <?php if (session()->get('role') == 'admin') : ?>
                            <a href="<?= base_url('kontrak/edit/' . $k['id_kontrak_jadwal']); ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="<?= base_url('kontrak/delete/' . $k['id_kontrak_jadwal']); ?>" onclick="return confirm('Yakin ingin hapus?')" class="btn btn-danger btn-sm">Hapus</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>