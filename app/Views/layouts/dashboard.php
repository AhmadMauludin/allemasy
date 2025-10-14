<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h2 class="mb-4 fw-bold text-primary"><?= esc($title) ?></h2>

    <?php if ($role === 'admin'): ?>
        <div class="row g-3">
            <?php
            $cards = [
                ['title' => 'Total User', 'value' => $userCount, 'icon' => 'bi-people-fill', 'color' => 'primary'],
                ['title' => 'Guru', 'value' => $guruCount, 'icon' => 'bi-person-badge-fill', 'color' => 'success'],
                ['title' => 'Peserta Didik', 'value' => $pesdikCount, 'icon' => 'bi-person-workspace', 'color' => 'info'],
                ['title' => 'Kelas', 'value' => $kelasCount, 'icon' => 'bi-easel-fill', 'color' => 'warning'],
                ['title' => 'Ruangan', 'value' => $ruanganCount, 'icon' => 'bi-building', 'color' => 'danger'],
            ];
            ?>

            <?php foreach ($cards as $c): ?>
                <div class="col-md-3">
                    <div class="card text-center shadow-sm border-0">
                        <div class="card-body">
                            <i class="bi <?= $c['icon'] ?> fs-1 text-<?= $c['color'] ?>"></i>
                            <p class="mt-2 mb-0 fw-semibold"><?= $c['title'] ?></p>
                            <p class="display-6 fw-bold"><?= $c['value'] ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    <?php elseif ($role === 'guru'): ?>
        <p>Selamat datang, <b><?= esc(session('username')) ?></b></p>

        <hr>

        <!-- Bagian Wali Kelas -->
        <h4>Kelas yang Diwalikan</h4>
        <?php if (!empty($pesanWali)): ?>
            <div class="alert alert-warning"><?= esc($pesanWali) ?></div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($kelasAmpu as $k): ?>
                    <div class="col-md-4 mb-3">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <h5 class="card-title"><?= esc($k['nama_kelas']) ?></h5>
                                <p class="card-text">Jumlah Peserta Didik: <?= esc($k['jumlah_pesdik']) ?></p>
                                <a href="<?= base_url('kelas/detail/' . $k['id_kelas']) ?>" class="btn btn-primary btn-sm">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <hr>

        <!-- Bagian Jadwal yang Diampu -->
        <h4>Jadwal yang Diampu</h4>
        <?php if (empty($jadwalGuru)): ?>
            <div class="alert alert-info">Belum ada jadwal yang diampu.</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Hari</th>
                            <th>Jam</th>
                            <th>Mata Pelajaran</th>
                            <th>Kelas</th>
                            <th>Ruangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($jadwalGuru as $j): ?>
                            <tr>
                                <td><?= esc($j['hari']) ?></td>
                                <td><?= esc($j['waktu_mulai']) ?> - <?= esc($j['waktu_selesai']) ?></td>
                                <td><?= esc($j['nama_mapel']) ?></td>
                                <td><?= esc($j['nama_kelas']) ?></td>
                                <td><?= esc($j['nama_ruangan'] ?? '-') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

    <?php elseif ($role === 'pesdik'): ?>
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <p>Halo, <?= esc($pesdik['nama']) ?> 👋</p>
                <?php if (!empty($pesdik)): ?>
                    <p>Anda terdaftar di kelas:</p>
                    <ul>
                        <?php foreach ($kelasIkut as $k): ?>
                            <li><?= esc($k['nama_kelas']) ?> [<?= esc($k['jenis_kelas']) ?>]</li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted">Belum terdaftar di kelas manapun.</p>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>