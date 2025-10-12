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
$routes->get('pesdik', 'Pesdik::index');
$routes->get('pesdik/create', 'Pesdik::create');
$routes->post('pesdik/store', 'Pesdik::store');
$routes->get('pesdik/edit/(:num)', 'Pesdik::edit/$1');
$routes->post('pesdik/update/(:num)', 'Pesdik::update/$1');
$routes->get('pesdik/delete/(:num)', 'Pesdik::delete/$1');
$routes->get('pesdik/detail/(:num)', 'Pesdik::detail/$1');


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
