<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
$routes->get('/login', 'AuthControllers::Login');
$routes->post('/login', 'AuthControllers::ProsesLogin');
$routes->get('/logout', 'AuthControllers::Logout');
$routes->get('/register', 'AuthControllers::Register');
$routes->post('/register/simpan', 'AuthControllers::ProsesRegister');



/*
|--------------------------------------------------------------------------
| DASHBOARD (WAJIB LOGIN)
|--------------------------------------------------------------------------
*/
$routes->get('/', 'Home::PanitiaDashboard', ['filter' => 'auth']);



/*
|--------------------------------------------------------------------------
| BATU (CRUD) - AUTH
|--------------------------------------------------------------------------
*/
$routes->group('batu', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'BatuControllers::DaftarBatu');
    $routes->get('tambah', 'BatuControllers::TambahBatu');
    $routes->post('simpan', 'BatuControllers::SimpanBatu');
    $routes->get('edit/(:num)', 'BatuControllers::EditBatu/$1');
    $routes->post('update/(:num)', 'BatuControllers::UpdateBatu/$1');
    $routes->post('hapus/(:num)', 'BatuControllers::HapusBatu/$1');
});


/*
|--------------------------------------------------------------------------
| KRITERIA (CRUD + BOBOT AHP) - AUTH
|--------------------------------------------------------------------------
*/
$routes->group('kriteria', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'KriteriaControllers::DaftarKriteria');
    $routes->get('tambah', 'KriteriaControllers::TambahKriteria');
    $routes->post('simpan', 'KriteriaControllers::SimpanKriteria');
    $routes->get('edit/(:num)', 'KriteriaControllers::EditKriteria/$1');
    $routes->post('update/(:num)', 'KriteriaControllers::UpdateKriteria/$1');
    $routes->post('hapus/(:num)', 'KriteriaControllers::HapusKriteria/$1');

    // Bobot AHP
    $routes->get('bobot', 'KriteriaControllers::bobotAHP');
    $routes->post('simpan-bobot', 'KriteriaControllers::simpanBobot');
});


/*
|--------------------------------------------------------------------------
| KELAS (CRUD) - AUTH
|--------------------------------------------------------------------------
*/
$routes->group('kelas', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'KelasControllers::DaftarKelas');
    $routes->get('tambah', 'KelasControllers::create');
    $routes->post('simpan', 'KelasControllers::store');
    $routes->get('edit/(:num)', 'KelasControllers::edit/$1');
    $routes->post('update/(:num)', 'KelasControllers::update/$1');
    $routes->post('hapus/(:num)', 'KelasControllers::delete/$1');
});


/*
|--------------------------------------------------------------------------
| USER (CRUD) - AUTH
|--------------------------------------------------------------------------
*/
// $routes->group('user', ['filter' => 'auth'], function ($routes) {
//     $routes->get('/', 'UserControllers::DaftarUser');
//     $routes->get('tambah', 'UserControllers::TambahUser');
//     $routes->post('simpan', 'UserControllers::SimpanUser');
//     $routes->get('edit/(:num)', 'UserControllers::EditUser/$1');
//     $routes->post('update/(:num)', 'UserControllers::UpdateUser/$1');
//     $routes->post('hapus/(:num)', 'UserControllers::HapusUser/$1');
// });
$routes->group('user', function ($routes) {
    $routes->get('/', 'UserControllers::DaftarUser');
    $routes->get('tambah', 'UserControllers::TambahUser');
    $routes->post('simpan', 'UserControllers::SimpanUser');
    $routes->get('edit/(:num)', 'UserControllers::EditUser/$1');
    $routes->post('update/(:num)', 'UserControllers::UpdateUser/$1');
    $routes->post('hapus/(:num)', 'UserControllers::HapusUser/$1');
});


$routes->group('ahp', ['filter' => 'auth'], function ($routes) {

    // =========================
    // FORM INPUT BOBOT
    // =========================
    $routes->get('/', 'AhpControllers::tambahBobot');

    // =========================
    // SIMPAN INPUT USER
    // =========================
    $routes->post('simpan', 'AhpControllers::simpanBobot');

    // =========================
    // LIHAT HASIL BOBOT (GROUP AHP)
    // =========================
    $routes->get('hasil/(:num)', 'AhpControllers::hasilBobot/$1');
});

$routes->get('/pendaftaran', 'PendaftaranControllers::index');
$routes->get('/pendaftaran/create', 'PendaftaranControllers::create');
$routes->post('/pendaftaran/store', 'PendaftaranControllers::store');
$routes->get('/pendaftaran/edit/(:num)', 'PendaftaranControllers::edit/$1');
$routes->post('/pendaftaran/update/(:num)', 'PendaftaranControllers::update/$1');
$routes->get('/pendaftaran/delete/(:num)', 'PendaftaranControllers::delete/$1');
$routes->get('/pendaftaran/detail/(:num)', 'PendaftaranControllers::detail/$1');
