<?php
// Tempel ke app/Config/Routes.php (di dalam file, setelah $routes = ...). Pertahankan route lain.

$routes->get('/', 'HomeController::index');

// Hanya untuk tamu (belum login)
$routes->group('', ['filter' => 'guest'], static function ($routes) {
    $routes->get('register', 'AuthController::registerForm');
    $routes->post('register', 'AuthController::register');
    $routes->get('login', 'AuthController::loginForm');
    $routes->post('login', 'AuthController::login');
});

// Logout: POST + CSRF, harus sedang login
$routes->post('logout', 'AuthController::logout', ['filter' => 'auth']);

// Area terlindungi berdasarkan role
$routes->group('admin', ['filter' => 'auth:admin', 'namespace' => 'App\Controllers\Admin'], static function ($routes) {
    $routes->get('/', 'DashboardController::index');
});

$routes->group('operator', ['filter' => 'auth:operator', 'namespace' => 'App\Controllers\Operator'], static function ($routes) {
    $routes->get('/', 'DashboardController::index');
});
