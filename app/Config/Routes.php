<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Auth::pilihPeran');
$routes->get('login', 'Auth::pilihPeran');
$routes->get('login/(:segment)', 'Auth::formLogin/$1');
$routes->post('login/proses', 'Auth::proses');
$routes->get('logout', 'Auth::logout');
$routes->get('dashboard', 'Dashboard::index', ['filter' => 'auth']);

$routes->group('admin', ['filter' => 'auth:admin', 'namespace' => 'App\Controllers\Admin'], function ($routes) {
    $routes->get('jenis-izin', 'JenisIzin::index');
    $routes->get('jenis-izin/tambah', 'JenisIzin::tambah');
    $routes->post('jenis-izin/simpan', 'JenisIzin::simpan');
    $routes->get('jenis-izin/ubah/(:num)', 'JenisIzin::ubah/$1');
    $routes->post('jenis-izin/perbarui/(:num)', 'JenisIzin::perbarui/$1');
    $routes->post('jenis-izin/status/(:num)', 'JenisIzin::status/$1');
    $routes->post('jenis-izin/hapus/(:num)', 'JenisIzin::hapus/$1');
});