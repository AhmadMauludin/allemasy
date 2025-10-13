<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <p class="mb-0">Detail Guru</p>
        </div>

        <div class="card-body">
            <div class="row">
                <!-- Foto -->
                <div class="col-md-3 text-center">
                    <?php if (!empty($guru['foto'])): ?>
                        <img src="<?= base_url('uploads/guru/' . $guru['foto']) ?>" alt="Foto Guru" class="img-fluid rounded mb-3" style="max-width:150px;">
                    <?php else: ?>
                        <img src="<?= base_url('uploads/default.png') ?>" alt="Default" class="img-fluid rounded mb-3" style="max-width:150px;">
                    <?php endif; ?>
                </div>

                <!-- Info utama -->
                <div class="col-md-9">
                    <table class="table table-bordered">
                        <tr>
                            <th>Nama</th>
                            <td><?= esc($guru['nama']) ?></td>
                        </tr>
                        <tr>
                            <th>NIP</th>
                            <td><?= esc($guru['nip']) ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?= esc($guru['email']) ?></td>
                        </tr>
                        <tr>
                            <th>Telepon</th>
                            <td><?= esc($guru['telp']) ?></td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td><?= esc($guru['alamat']) ?></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge <?= $guru['status'] == 'aktif' ? 'bg-success' : 'bg-secondary' ?>">
                                    <?= ucfirst($guru['status']) ?>
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <hr>

            <!-- Jabatan -->
            <h6 class="mt-3 mb-3">Jabatan Organisasi</h6>
            <?php if (!empty($jabatan)): ?>
                <ul class="list-group">
                    <?php foreach ($jabatan as $j): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <?= esc($j['jabatan']) ?>
                                <span class="badge bg-info ms-2"><?= ucfirst($j['status']) ?></span>
                            </div>

                            <?php if (session()->get('role') === 'admin'): ?>
                                <div>
                                    <a href="<?= base_url('jabatan/delete/' . $j['id_jabatan']) ?>"
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('Yakin ingin menghapus jabatan ini?')">
                                        <i class="bi bi-trash"></i> Hapus
                                    </a>
                                </div>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="text-muted">Belum memiliki jabatan aktif.</p>
            <?php endif; ?>

            <!-- Form tambah jabatan (khusus admin) -->
            <?php if (session()->get('role') === 'admin'): ?>
                <div class="card mt-4">
                    <div class="card-header bg-primary text-white">
                        Tambah Jabatan
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('jabatan/store') ?>" method="post">
                            <input type="hidden" name="id_user" value="<?= esc($guru['id_user']) ?>">

                            <div class="mb-3">
                                <label for="jabatan" class="form-label">Nama Jabatan</label>
                                <input type="text" name="jabatan" id="jabatan" class="form-control" placeholder="Masukkan nama jabatan" required>
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="aktif">Aktif</option>
                                    <option value="nonaktif">Nonaktif</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-success">Simpan</button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>

            <div class="mt-4">
                <a href="<?= site_url('guru') ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>