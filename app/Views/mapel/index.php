<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h2>Data Mata Pelajaran</h2>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <?php if (session()->get('role') == 'admin') : ?>
        <a href="<?= base_url('mapel/create'); ?>" class="btn btn-primary mb-3">Tambah Mapel</a>
    <?php endif; ?>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Golongan</th>
                <th>Tingkat</th>
                <th>Status</th>
                <th>Foto</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($mapel as $m): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= esc($m['kode_mapel']); ?></td>
                    <td><?= esc($m['nama_mapel']); ?></td>
                    <td><?= esc($m['golongan']); ?></td>
                    <td><?= esc($m['tingkat']); ?></td>
                    <td>
                        <span class="badge bg-<?= $m['status'] == 'aktif' ? 'success' : 'secondary'; ?>">
                            <?= ucfirst($m['status']); ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($m['foto']): ?>
                            <img src="<?= base_url('uploads/mapel/' . $m['foto']); ?>" alt="Foto" width="50">
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= base_url('mapel/edit/' . $m['id_mapel']); ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="<?= base_url('mapel/delete/' . $m['id_mapel']); ?>"
                            onclick="return confirm('Yakin ingin hapus?')"
                            class="btn btn-danger btn-sm">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>