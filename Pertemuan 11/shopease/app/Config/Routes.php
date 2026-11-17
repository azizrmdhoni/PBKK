<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('HomeController');
$routes->setDefaultMethod('index');
$routes->setAutoRoute(false); // Auto-routing dimatikan demi keamanan

/*
 * --------------------------------------------------------------------
 * Halaman publik (PRD bagian 10: Homepage, Katalog, Detail Produk)
 * --------------------------------------------------------------------
 */
$routes->get('/', 'HomeController::index', ['as' => 'home']);
$routes->get('katalog', 'ModuleController::catalog');
$routes->get('produk/(:segment)', 'ModuleController::product/$1');

/*
 * --------------------------------------------------------------------
 * Autentikasi (FR-001 s/d FR-003)
 * --------------------------------------------------------------------
 */
$routes->group('', ['filter' => 'guest'], static function ($routes) {
    $routes->get('register', 'AuthController::registerForm');
    $routes->post('register', 'AuthController::register');
    $routes->get('login', 'AuthController::loginForm');
    $routes->post('login', 'AuthController::login');
});

// Logout: POST + CSRF, harus sedang login
$routes->post('logout', 'AuthController::logout', ['filter' => 'auth']);

/*
 * --------------------------------------------------------------------
 * Area Customer (BR-001, BR-006): hanya role customer
 * --------------------------------------------------------------------
 */
$routes->group('', ['filter' => 'auth:customer'], static function ($routes) {
    $routes->get('keranjang', 'ModuleController::cart');
    $routes->get('checkout', 'ModuleController::checkout');
    $routes->get('pesanan', 'ModuleController::orders');
    $routes->get('pesanan/(:segment)', 'ModuleController::orderDetail/$1');
});

/*
 * --------------------------------------------------------------------
 * Area Administrator
 * --------------------------------------------------------------------
 */
$routes->group('admin', ['filter' => 'auth:admin'], static function ($routes) {
    $routes->get('/', 'Admin\DashboardController::index');
    $routes->get('kategori', 'ModuleController::adminCategories');
    $routes->get('produk', 'ModuleController::adminProducts');
    $routes->get('pesanan', 'ModuleController::adminOrders');
    $routes->get('laporan', 'ModuleController::adminReports');
    $routes->get('pengguna', 'ModuleController::adminUsers');
});

/*
 * --------------------------------------------------------------------
 * Area Operator Toko
 * --------------------------------------------------------------------
 */
$routes->group('operator', ['filter' => 'auth:operator'], static function ($routes) {
    $routes->get('/', 'Operator\DashboardController::index');
    $routes->get('pesanan', 'ModuleController::operatorOrders');
    $routes->get('pengiriman', 'ModuleController::operatorShipments');
});
