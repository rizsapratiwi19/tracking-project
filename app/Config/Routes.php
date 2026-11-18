<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Auth::pilihPeran');
$routes->get('login', 'Auth::pilihPeran');
$routes->get('login/(:segment)', 'Auth::formLogin/$1');
$routes->post('login/proses', 'Auth::proses');
$routes->get('logout', 'Auth::logout');
$routes->get('dashboard', 'Dashboard::index', ['filter' => 'auth']);

$routes->group('permohonan', ['filter' => 'auth:front_office,admin'], function ($routes) {
    $routes->get('/', 'Permohonan::index');
    $routes->get('tambah', 'Permohonan::tambah');
    $routes->post('simpan', 'Permohonan::simpan');
});

$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('tugas', 'Berkas::tugas');
    $routes->get('berkas/(:num)', 'Berkas::detail/$1');
    $routes->post('berkas/(:num)/teruskan', 'Berkas::teruskan/$1');
});

$routes->group('admin', ['filter' => 'auth:admin', 'namespace' => 'App\Controllers\Admin'], function ($routes) {
    $routes->get('jenis-izin', 'JenisIzin::index');
    $routes->get('jenis-izin/tambah', 'JenisIzin::tambah');
    $routes->post('jenis-izin/simpan', 'JenisIzin::simpan');
    $routes->get('jenis-izin/ubah/(:num)', 'JenisIzin::ubah/$1');
    $routes->post('jenis-izin/perbarui/(:num)', 'JenisIzin::perbarui/$1');
    $routes->post('jenis-izin/status/(:num)', 'JenisIzin::status/$1');
    $routes->post('jenis-izin/hapus/(:num)', 'JenisIzin::hapus/$1');

    $routes->get('pengguna', 'Pengguna::index');
    $routes->get('pengguna/tambah', 'Pengguna::tambah');
    $routes->post('pengguna/simpan', 'Pengguna::simpan');
    $routes->get('pengguna/ubah/(:num)', 'Pengguna::ubah/$1');
    $routes->post('pengguna/perbarui/(:num)', 'Pengguna::perbarui/$1');
    $routes->post('pengguna/status/(:num)', 'Pengguna::status/$1');
});