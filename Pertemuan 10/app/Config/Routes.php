<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('HomeController');
$routes->setDefaultMethod('index');
$routes->setAutoRoute(false); // Matikan auto-routing demi keamanan

/*
 * --------------------------------------------------------------------
 * Route Publik (M1 - Fondasi: Landing Page)
 * --------------------------------------------------------------------
 */
$routes->get('/', 'HomeController::index', ['as' => 'home']);

/*
 * --------------------------------------------------------------------
 * Route berikut diaktifkan seiring milestone berikutnya.
 * Link di landing page memakai base_url() dengan path yang sama
 * (login, register, katalog, produk/slug), sehingga cukup menghapus
 * komentar saat controller-nya selesai dibuat.
 * --------------------------------------------------------------------
 */

// M2 - Autentikasi
// $routes->get('login', 'AuthController::login', ['as' => 'login']);
// $routes->post('login', 'AuthController::attemptLogin');
// $routes->get('register', 'AuthController::register', ['as' => 'register']);
// $routes->post('register', 'AuthController::attemptRegister');
// $routes->get('logout', 'AuthController::logout', ['as' => 'logout']);

// M3 - Customer Store
// $routes->get('katalog', 'ProductController::index', ['as' => 'catalog']);
// $routes->get('produk/(:segment)', 'ProductController::detail/$1', ['as' => 'product.detail']);
// $routes->group('keranjang', ['filter' => 'auth'], static function ($routes) {
//     $routes->get('/', 'CartController::index', ['as' => 'cart']);
// });

// M2/M5 - Area Admin (dilindungi filter role)
// $routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => 'auth:admin,operator'], static function ($routes) {
//     $routes->get('/', 'DashboardController::index', ['as' => 'admin.dashboard']);
// });
