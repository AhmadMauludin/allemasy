<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Data Jabatan</h3>
    <a href="<?= base_url('jabatan/create') ?>" class="btn btn-primary">+ Tambah Jabatan</a>
</div>

<table class="table table-striped">
    <thead class="table-primary">
        <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1;
        foreach ($jabatan as $j): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= esc($j['nama']) ?></td>
                <td><?= esc($j['jabatan']) ?></td>
                <td><?= esc($j['status']) ?></td>
                <td>
                    <a href="<?= base_url('jabatan/edit/' . $j['id_jabatan']) ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="<?= base_url('jabatan/delete/' . $j['id_jabatan']) ?>" class="btn btn-danger btn-sm"
                        onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>