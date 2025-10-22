<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// =========================================================
// 🔒 FILTER
// =========================================================
$authFilter = ['filter' => 'auth'];

// Role Filters
$admin   = ['filter' => 'role:admin'];
$guru    = ['filter' => 'role:guru'];
$pesdik  = ['filter' => 'role:pesdik'];
$kepsek  = ['filter' => 'role:kepsek'];
$allRole = ['filter' => 'role:admin, pesdik, guru, kepsek'];

// =========================================================
// 🔐 AUTHENTICATION ROUTES
// =========================================================
$routes->get('login', 'Auth::index');
$routes->post('login/auth', 'Auth::auth');
$routes->get('logout', 'Auth::logout');

// =========================================================
// 🏠 DASHBOARD
// =========================================================
$routes->get('/', 'Home::index', $authFilter);
$routes->get('dashboard', 'Home::index', $authFilter);

// =========================================================
// 👩‍🎓 CRUD PESDIK
// =========================================================
$routes->group('pesdik', $admin, function ($routes) {
    $routes->get('/', 'Pesdik::index');
    $routes->get('create', 'Pesdik::create');
    $routes->post('store', 'Pesdik::store');
    $routes->get('delete/(:num)', 'Pesdik::delete/$1');
    $routes->get('detail/(:num)', 'Pesdik::detail/$1');
    $routes->get('kartu/(:num)', 'Pesdik::kartu/$1');
});

$routes->group('pesdik', $allRole, function ($routes) {
    $routes->get('edit/(:num)', 'Pesdik::edit/$1', ['filter' => 'owner:tb_pesdik,id_pesdik']);
    $routes->post('update/(:num)', 'Pesdik::update/$1', ['filter' => 'owner:tb_pesdik,id_pesdik']);
    $routes->get('kartu/(:num)', 'Pesdik::kartu/$1');
});

// =========================================================
// 🏫 CRUD KELAS
// =========================================================
$routes->group('kelas', $authFilter, function ($routes) {
    $routes->get('/', 'Kelas::index');
    $routes->get('create', 'Kelas::create');
    $routes->post('store', 'Kelas::store');
    $routes->get('edit/(:num)', 'Kelas::edit/$1');
    $routes->get('detail/(:num)', 'Kelas::detail/$1');
    $routes->post('update/(:num)', 'Kelas::update/$1');
    $routes->get('delete/(:num)', 'Kelas::delete/$1');
});

// =========================================================
// 🏢 CRUD RUANGAN
// =========================================================
$routes->group('ruangan', $authFilter, function ($routes) {
    $routes->get('/', 'Ruangan::index');
    $routes->get('create', 'Ruangan::create');
    $routes->post('store', 'Ruangan::store');
    $routes->get('edit/(:num)', 'Ruangan::edit/$1');
    $routes->post('update/(:num)', 'Ruangan::update/$1');
    $routes->get('delete/(:num)', 'Ruangan::delete/$1');
});

// =========================================================
// 👩‍🏫 CRUD GURU
// =========================================================
$routes->group('guru', $authFilter, function ($routes) {
    $routes->get('/', 'Guru::index');
    $routes->get('create', 'Guru::create');
    $routes->post('store', 'Guru::store');
    $routes->get('edit/(:num)', 'Guru::edit/$1');
    $routes->post('update/(:num)', 'Guru::update/$1');
    $routes->get('delete/(:num)', 'Guru::delete/$1');
    $routes->get('detail/(:num)', 'Guru::detail/$1');
});

// =========================================================
// 💼 CRUD JABATAN
// =========================================================
$routes->group('jabatan', $authFilter, function ($routes) {
    $routes->get('/', 'Jabatan::index');
    $routes->get('create', 'Jabatan::create');
    $routes->post('store', 'Jabatan::store');
    $routes->get('edit/(:num)', 'Jabatan::edit/$1');
    $routes->post('update/(:num)', 'Jabatan::update/$1');
    $routes->get('delete/(:num)', 'Jabatan::delete/$1');
});

// =========================================================
// 👤 CRUD USER (ADMIN ONLY)
// =========================================================
$routes->group('user', $admin, function ($routes) {
    $routes->get('/', 'User::index');
    $routes->get('create', 'User::create');
    $routes->post('store', 'User::store');
    $routes->get('edit/(:num)', 'User::edit/$1');
    $routes->post('update/(:num)', 'User::update/$1');
    $routes->get('delete/(:num)', 'User::delete/$1');
    $routes->get('detail/(:num)', 'User::detail/$1');
});

// =========================================================
// 💾 BACKUP DATABASE
// =========================================================
$routes->get('backup', 'Backup::database', $authFilter);

// =========================================================
// 📚 CRUD BUKU
// =========================================================
$routes->group('buku', $authFilter, function ($routes) {
    $routes->get('/', 'Buku::index');
    $routes->get('create', 'Buku::create');
    $routes->post('store', 'Buku::store');
    $routes->get('show/(:num)', 'Buku::show/$1');
    $routes->get('edit/(:num)', 'Buku::edit/$1');
    $routes->post('update/(:num)', 'Buku::update/$1');
    $routes->get('delete/(:num)', 'Buku::delete/$1');
});

// =========================================================
// 📘 MAPEL, KONTRAK, JADWAL
// =========================================================
$routes->group('mapel', $authFilter, function ($routes) {
    $routes->get('/', 'Mapel::index');
    $routes->get('create', 'Mapel::create');
    $routes->post('store', 'Mapel::store');
    $routes->get('edit/(:num)', 'Mapel::edit/$1');
    $routes->post('update/(:num)', 'Mapel::update/$1');
    $routes->get('delete/(:num)', 'Mapel::delete/$1');
});

$routes->group('kontrak', $authFilter, function ($routes) {
    $routes->get('/', 'KontrakJadwal::index');
    $routes->get('create', 'KontrakJadwal::create');
    $routes->post('store', 'KontrakJadwal::store');
    $routes->get('edit/(:num)', 'KontrakJadwal::edit/$1');
    $routes->post('update/(:num)', 'KontrakJadwal::update/$1');
    $routes->get('delete/(:num)', 'KontrakJadwal::delete/$1');
});

$routes->group('jadwal', $authFilter, function ($routes) {
    $routes->get('/', 'Jadwal::index');
    $routes->get('create', 'Jadwal::create');
    $routes->post('store', 'Jadwal::store');
    $routes->get('edit/(:num)', 'Jadwal::edit/$1');
    $routes->post('update/(:num)', 'Jadwal::update/$1');
    $routes->get('delete/(:num)', 'Jadwal::delete/$1');
    $routes->get('detail/(:num)', 'Jadwal::detail/$1');
});

// =========================================================
// 🧩 PERTEMUAN, PRESENSI, MATERI, TUGAS
// =========================================================
$routes->group('pertemuan', $authFilter, function ($routes) {
    $routes->get('/', 'Pertemuan::index');
    $routes->get('create', 'Pertemuan::create');
    $routes->get('create/(:num)', 'Pertemuan::create/$1');
    $routes->post('store', 'Pertemuan::store');
    $routes->get('edit/(:num)', 'Pertemuan::edit/$1');
    $routes->post('update/(:num)', 'Pertemuan::update/$1');
    $routes->get('delete/(:num)', 'Pertemuan::delete/$1');
    $routes->get('detail/(:num)', 'Pertemuan::detail/$1');
});

$routes->get('presensi/edit/(:num)', 'Presensi::edit/$1');
$routes->post('presensi/update/(:num)', 'Presensi::update/$1');

$routes->post('pertemuan/updateStatus/(:num)', 'Pertemuan::updateStatus/$1');
$routes->get('pertemuan/scan/(:num)', 'Pertemuan::scan/$1');
$routes->post('pertemuan/scanProcess', 'Pertemuan::scanProcess');

$routes->post('materi/store', 'Materi::store');
$routes->get('materi/delete/(:num)', 'Materi::delete/$1');

$routes->post('tugas/store', 'Tugas::store');
$routes->get('tugas/delete/(:num)', 'Tugas::delete/$1');

$routes->group('pengumpulan_tugas', $authFilter, function ($routes) {
    $routes->get('(:num)', 'PengumpulanTugas::index/$1');
    $routes->get('create/(:num)', 'PengumpulanTugas::create/$1');
    $routes->post('store', 'PengumpulanTugas::store');
    $routes->get('edit/(:num)', 'PengumpulanTugas::edit/$1');
    $routes->post('update/(:num)', 'PengumpulanTugas::update/$1');
});

// =========================================================
// 📈 KOMPETENSI & UJIKOM
// =========================================================
$routes->group('kompetensi', $authFilter, function ($routes) {
    $routes->get('/', 'Kompetensi::index');
    $routes->get('create', 'Kompetensi::create');
    $routes->post('store', 'Kompetensi::store');
    $routes->get('edit/(:num)', 'Kompetensi::edit/$1');
    $routes->post('update/(:num)', 'Kompetensi::update/$1');
    $routes->get('delete/(:num)', 'Kompetensi::delete/$1');
});

$routes->group('kompetensi_pesdik', $authFilter, function ($routes) {
    $routes->get('index/(:num)', 'KompetensiPesdik::index/$1');
    $routes->get('create/(:num)', 'KompetensiPesdik::create/$1');
    $routes->post('store', 'KompetensiPesdik::store');
    $routes->get('edit/(:num)', 'KompetensiPesdik::edit/$1');
    $routes->post('update/(:num)', 'KompetensiPesdik::update/$1');
    $routes->get('delete/(:num)', 'KompetensiPesdik::delete/$1');
});

$routes->group('ujikom', $authFilter, function ($routes) {
    $routes->get('index/(:num)', 'Ujikom::index/$1');
    $routes->get('create/(:num)', 'Ujikom::create/$1');
    $routes->post('store', 'Ujikom::store');
    $routes->get('edit/(:num)', 'Ujikom::edit/$1');
    $routes->post('update/(:num)', 'Ujikom::update/$1');
    $routes->get('delete/(:num)', 'Ujikom::delete/$1');
});

// =========================================================
// 🕒 DISPENSASI & KELAS PESDIK
// =========================================================
$routes->group('dispensasi', $authFilter, function ($routes) {
    $routes->get('/', 'Dispensasi::index');
    $routes->get('create', 'Dispensasi::create');
    $routes->post('store', 'Dispensasi::store');
    $routes->get('edit/(:num)', 'Dispensasi::edit/$1');
    $routes->post('update/(:num)', 'Dispensasi::update/$1');
    $routes->get('delete/(:num)', 'Dispensasi::delete/$1');
});

$routes->post('kelas_pesdik/store', 'KelasPesdik::store');
$routes->get('kelas_pesdik/delete/(:num)', 'KelasPesdik::delete/$1');

// =========================================================
// 🙏 SHOLAT & PRESENSI SHOLAT
// =========================================================
$routes->group('sholat', $authFilter, function ($routes) {
    $routes->get('/', 'Sholat::index');
    $routes->get('create', 'Sholat::create');
    $routes->post('store', 'Sholat::store');
    $routes->get('detail/(:num)', 'Sholat::detail/$1');
    $routes->get('edit/(:num)', 'Sholat::edit/$1');
    $routes->post('update/(:num)', 'Sholat::update/$1');
    $routes->get('delete/(:num)', 'Sholat::delete/$1');
    $routes->get('scan/(:num)', 'Sholat::scan/$1');
    $routes->post('prosesScan', 'Sholat::prosesScan');
    $routes->post('updateStatus/(:num)', 'Sholat::updateStatus/$1');
});

$routes->group('presensi_sholat', $authFilter, function ($routes) {
    $routes->post('update/(:num)', 'PresensiSholat::update/$1');
    $routes->get('delete/(:num)', 'PresensiSholat::delete/$1');
});

// =========================================================
// 💰 BIAYA, PEMBAYARAN, TRANSFER, TABUNGAN
// =========================================================
$routes->group('biaya', $authFilter, function ($routes) {
    $routes->get('/', 'Biaya::index');
    $routes->get('create', 'Biaya::create');
    $routes->post('store', 'Biaya::store');
    $routes->get('detail/(:num)', 'Biaya::detail/$1');
    $routes->get('delete/(:num)', 'Biaya::delete/$1');
});

$routes->group('pembayaran', $authFilter, function ($routes) {
    $routes->get('edit/(:num)', 'Pembayaran::edit/$1');
    $routes->post('update/(:num)', 'Pembayaran::update/$1');
});

$routes->group('transfer', $authFilter, function ($routes) {
    $routes->get('/', 'Transfer::index');
    $routes->get('create', 'Transfer::create');
    $routes->post('store', 'Transfer::store');
    $routes->get('edit/(:num)', 'Transfer::edit/$1');
    $routes->post('update/(:num)', 'Transfer::update/$1');
    $routes->get('delete/(:num)', 'Transfer::delete/$1');
    $routes->get('kirimNotif/(:num)', 'Transfer::kirimNotif/$1');
});

$routes->group('tabungan', $authFilter, function ($routes) {
    $routes->get('/', 'Tabungan::index');
    $routes->get('create', 'Tabungan::create');
    $routes->post('store', 'Tabungan::store');
    $routes->get('edit/(:num)', 'Tabungan::edit/$1');
    $routes->post('update/(:num)', 'Tabungan::update/$1');
    $routes->get('delete/(:num)', 'Tabungan::delete/$1');
    $routes->get('detail/(:num)', 'Tabungan::detail/$1');
    $routes->get('kirimNotif/(:num)', 'Tabungan::kirimNotif/$1');
});
