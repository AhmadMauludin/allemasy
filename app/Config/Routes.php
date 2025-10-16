<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$authFilter = ['filter' => 'auth'];

// Variabel Role
$admin     = ['filter' => 'role:admin'];
$guru      = ['filter' => 'role:guru'];
$siswa     = ['filter' => 'role:siswa'];
$kepsek    = ['filter' => 'role:kepsek'];
$allRole   = ['filter' => 'role:admin, siswa, guru, kepsek'];

// Login
$routes->get('/', 'Home::index', $authFilter);
$routes->get('login', 'Auth::index');
$routes->post('login/auth', 'Auth::auth');
$routes->get('logout', 'Auth::logout');

// Dashboard
$routes->get('/dashboard', 'Home::index', $authFilter);

// CRUD Pesdik
$routes->get('pesdik', 'Pesdik::index', $admin);
$routes->get('pesdik/create', 'Pesdik::create');
$routes->post('pesdik/store', 'Pesdik::store');
$routes->get('pesdik/edit/(:num)', 'Pesdik::edit/$1');
$routes->post('pesdik/update/(:num)', 'Pesdik::update/$1');
$routes->get('pesdik/delete/(:num)', 'Pesdik::delete/$1');
$routes->get('pesdik/detail/(:num)', 'Pesdik::detail/$1');
$routes->get('pesdik/kartu/(:num)', 'Pesdik::kartu/$1');

// CRUD KELAS
$routes->group('kelas', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Kelas::index');             // Tampilkan daftar kelas
    $routes->get('create', 'Kelas::create');       // Form tambah kelas
    $routes->post('store', 'Kelas::store');        // Simpan kelas baru
    $routes->get('edit/(:num)', 'Kelas::edit/$1'); // Form edit kelas
    $routes->get('detail/(:num)', 'Kelas::detail/$1'); // Form detail kelas
    $routes->post('update/(:num)', 'Kelas::update/$1'); // Simpan hasil edit
    $routes->get('delete/(:num)', 'Kelas::delete/$1');  // Hapus kelas
});

// CRUD RUANGAN
$routes->group('ruangan', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Ruangan::index');             // Tampilkan daftar ruangan
    $routes->get('create', 'Ruangan::create');       // Form tambah ruangan
    $routes->post('store', 'Ruangan::store');        // Simpan ruangan baru
    $routes->get('edit/(:num)', 'Ruangan::edit/$1'); // Form edit ruangan
    $routes->post('update/(:num)', 'Ruangan::update/$1'); // Simpan hasil edit
    $routes->get('delete/(:num)', 'Ruangan::delete/$1');  // Hapus ruangan
});

// GURU
$routes->group('guru', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Guru::index');
    $routes->get('create', 'Guru::create');
    $routes->post('store', 'Guru::store');
    $routes->get('edit/(:num)', 'Guru::edit/$1');
    $routes->post('update/(:num)', 'Guru::update/$1');
    $routes->get('delete/(:num)', 'Guru::delete/$1');
    $routes->get('detail/(:num)', 'Guru::detail/$1');
});

// JABATAN
$routes->group('jabatan', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Jabatan::index');
    $routes->get('create', 'Jabatan::create');
    $routes->post('store', 'Jabatan::store');
    $routes->get('edit/(:num)', 'Jabatan::edit/$1');
    $routes->post('update/(:num)', 'Jabatan::update/$1');
    $routes->get('delete/(:num)', 'Jabatan::delete/$1');
});

// User
$routes->group('user', ['filter' => $admin], function ($routes) {
    $routes->get('/', 'User::index');
    $routes->get('create', 'User::create');
    $routes->post('store', 'User::store');
    $routes->get('edit/(:num)', 'User::edit/$1');
    $routes->post('update/(:num)', 'User::update/$1');
    $routes->get('delete/(:num)', 'User::delete/$1');
    $routes->get('detail/(:num)', 'User::detail/$1');
});

// Backup Database
$routes->get('backup', 'Backup::database');

$routes->group('buku', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Buku::index');
    $routes->get('create', 'Buku::create');
    $routes->post('store', 'Buku::store');
    $routes->get('show/(:num)', 'Buku::show/$1');
    $routes->get('edit/(:num)', 'Buku::edit/$1');
    $routes->post('update/(:num)', 'Buku::update/$1');
    $routes->get('delete/(:num)', 'Buku::delete/$1');
});

$routes->get('/mapel', 'Mapel::index');
$routes->get('/mapel/create', 'Mapel::create');
$routes->post('/mapel/store', 'Mapel::store');
$routes->get('/mapel/edit/(:num)', 'Mapel::edit/$1');
$routes->post('/mapel/update/(:num)', 'Mapel::update/$1');
$routes->get('/mapel/delete/(:num)', 'Mapel::delete/$1');

$routes->get('/kontrak', 'KontrakJadwal::index');
$routes->get('/kontrak/create', 'KontrakJadwal::create');
$routes->post('/kontrak/store', 'KontrakJadwal::store');
$routes->get('/kontrak/edit/(:num)', 'KontrakJadwal::edit/$1');
$routes->post('/kontrak/update/(:num)', 'KontrakJadwal::update/$1');
$routes->get('/kontrak/delete/(:num)', 'KontrakJadwal::delete/$1');

$routes->get('/jadwal', 'Jadwal::index');
$routes->get('/jadwal/create', 'Jadwal::create');
$routes->post('/jadwal/store', 'Jadwal::store');
$routes->get('/jadwal/edit/(:num)', 'Jadwal::edit/$1');
$routes->post('/jadwal/update/(:num)', 'Jadwal::update/$1');
$routes->get('/jadwal/delete/(:num)', 'Jadwal::delete/$1');
$routes->get('jadwal/detail/(:num)', 'Jadwal::detail/$1');


$routes->group('pertemuan', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Pertemuan::index');
    $routes->get('create', 'Pertemuan::create');
    $routes->get('create/(:num)', 'Pertemuan::create/$1');
    $routes->post('store', 'Pertemuan::store');
    $routes->get('edit/(:num)', 'Pertemuan::edit/$1');
    $routes->post('update/(:num)', 'Pertemuan::update/$1');
    $routes->get('delete/(:num)', 'Pertemuan::delete/$1');
    $routes->get('detail/(:num)', 'Pertemuan::detail/$1');
});

$routes->get('/presensi/edit/(:num)', 'Presensi::edit/$1');
$routes->post('/presensi/update/(:num)', 'Presensi::update/$1');

$routes->post('/pertemuan/updateStatus/(:num)', 'Pertemuan::updateStatus/$1');
$routes->get('/pertemuan/scan/(:num)', 'Pertemuan::scan/$1');
$routes->post('/pertemuan/scanProcess', 'Pertemuan::scanProcess');

$routes->post('materi/store', 'Materi::store');
$routes->get('materi/delete/(:num)', 'Materi::delete/$1');

$routes->post('tugas/store', 'Tugas::store');
$routes->get('tugas/delete/(:num)', 'Tugas::delete/$1');

$routes->get('pengumpulan_tugas/(:num)', 'PengumpulanTugas::index/$1');
$routes->get('pengumpulan_tugas/create/(:num)', 'PengumpulanTugas::create/$1');
$routes->post('pengumpulan_tugas/store', 'PengumpulanTugas::store');
$routes->get('pengumpulan_tugas/edit/(:num)', 'PengumpulanTugas::edit/$1');
$routes->post('pengumpulan_tugas/update/(:num)', 'PengumpulanTugas::update/$1');

$routes->group('kompetensi', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Kompetensi::index');
    $routes->get('create', 'Kompetensi::create');
    $routes->post('store', 'Kompetensi::store');
    $routes->get('edit/(:num)', 'Kompetensi::edit/$1');
    $routes->post('update/(:num)', 'Kompetensi::update/$1');
    $routes->get('delete/(:num)', 'Kompetensi::delete/$1');
});

$routes->get('/kompetensi_pesdik/index/(:num)', 'KompetensiPesdik::index/$1');
$routes->get('/kompetensi_pesdik/create/(:num)', 'KompetensiPesdik::create/$1');
$routes->post('/kompetensi_pesdik/store', 'KompetensiPesdik::store');
$routes->get('/kompetensi_pesdik/edit/(:num)', 'KompetensiPesdik::edit/$1');
$routes->post('/kompetensi_pesdik/update/(:num)', 'KompetensiPesdik::update/$1');
$routes->get('kompetensi_pesdik/delete/(:num)', 'KompetensiPesdik::delete/$1');


$routes->group('ujikom', ['filter' => 'auth'], function ($routes) {
    $routes->get('index/(:num)', 'Ujikom::index/$1');
    $routes->get('create/(:num)', 'Ujikom::create/$1');
    $routes->post('store', 'Ujikom::store');
    $routes->get('edit/(:num)', 'Ujikom::edit/$1');
    $routes->post('update/(:num)', 'Ujikom::update/$1');
    $routes->get('delete/(:num)', 'Ujikom::delete/$1');
});

$routes->get('dispensasi', 'Dispensasi::index');
$routes->get('dispensasi/create', 'Dispensasi::create');
$routes->post('dispensasi/store', 'Dispensasi::store');
$routes->get('dispensasi/edit/(:num)', 'Dispensasi::edit/$1');
$routes->post('dispensasi/update/(:num)', 'Dispensasi::update/$1');
$routes->get('dispensasi/delete/(:num)', 'Dispensasi::delete/$1');

$routes->post('kelas_pesdik/store', 'KelasPesdik::store');
$routes->get('kelas_pesdik/delete/(:num)', 'KelasPesdik::delete/$1');


// ROUTES UNTUK SHOLAT
$routes->group('sholat', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Sholat::index');                                // daftar semua sholat
    $routes->get('create', 'Sholat::create');                          // form tambah sholat
    $routes->post('store', 'Sholat::store');                           // simpan sholat baru + generate presensi otomatis
    $routes->get('detail/(:num)', 'Sholat::detail/$1');                // detail + daftar presensi
    $routes->get('edit/(:num)', 'Sholat::edit/$1');                    // edit sholat
    $routes->post('update/(:num)', 'Sholat::update/$1');               // update sholat
    $routes->get('delete/(:num)', 'Sholat::delete/$1');                // hapus sholat
    $routes->get('scan/(:num)', 'Sholat::scan/$1');                    // halaman scan QR presensi
    $routes->post('prosesScan', 'Sholat::prosesScan'); // ✅ ini yang hilang
    $routes->post('updateStatus/(:num)', 'Sholat::updateStatus/$1');             // ubah status_sholat jadi 'selesai'
});


// ROUTES UNTUK PRESENSI SHOLAT
$routes->group('presensi_sholat', ['filter' => 'auth'], function ($routes) {
    $routes->post('update/(:num)', 'PresensiSholat::update/$1');       // update status & keterangan presensi
    $routes->get('delete/(:num)', 'PresensiSholat::delete/$1');        // hapus presensi sholat
});

// Routes Biaya
$routes->get('biaya', 'Biaya::index');                // Halaman index biaya
$routes->get('biaya/create', 'Biaya::create');        // Form tambah biaya
$routes->post('biaya/store', 'Biaya::store');         // Simpan data biaya baru
$routes->get('biaya/detail/(:num)', 'Biaya::detail/$1'); // Detail biaya
$routes->get('biaya/delete/(:num)', 'Biaya::delete/$1'); // Hapus biaya

// Routes Pembayaran
$routes->get('pembayaran/edit/(:num)', 'Pembayaran::edit/$1');   // Form edit pembayaran
$routes->post('pembayaran/update/(:num)', 'Pembayaran::update/$1'); // Update pembayaran

// Transfer
$routes->get('transfer', 'Transfer::index');
$routes->get('transfer/create', 'Transfer::create');
$routes->post('transfer/store', 'Transfer::store');
$routes->get('transfer/edit/(:num)', 'Transfer::edit/$1');
$routes->post('transfer/update/(:num)', 'Transfer::update/$1');
$routes->get('transfer/delete/(:num)', 'Transfer::delete/$1');
$routes->get('transfer/kirimNotif/(:num)', 'Transfer::kirimNotif/$1');
