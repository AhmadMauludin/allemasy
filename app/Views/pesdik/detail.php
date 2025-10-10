<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Detail Peserta Didik</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Foto -->
                <div class="col-md-3 text-center">
                    <?php if (!empty($pesdik['foto'])): ?>
                        <img src="<?= base_url('uploads/pesdik/' . $pesdik['foto']) ?>" alt="Foto Pesdik" class="img-fluid rounded mb-3" style="max-width:150px;">
                    <?php else: ?>
                        <img src="<?= base_url('uploads/default.png') ?>" alt="Default" class="img-fluid rounded mb-3" style="max-width:150px;">
                    <?php endif; ?>
                </div>

                <!-- Info utama -->
                <div class="col-md-9">
                    <table class="table table-bordered">
                        <tr>
                            <th>Nama</th>
                            <td><?= esc($pesdik['nama']) ?></td>
                        </tr>
                        <tr>
                            <th>NISN</th>
                            <td><?= esc($pesdik['nisn']) ?></td>
                        </tr>
                        <tr>
                            <th>NIS</th>
                            <td><?= esc($pesdik['nis']) ?></td>
                        </tr>
                        <tr>
                            <th>Kelas</th>
                            <td><?= esc($pesdik['nama_kelas']) ?></td>
                        </tr>
                        <tr>
                            <th>Tanggal Lahir</th>
                            <td><?= esc($pesdik['tanggal_lahir']) ?></td>
                        </tr>
                        <tr>
                            <th>Telepon</th>
                            <td><?= esc($pesdik['telp']) ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?= esc($pesdik['email']) ?></td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td><?= esc($pesdik['alamat']) ?></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge <?= $pesdik['status'] == 'aktif' ? 'bg-success' : 'bg-secondary' ?>">
                                    <?= ucfirst($pesdik['status']) ?>
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

            <?php if (session()->get('role') === 'admin'): ?>
                <div class="card mt-4">
                    <div class="card-header bg-primary text-white">
                        Tambah Jabatan
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('jabatan/store') ?>" method="post">
                            <input type="hidden" name="id_user" value="<?= esc($pesdik['id_user']) ?>">

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
                <a href="<?= site_url('pesdik') ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>