<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
        <p class="mb-0">Data Kompetensi Peserta Didik - <?= esc($kompetensi['keterangan'] ?? '') ?></p>
        <a href="<?= base_url('kompetensi_pesdik/create/' . $id_kompetensi) ?>" class="btn btn-light btn-sm">Tambah Data</a>
    </div>
    <div class="card-body">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session('success') ?></div>
        <?php endif; ?>

        <table class="table table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Pesdik</th>
                    <th>Guru</th>
                    <th>Nomor SK</th>
                    <th>Status</th>
                    <th>Predikat</th>
                    <th>Tanggal Selesai</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($kompetensi_pesdik as $kp): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($kp['nama_pesdik']) ?></td>
                        <td><?= esc($kp['nama_guru']) ?></td>
                        <td><?= esc($kp['nomor_sk']) ?></td>
                        <td><?= esc($kp['status']) ?></td>
                        <td><?= esc($kp['predikat']) ?></td>
                        <td><?= esc($kp['tanggal_selesai']) ?></td>
                        <td>
                            <a href="<?= base_url('ujikom/index/' . $kp['id_kompetensi_pesdik']); ?>" class="btn btn-info btn-sm">Lihat Ujikom</a>
                            <a href="<?= base_url('kompetensi_pesdik/edit/' . $kp['id_kompetensi_pesdik']) ?>" class="btn btn-warning btn-sm">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="<?= base_url('kompetensi') ?>" class="btn btn-secondary">Kembali</a>
    </div>
</div>

<?= $this->endSection(); ?>