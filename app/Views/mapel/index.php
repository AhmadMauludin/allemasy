<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
        <p class="mb-0">Data Mata Pelajaran</p>
        <?php if (session()->get('role') == 'admin'): ?>
            <a href="<?= base_url('mapel/create'); ?>" class="btn btn-sm btn-light">Tambah Mapel</a>
        <?php endif; ?>
    </div>
    <div class="card-body">

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <table class="table table-striped">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Golongan</th>
                    <th>Tingkat</th>
                    <th>Status</th>
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
</div>

<?= $this->endSection() ?>