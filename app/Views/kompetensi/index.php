<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
        <span>Data Komspanetensi</span>
    </div>
    <div class="card-body">

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session('success') ?></div>
        <?php endif; ?>

        <a href="<?= base_url('kompetensi/create'); ?>" class="btn btn-primary mb-3">Tambah Kompetensi</a>

        <table class="table table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Jenis</th>
                    <th>Mapel</th>
                    <th>Buku</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($kompetensi as $k): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($k['jenis_kompetensi']) ?></td>
                        <td><?= esc($k['nama_mapel']) ?></td>
                        <td><?= esc($k['judul']) ?></td>
                        <td><?= esc($k['status']) ?></td>
                        <td><?= esc($k['keterangan']) ?></td>
                        <td>
                            <?php if ($k['foto']): ?>
                                <a href="<?= base_url('uploads/kompetensi/' . $k['foto']) ?>" target="_blank">Lihat</a>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?= base_url('kompetensi_pesdik/index/' . $k['id_kompetensi']) ?>" class="btn btn-sm btn-primary">Detail</a>
                            <a href="<?= base_url('kompetensi/edit/' . $k['id_kompetensi']) ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="<?= base_url('kompetensi/delete/' . $k['id_kompetensi']) ?>" onclick="return confirm('Yakin ingin hapus?')" class="btn btn-sm btn-danger">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>