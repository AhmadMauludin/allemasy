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


    <hr>

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('backup') ?>">
            <i class="bi bi-download"></i> <span>Backup</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('logout') ?>">
            <i class="bi bi-box-arrow-right"></i> <span>Logout</span>
        </a>
    </li>
</ul>