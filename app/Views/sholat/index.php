<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="card shadow-sm mb-4">
    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
        <p class="mb-0">Data Sholat Berjamaah</p>
        <!-- 🔍 Form Pencarian Tanggal -->
        <form action="<?= base_url('sholat') ?>" method="get" class="d-flex align-items-center">
            <input type="date" name="tanggal" value="<?= esc($tanggal ?? '') ?>" class="form-control form-control-sm me-2" style="width: 180px;">
            <button type="submit" class="btn btn-light btn-sm">Cari</button>
            <?php if (!empty($tanggal)): ?>
                <a href="<?= base_url('sholat') ?>" class="btn btn-outline-light btn-sm ms-2">Reset</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="card-body">
        <?php if (session()->get('role') === 'admin' || session()->get('role') === 'guru'): ?>
            <a href="<?= base_url('sholat/create') ?>" class="btn btn-primary mb-3">
                <i class="bi bi-plus-circle"></i> Tambah Sholat
            </a>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead class="table-light text-center">
                    <tr>
                        <th>No</th>
                        <th>Hari</th>
                        <th>Tanggal</th>
                        <th>Sholat</th>
                        <th>Status Sholat</th>
                        <?php if (session()->get('role') === 'pesdik'): ?>
                            <th>Status Presensi</th>
                        <?php endif; ?>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php if (!empty($sholat)): ?>
                        <?php $no = 1;
                        foreach ($sholat as $row): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($row['hari']) ?></td>
                                <td><?= esc($row['tanggal']) ?></td>
                                <td><?= esc($row['sholat']) ?></td>
                                <td>
                                    <span class="badge bg-<?= $row['status_sholat'] === 'selesai' ? 'success' : 'secondary' ?>">
                                        <?= ucfirst($row['status_sholat']) ?>
                                    </span>
                                </td>

                                <!-- 🧍 Status presensi hanya untuk Pesdik -->
                                <?php if (session()->get('role') === 'pesdik'): ?>
                                    <?php
                                    $badgeClass = [
                                        'pending' => 'secondary',
                                        'hadir' => 'success',
                                        'telat' => 'warning',
                                        'izin' => 'info',
                                        'sakit' => 'primary',
                                        'alfa' => 'danger'
                                    ];
                                    ?>
                                    <td>
                                        <span class="badge bg-<?= $badgeClass[$row['status_presensi']] ?? 'secondary' ?>">
                                            <?= ucfirst($row['status_presensi'] ?? 'pending') ?>
                                        </span>
                                    </td>
                                <?php endif; ?>

                                <td>
                                    <?php if (session()->get('role') === 'admin' || session()->get('role') === 'guru'): ?>
                                        <!-- Tombol ubah status -->
                                        <form id="statusForm<?= $row['id_sholat']; ?>"
                                            action="<?= base_url('sholat/updateStatus/' . $row['id_sholat']); ?>"
                                            method="post" class="d-inline">
                                            <input type="hidden" name="status_sholat"
                                                value="<?= $row['status_sholat'] === 'dijadwalkan' ? 'selesai' : 'dijadwalkan'; ?>">
                                            <button type="button"
                                                class="btn <?= $row['status_sholat'] === 'dijadwalkan' ? 'btn-warning' : 'btn-success'; ?> btn-sm"
                                                onclick="confirmStatusChange('<?= $row['id_sholat']; ?>', '<?= $row['status_sholat']; ?>')">
                                                <?php if ($row['status_sholat'] === 'dijadwalkan'): ?>
                                                    <i class="bi bi-check-circle"></i> Tandai Selesai
                                                <?php else: ?>
                                                    <i class="bi bi-arrow-repeat"></i> Jadwalkan Ulang
                                                <?php endif; ?>
                                            </button>
                                        </form>
                                    <?php endif; ?>

                                    <a href="<?= base_url('sholat/detail/' . $row['id_sholat']) ?>"
                                        class="btn btn-info btn-sm"><i class="bi bi-eye"></i> Detail</a>

                                    <?php if (session()->get('role') === 'admin' || session()->get('role') === 'guru'): ?>
                                        <a href="<?= base_url('sholat/delete/' . $row['id_sholat']); ?>"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus data sholat ini beserta semua presensinya?');">
                                            <i class="bi bi-trash"></i> Hapus
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="<?= session()->get('role') === 'pesdik' ? '7' : '6' ?>" class="text-muted">
                                Tidak ada data sholat ditemukan.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="d-flex justify-content-left mt-3">
                Page&nbsp; <?= $pager->links(); ?>
            </div>

        </div>
    </div>
</div>

<script>
    function confirmStatusChange(id, currentStatus) {
        let newStatus = currentStatus === 'dijadwalkan' ? 'selesai' : 'dijadwalkan';
        let message = `Apakah Anda yakin ingin mengubah status menjadi "${newStatus}"?`;
        if (confirm(message)) {
            document.querySelector(`#statusForm${id}`).submit();
        }
    }
</script>

<?= $this->endSection() ?>