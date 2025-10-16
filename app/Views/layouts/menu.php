    <?php $idu = session('id_user'); ?>
    <?php $idp = session('id_pesdik'); ?>
    <?php $idg = session('id_guru'); ?>

    <ul class="nav flex-column mt-3">
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('/') ?>">
                <i class="bi bi-house"></i> <span>Dashboard</span>
            </a>
        </li>
        <?php if (session()->get('role') == 'admin') : ?>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('user') ?>">
                    <i class="bi bi-people"></i> <span>User</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('pesdik') ?>">
                    <i class="bi bi-people"></i> <span>Pesdik</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('guru') ?>">
                    <i class="bi bi-people"></i> <span>Guru</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('ruangan') ?>">
                    <i class="bi bi-house"></i> <span>Ruangan</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('buku') ?>">
                    <i class="bi bi-book"></i> <span>Buku</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('mapel') ?>">
                    <i class="bi bi-book"></i> <span>Mapel</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('pertemuan') ?>">
                    <i class="bi bi-calendar"></i> <span>Pertemuan</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('kompetensi') ?>">
                    <i class="bi bi-award"></i> <span>Kompetensi</span>
                </a>
            </li>
        <?php endif; ?>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('kelas') ?>">
                <i class="bi bi-house"></i> <span>Rombel</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('kontrak') ?>">
                <i class="bi bi-book"></i> <span>Kontrak</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('jadwal') ?>">
                <i class="bi bi-clock"></i> <span>Jadwal</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('dispensasi') ?>">
                <i class="bi bi-bookmark-x"></i> <span>Dispensasi</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('sholat') ?>">
                <i class="bi bi-person-standing"></i> <span>Sholat</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('biaya') ?>">
                <i class="bi bi-cash"></i> <span>Biaya</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('transfer') ?>">
                <i class="bi bi-send"></i> <span>transfer</span>
            </a>
        </li>
        <hr>

        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('backup') ?>">
                <i class="bi bi-download"></i> <span>Backup</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= site_url('user/edit/' . $idu) ?>">
                <i class="bi bi-gear"></i> <span>Setting</span>
            </a>
        </li>
        <?php if (session()->get('role') == 'guru') : ?>
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('guru/edit/' . $idg) ?>">
                    <i class="bi bi-card-list"></i> <span>Profile</span>
                </a>
            </li>
        <?php endif; ?>
        <?php if (session()->get('role') == 'pesdik') : ?>
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('pesdik/edit/' . $idp) ?>">
                    <i class="bi bi-card-list"></i> <span>Profile</span>
                </a>
            </li>
        <?php endif; ?>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('logout') ?>">
                <i class="bi bi-box-arrow-right"></i> <span>Logout</span>
            </a>
        </li>
    </ul>