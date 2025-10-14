<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container mt-4">

    <div class="card-body">
        <div class="card mb-3">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <span>Detail Jadwal</span>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-1">
                    <li>Mata Pelajaran : <?= esc($jadwal['nama_mapel']) ?></li>
                    <li>Guru Pengampu : <?= esc($jadwal['nama_guru']) ?></li>
                    <li>Kelas / Ruangan : <?= esc($jadwal['nama_kelas']) ?> / <?= esc($jadwal['nama_ruangan']) ?> </li>
                    <li>Waktu : <?= esc($jadwal['hari']) ?>, <?= esc($jadwal['jampel']) ?>, Waktu: <?= esc($jadwal['waktu_mulai']) ?> - <?= esc($jadwal['waktu_selesai']) ?> </li>
                    <li>Keterangan : <?= esc($jadwal['ket']) ?> </li>
                </ul>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <span>Pertemuan</span>
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