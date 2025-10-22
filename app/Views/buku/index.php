<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
        <p class="mb-0">Data Buku</p>
        <?php if (session()->get('role') == 'admin'): ?>
            <a href="<?= base_url('buku/create'); ?>" class="btn btn-sm btn-light">Tambah Buku</a>
        <?php endif; ?>
    </div>
    <div class="card-body">

        <form method="get" class="mb-3">
            <input type="text" name="keyword" value="<?= esc($keyword) ?>" placeholder="Cari buku..." class="form-control" style="max-width: 300px;">
        </form>

        <table class="table table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
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
    </div>
</div>
<?= $pager->links() ?>

<?= $this->endSection() ?>