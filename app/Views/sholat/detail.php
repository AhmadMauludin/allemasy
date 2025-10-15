<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>


<div class="card mb-4">
    <div class="card-body">
        <h5>Detail Sholat</h5>
        <p><?= esc($sholat['hari']); ?>, <?= esc($sholat['tanggal']); ?> Waktu : <?= esc($sholat['sholat']); ?> Pukul <?= esc($sholat['waktu_mulai']); ?> - <?= esc($sholat['waktu_selesai']); ?> Status : <?= esc($sholat['status_sholat']); ?> Keterangan :</b> <?= esc($sholat['ket_sholat']); ?> </p>
        <?php if (in_array(session()->get('role'), ['admin', 'guru'])): ?>
            <a href="<?= base_url('sholat/scan/' . $sholat['id_sholat']); ?>" class="btn btn-success">
                <i class="bi bi-qr-code-scan"></i> Scan
            </a>
        <?php endif; ?>

        <a href="<?= base_url('sholat'); ?>" class="btn btn-secondary">
            Kembali
        </a>
    </div>
</div>

<div class="card mb-4 shadow-sm">
    <div class="card-body">
        <h5>Daftar Presensi Sholat</h5>

        <table class="table table-striped">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Pesdik</th>
                    <th>Waktu Presensi</th>
                    <th>Status Presensi</th>
                    <th>Keterangan</th>
                    <?php if (in_array(session()->get('role'), ['admin', 'guru'])): ?>
                        <th>Aksi</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($presensi as $row): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= esc($row['nama']); ?></td>
                        <td><?= $row['waktu_presensi'] ? esc($row['waktu_presensi']) : '-'; ?></td>
                        <td>
                            <?php
                            $badge = match ($row['status_presensi']) {
                                'hadir' => 'success',
                                'telat' => 'warning',
                                'pending' => 'secondary',
                                'alfa' => 'danger',
                                'izin', 'sakit' => 'info',
                                default => 'dark',
                            };
                            ?>
                            <span class="badge bg-<?= $badge; ?>"><?= ucfirst($row['status_presensi']); ?></span>
                        </td>
                        <td><?= esc($row['ket_presensi']); ?></td>

                        <?php if (in_array(session()->get('role'), ['admin', 'guru'])): ?>
                            <td>
                                <!-- Tombol Edit -->
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id_presensi_sholat']; ?>">
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                <!-- Tombol Hapus -->
                                <a href="<?= base_url('presensi_sholat/delete/' . $row['id_presensi_sholat']); ?>"
                                    onclick="return confirm('Yakin ingin menghapus presensi ini?')"
                                    class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        <?php endif; ?>
                    </tr>

                    <!-- Modal Edit Presensi -->
                    <div class="modal fade" id="editModal<?= $row['id_presensi_sholat']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="<?= base_url('presensi_sholat/update/' . $row['id_presensi_sholat']); ?>" method="post">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel">Edit Presensi - <?= esc($row['nama']); ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label>Status Presensi</label>
                                            <select name="status_presensi" class="form-select" required>
                                                <option value="pending" <?= $row['status_presensi'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                                <option value="hadir" <?= $row['status_presensi'] == 'hadir' ? 'selected' : ''; ?>>Hadir</option>
                                                <option value="telat" <?= $row['status_presensi'] == 'telat' ? 'selected' : ''; ?>>Telat</option>
                                                <option value="alfa" <?= $row['status_presensi'] == 'alfa' ? 'selected' : ''; ?>>Alfa</option>
                                                <option value="izin" <?= $row['status_presensi'] == 'izin' ? 'selected' : ''; ?>>Izin</option>
                                                <option value="sakit" <?= $row['status_presensi'] == 'sakit' ? 'selected' : ''; ?>>Sakit</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label>Keterangan</label>
                                            <input type="text" name="ket_presensi" class="form-control" value="<?= esc($row['ket_presensi']); ?>">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="card mb-4 shadow-sm">
    <div class="card-body">
        <h5 class="card-title mb-3">📊 Rekap Presensi Sholat</h5>
        <div class="row text-center">
            <div class="col-md-2 col-6 mb-2">
                <div class="p-2 bg-success text-white rounded">
                    Hadir<br><b><?= $rekap['hadir']; ?></b>
                </div>
            </div>
            <div class="col-md-2 col-6 mb-2">
                <div class="p-2 bg-warning text-dark rounded">
                    Telat<br><b><?= $rekap['telat']; ?></b>
                </div>
            </div>
            <div class="col-md-2 col-6 mb-2">
                <div class="p-2 bg-info text-white rounded">
                    Izin<br><b><?= $rekap['izin']; ?></b>
                </div>
            </div>
            <div class="col-md-2 col-6 mb-2">
                <div class="p-2 bg-secondary text-white rounded">
                    Sakit<br><b><?= $rekap['sakit']; ?></b>
                </div>
            </div>
            <div class="col-md-2 col-6 mb-2">
                <div class="p-2 bg-danger text-white rounded">
                    Alfa<br><b><?= $rekap['alfa']; ?></b>
                </div>
            </div>
            <div class="col-md-2 col-6 mb-2">
                <div class="p-2 bg-light border rounded">
                    Total<br><b><?= $rekap['total']; ?></b>
                </div>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection(); ?>