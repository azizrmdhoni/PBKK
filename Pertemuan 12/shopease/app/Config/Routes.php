<?php

use App\Controllers\Admin\CategoryController;
use App\Controllers\Admin\ProductController;
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
    $routes->get('pesanan', 'ModuleController::adminOrders');
    $routes->get('laporan', 'ModuleController::adminReports');
    $routes->get('pengguna', 'ModuleController::adminUsers');
});

/*
 * --------------------------------------------------------------------
 * Product Management (M2): kategori, produk, gambar, stok
 * Dapat diakses Administrator dan Operator. Customer ditolak oleh AuthFilter.
 * --------------------------------------------------------------------
 */
$routes->group('admin', ['filter' => 'auth:admin,operator'], static function ($routes) {
    // Produk
    $routes->get('products', [ProductController::class, 'index']);
    $routes->get('products/create', [ProductController::class, 'create']);
    $routes->post('products/store', [ProductController::class, 'store']);
    $routes->get('products/edit/(:num)', [ProductController::class, 'edit']);
    $routes->post('products/update/(:num)', [ProductController::class, 'update']);
    $routes->post('products/delete/(:num)', [ProductController::class, 'delete']);
    $routes->post('products/stock/(:num)', [ProductController::class, 'updateStock']);

    // Galeri gambar produk
    $routes->post('products/image/primary/(:num)', [ProductController::class, 'setPrimaryImage']);
    $routes->post('products/image/delete/(:num)', [ProductController::class, 'deleteImage']);

    // Kategori
    $routes->get('categories', [CategoryController::class, 'index']);
    $routes->get('categories/create', [CategoryController::class, 'create']);
    $routes->post('categories/store', [CategoryController::class, 'store']);
    $routes->get('categories/edit/(:num)', [CategoryController::class, 'edit']);
    $routes->post('categories/update/(:num)', [CategoryController::class, 'update']);
    $routes->post('categories/delete/(:num)', [CategoryController::class, 'delete']);
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
