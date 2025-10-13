<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4>Detail Rombel <?= esc($kelas['nama_kelas']) ?></h4>
        </div>

        <div class="card-body">
            <div class="row mb-4">
                <!-- Foto Kelas -->
                <div class="col-md-3 text-center">
                    <?php if (!empty($kelas['foto'])): ?>
                        <img src="<?= base_url('uploads/kelas/' . $kelas['foto']) ?>" alt="Foto Kelas" class="img-fluid rounded" style="max-width: 180px;">
                    <?php else: ?>
                        <img src="<?= base_url('uploads/default.png') ?>" alt="Default" class="img-fluid rounded" style="max-width: 180px;">
                    <?php endif; ?>
                </div>

                <!-- Data Kelas -->
                <div class="col-md-9">
                    <table class="table table-bordered">
                        <tr>
                            <th width="25%">ID</th>
                            <td><?= esc($kelas['id_kelas']) ?></td>
                        </tr>
                        <tr>
                            <th>Nama Rombel</th>
                            <td><?= esc($kelas['nama_kelas']) ?></td>
                        </tr>
                        <tr>
                            <th>Tingkat</th>
                            <td><?= esc($kelas['tingkat']) ?></td>
                        </tr>
                        <tr>
                            <th>Ruangan</th>
                            <td><?= esc($kelas['nama_ruangan']) ?: '<em>Belum ditentukan</em>' ?></td>
                        </tr>
                        <tr>
                            <th>Wali</th>
                            <td><?= esc($kelas['nama_guru']) ?: '<em>Belum ditentukan</em>' ?></td>
                        </tr>
                        <tr>
                            <th>Keterangan</th>
                            <td><?= esc($kelas['ket']) ?: '-' ?></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge <?= $kelas['status'] == 'aktif' ? 'bg-success' : 'bg-secondary' ?>">
                                    <?= ucfirst($kelas['status']) ?>
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <hr>

            <!-- Jumlah Pesdik -->
            <p class="mt-3 mb-3">Peserta Didik di Rombel Ini</p>
            <p><strong>Jumlah Peserta Didik:</strong> <?= count($pesdik) ?> orang</p>

            <?php if (!empty($pesdik)): ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th>No</th>
                                <th>Foto</th>
                                <th>Nama Pesdik</th>
                                <th>Jenis Kelamin</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($pesdik as $p): ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td class="text-center">
                                        <?php if (!empty($p['foto'])): ?>
                                            <img src="<?= base_url('uploads/pesdik/' . $p['foto']) ?>"
                                                alt="Foto Pesdik"
                                                class="rounded"
                                                style="width:60px; height:60px; object-fit:cover;">
                                        <?php else: ?>
                                            <img src="<?= base_url('uploads/default.png') ?>"
                                                alt="Default"
                                                class="rounded"
                                                style="width:60px; height:60px; object-fit:cover;">
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc($p['nama']) ?></td>
                                    <td class="text-center"><?= esc(ucfirst($p['jk'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-muted">Belum ada peserta didik di kelas ini.</p>
            <?php endif; ?>

            <div class="mt-4">
                <a href="<?= site_url('kelas') ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>