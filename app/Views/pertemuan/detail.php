<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">

    <!-- Header Pertemuan -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <p class="mb-0"><i class="bi bi-book-half me-2"></i>Detail Pertemuan</p>
        </div>
        <div class="card-body">
            <ul class="list-unstyled mb-1">
                <li>Tanggal : <?= esc($p['tanggal']); ?></li>
                <li>Materi : <?= esc($p['materi']); ?></li>
                <li>Keterangan : <?= esc($p['ket']); ?></li>
            </ul>
        </div>
    </div>

    <!-- Bagian Materi -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-warning text-white d-flex justify-content-between align-items-center">
            <p class="mb-0"><i class="bi bi-book-half me-2"></i>Daftar Materi</p>
        </div>
        <div class="card-body">
            <table class="table table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th>File</th>
                        <th>Video</th>
                        <th>Status</th>
                        <?php if (session()->get('role') == 'guru') : ?>
                            <th>Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($materi as $m): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= esc($m['judul']) ?></td>
                            <td><?= esc($m['deskripsi']) ?></td>
                            <td><?= $m['file'] ? "<a href='" . base_url('uploads/materi/' . $m['file']) . "' target='_blank'>Lihat</a>" : '-' ?></td>
                            <td><?= $m['link_video'] ? "<a href='{$m['link_video']}' target='_blank'>Tonton</a>" : '-' ?></td>
                            <td>
                                <span class="badge <?= $m['status'] == 'aktif' ? 'bg-success' : 'bg-secondary' ?>">
                                    <?= esc(ucfirst($m['status'])) ?>
                                </span>
                            </td>
                            <?php if (session()->get('role') == 'guru') : ?>
                                <td>
                                    <a href="<?= base_url('materi/delete/' . $m['id_materi']) ?>"
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('Yakin ingin menghapus materi ini?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            <?php endif; ?>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?php if (session()->get('role') == 'guru') : ?>
                <!-- Form Tambah Materi -->
                <hr>
                <h6 class="fw-bold text-secondary mb-3">Tambah Materi</h6>
                <form action="<?= base_url('materi/store') ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id_pertemuan" value="<?= $p['id_pertemuan'] ?>">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label>Judul</label>
                            <input type="text" name="judul" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Link Video</label>
                            <input type="url" name="link_video" class="form-control">
                        </div>
                        <div class="col-12">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi" class="form-control"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label>File</label>
                            <input type="file" name="file" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label>Status</label>
                            <select name="status" class="form-select">
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3"><i class="bi bi-plus-circle"></i> Tambah Materi</button>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bagian Tugas -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            <p class="mb-0"><i class="bi bi-pencil-square me-2"></i>Daftar Tugas</p>
        </div>
        <div class="card-body">
            <table class="table table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Instruksi</th>
                        <th>Deadline</th>
                        <th>Status</th>
                        <th>File</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($tugas as $t): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= esc($t['judul']) ?></td>
                            <td><?= esc($t['instruksi']) ?></td>
                            <td><?= esc($t['deadline']) ?></td>
                            <td>
                                <span class="badge <?= $t['status'] == 'selesai' ? 'bg-success' : 'bg-warning text-dark' ?>">
                                    <?= esc(ucfirst($t['status'])) ?>
                                </span>
                            </td>
                            <td><?= $t['file'] ? "<a href='" . base_url('uploads/tugas/' . $t['file']) . "' target='_blank'>Lihat</a>" : '-' ?></td>
                            <?php if (session()->get('role') == 'guru') : ?>
                                <a href="<?= base_url('tugas/delete/' . $t['id_tugas']) ?>"
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('Yakin ingin menghapus tugas ini?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            <?php endif; ?>
                            <td>
                                <a href="<?= base_url('pengumpulan_tugas/' . $t['id_tugas']) ?>" class="btn btn-sm btn-info">
                                    Lihat Pengumpulan
                                </a>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?php if (session()->get('role') == 'guru') : ?>
                <!-- Form Tambah Tugas -->
                <hr>
                <h6 class="fw-bold text-secondary mb-3">Tambah Tugas</h6>
                <form action="<?= base_url('tugas/store') ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id_pertemuan" value="<?= $p['id_pertemuan'] ?>">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label>Judul</label>
                            <input type="text" name="judul" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Deadline</label>
                            <input type="datetime-local" name="deadline" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label>Instruksi</label>
                            <textarea name="instruksi" class="form-control"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label>Status</label>
                            <select name="status" class="form-select">
                                <option value="ditugaskan">Ditugaskan</option>
                                <option value="selesai">Selesai</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>File</label>
                            <input type="file" name="file" class="form-control">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success mt-3"><i class="bi bi-plus-circle"></i> Tambah Tugas</button>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bagian Presensi -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
            <p class="mb-0"><i class="bi bi-people-fill me-2"></i>Daftar Kehadiran</p>
            <?php if (session()->get('role') == 'guru') : ?>
                <a href="<?= base_url('pertemuan/scan/' . $p['id_pertemuan']) ?>" class="btn btn-light btn-sm">
                    <i class="bi bi-upc-scan"></i> Scan Kehadiran
                </a>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <table class="table table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Peserta Didik</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Lampiran</th>
                        <?php if (session()->get('role') == 'guru') : ?>
                            <th>Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($presensi as $r): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= esc($r['nama_pesdik']) ?></td>
                            <td>
                                <?php if ($r['status'] == 'pending'): ?>
                                    <span class="badge bg-warning text-dark">Pending</span>
                                <?php elseif ($r['status'] == 'hadir'): ?>
                                    <span class="badge bg-success">Hadir</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary"><?= esc(ucfirst($r['status'])) ?></span>
                                <?php endif; ?>
                            </td>
                            <td><?= esc($r['ket'] ?? '-'); ?></td>
                            <td>
                                <?php if (!empty($r['foto'])): ?>
                                    <a href="<?= base_url('uploads/bukti/' . $r['foto']) ?>" target="_blank" class="btn btn-sm btn-outline-info">Lihat</a>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <?php if (session()->get('role') == 'guru') : ?>
                                <td>
                                    <a href="<?= base_url('presensi/edit/' . $r['id_presensi']) ?>" class="btn btn-sm btn-secondary">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tombol Kembali -->
    <div class="text-end">
        <a href="<?= base_url('jadwal/detail/' . $j['id_jadwal']) ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left-circle"></i> Kembali ke Detail Jadwal
        </a>
    </div>

</div>

<?= $this->endSection() ?>