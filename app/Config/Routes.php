<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::PanitiaDashboard');
$routes->get('/batu', 'BatuControllers::DaftarBatu');
$routes->get('/kriteria', 'KriteriaControllers::DaftarKriteria');


// Menu Kelola Batu
$routes->get('/batu/tambah', 'BatuControllers::TambahBatu');
$routes->get('/batu/simpan', 'BatuControllers::simpan');

// Menu Kelola Kriteria
$routes->get('/kriteria/tambah', 'KriteriaControllers::TambahKriteria');
$routes->get('/kriteria/simpan', 'KriteriaControllers::simpan');
