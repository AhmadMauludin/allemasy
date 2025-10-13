<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container mt-4">

    <div class="card-body">
        <div class="card mb-3">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <p class="mb-0">Detail Jadwal <?= esc($jadwal['nama_mapel']) ?></p>
            </div>
            <div class="card-body">
                <p><strong>Guru Pengampu:</strong> <?= esc($jadwal['nama_guru']) ?></p>
                <p><strong>Kelas / Ruangan:</strong> <?= esc($jadwal['nama_kelas']) ?> / <?= esc($jadwal['nama_ruangan']) ?></p>
                <p><strong>Waktu:</strong> <?= esc($jadwal['hari']) ?>, <?= esc($jadwal['jampel']) ?>, Waktu:</strong> <?= esc($jadwal['waktu_mulai']) ?> - <?= esc($jadwal['waktu_selesai']) ?></p>
                <p><strong>Keterangan:</strong> <?= esc($jadwal['ket']) ?></p>
            </div>
        </div>

        <div class="card mb-3">

            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <p class="mb-0">Pertemuan</p>
            </div>
            <div class="card-body">

                <?php if (session()->get('role') == 'guru') : ?>
                    <a href="<?= base_url('pertemuan/create/' . $jadwal['id_jadwal']) ?>" class="btn btn-primary">
                        Tambah Pertemuan
                    </a>
                <?php endif; ?>

                <?php if (count($pertemuan) > 0): ?>

                    <table class="table table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Tanggal</th>
                                <th>Materi</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($pertemuan as $p): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= esc($p['tanggal']) ?></td>
                                    <td><?= esc($p['materi']) ?></td>
                                    <td><?= esc($p['status']) ?></td>
                                    <td><?= esc($p['ket']) ?></td>
                                    <td>
                                        <a href="<?= base_url('pertemuan/detail/' . $p['id_pertemuan']) ?>" class="btn btn-sm btn-info">Detail</a>
                                        <?php if (session()->get('role') == 'guru') : ?>
                                            <a href="<?= base_url('pertemuan/edit/' . $p['id_pertemuan']) ?>" class="btn btn-sm btn-warning">Edit</a>
                                            <a href="<?= base_url('pertemuan/delete/' . $p['id_pertemuan']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="alert alert-secondary">Belum ada pertemuan untuk jadwal ini.</div>
                <?php endif; ?>
            </div>
        </div>
        <a href="<?= base_url('jadwal') ?>" class="btn btn-secondary mt-3">Kembali</a>
    </div>
</div>
<?= $this->endSection() ?>