<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Auth::pilihPeran');
$routes->get('login', 'Auth::pilihPeran');
$routes->get('login/(:segment)', 'Auth::formLogin/$1');
$routes->post('login/proses', 'Auth::proses');
$routes->get('logout', 'Auth::logout');
$routes->get('dashboard', 'Dashboard::index', ['filter' => 'auth']);