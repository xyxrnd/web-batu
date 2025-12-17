<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::PanitiaDashboard');
$routes->get('/batu', 'BatuControllers::DaftarBatu');
$routes->get('/kriteria', 'KriteriaControllers::DaftarKriteria');
$routes->get('/kelas', 'KelasControllers::DaftarKelas');


// Menu Kelola Batu
$routes->get('/batu/tambah', 'BatuControllers::TambahBatu');
$routes->post('/batu/simpan', 'BatuControllers::SimpanBatu');
$routes->get('/batu/edit/(:num)', 'BatuControllers::EditBatu/$1');
$routes->post('/batu/update/(:num)', 'BatuControllers::UpdateBatu/$1');
$routes->get('/batu/hapus/(:num)', 'BatuControllers::HapusBatu/$1');

// Menu Kelola Kriteria
$routes->get('/kriteria/tambah', 'KriteriaControllers::TambahKriteria');
$routes->post('/kriteria/simpan', 'KriteriaControllers::SimpanKriteria');
$routes->get('/kriteria/edit/(:num)', 'KriteriaControllers::EditKriteria/$1');
$routes->post('/kriteria/update/(:num)', 'KriteriaControllers::UpdateKriteria/$1');
$routes->get('/kriteria/hapus/(:num)', 'KriteriaControllers::HapusKriteria/$1');
$routes->get('kriteria/bobot', 'KriteriaControllers::bobotAHP');
$routes->post('kriteria/simpan-bobot', 'KriteriaControllers::simpanBobot');


// Menu Kelola Kelas
$routes->get('/kelas/tambah', 'KelasControllers::create');
$routes->post('/kelas/simpan', 'KelasControllers::store');
$routes->get('/kelas/edit/(:num)', 'KelasControllers::edit/$1');
$routes->post('/kelas/update/(:num)', 'KelasControllers::update/$1');
$routes->get('/kelas/hapus/(:num)', 'KelasControllers::delete/$1');
