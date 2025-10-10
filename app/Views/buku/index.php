<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Data Buku</h2>

<a href="<?= base_url('buku/create') ?>" class="btn btn-primary mb-3">+ Tambah Buku</a>

<form method="get" class="mb-3">
    <input type="text" name="keyword" value="<?= esc($keyword) ?>" placeholder="Cari buku..." class="form-control" style="max-width: 300px;">
</form>

<table class="table table-bordered table-striped">
    <thead class="table-primary">
        <tr>
            <th>No</th>
            <th>Foto</th>
            <th>Judul</th>
            <th>Pengarang</th>
            <th>Penerbit</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1 + (10 * (service('request')->getVar('page') ? service('request')->getVar('page') - 1 : 0)); ?>
        <?php foreach ($buku as $b): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td>
                    <img src="<?= base_url('uploads/buku/' . ($b['foto'] ?? 'default.png')) ?>" width="50" class="rounded">
                </td>
                <td><?= esc($b['judul']) ?></td>
                <td><?= esc($b['pengarang']) ?></td>
                <td><?= esc($b['penerbit']) ?></td>
                <td>
                    <span class="badge bg-<?= $b['status'] == 'tersedia' ? 'success' : 'warning' ?>">
                        <?= ucfirst($b['status']) ?>
                    </span>
                </td>
                <td>
                    <a href="<?= base_url('buku/show/' . $b['id_buku']) ?>" class="btn btn-info btn-sm">Detail</a>
                    <a href="<?= base_url('buku/edit/' . $b['id_buku']) ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="<?= base_url('buku/delete/' . $b['id_buku']) ?>" onclick="return confirm('Yakin ingin hapus?')" class="btn btn-danger btn-sm">Hapus</a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?= $pager->links() ?>

<?= $this->endSection() ?>