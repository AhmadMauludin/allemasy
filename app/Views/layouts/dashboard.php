<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h2 class="mb-4"><?= esc($title) ?></h2>

    <?php if ($role === 'admin'): ?>
        <div class="row g-3">
            <div class="col-md-3">
                <div class="card text-center shadow-sm border-0">
                    <div class="card-body">
                        <p class="card-title">User</p>
                        <p class="display-6"><?= $userCount ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-center shadow-sm border-0">
                    <div class="card-body">
                        <p class="card-title">Guru</p>
                        <p class="display-6"><?= $guruCount ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-center shadow-sm border-0">
                    <div class="card-body">
                        <p class="card-title">Pesdik</p>
                        <p class="display-6"><?= $pesdikCount ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-center shadow-sm border-0">
                    <div class="card-body">
                        <p class="card-title">Kelas</p>
                        <p class="display-6"><?= $kelasCount ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-center shadow-sm border-0">
                    <div class="card-body">
                        <p class="card-title">Ruangan</p>
                        <p class="display-6"><?= $ruanganCount ?></p>
                    </div>
                </div>
            </div>
        </div>

    <?php elseif ($role === 'guru'): ?>
        <?php if (!empty($kelas)): ?>
            <div class="card shadow-sm">
                <div class="card-body">
                    <p>Wali Kelas: <b><?= esc($kelas['nama_kelas']) ?></b></p>
                    <p>Jumlah Peserta Didik: <b><?= esc($kelas['jumlah_pesdik']) ?></b></p>
                </div>
            </div>
        <?php else: ?>
            <p class="text-muted">Anda belum menjadi wali kelas mana pun.</p>
        <?php endif; ?>

    <?php elseif ($role === 'pesdik'): ?>
        <?php if (!empty($pesdik)): ?>
            <div class="card shadow-sm">
                <div class="card-body">
                    <p>Rombel Anda:</p>
                    <p class="fs-5"><b><?= esc($pesdik['nama_kelas']) ?></b></p>
                </div>
            </div>
        <?php else: ?>
            <p class="text-muted">Data kelas Anda belum terdaftar.</p>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>