<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Dashboard::index', ['filter' => 'login']);

// Protected route example
$routes->get('dashboard', 'Dashboard::index', ['filter' => 'login']);

// Test session route
$routes->get('test-session', 'Dashboard::testSession');

// Agreement acceptance route
$routes->post('accept-agreement', 'Dashboard::acceptAgreement', ['filter' => 'login']);

// Testing route to reset current user's agreement
$routes->get('reset-my-agreement', 'Dashboard::resetMyAgreement', ['filter' => 'login']);

// Password change routes
$routes->get('change-password', 'Dashboard::changePassword', ['filter' => 'login']);
$routes->post('change-password', 'Dashboard::updatePassword', ['filter' => 'login']);
$routes->get('reset-password-flag', 'Dashboard::resetPasswordFlag', ['filter' => 'login']);

// Status CRUD routes
$routes->group('status', ['filter' => 'login'], function($routes) {
    $routes->get('/', 'StatusController::index');
    $routes->get('create', 'StatusController::create');
    $routes->post('store', 'StatusController::store');
    $routes->get('show/(:num)', 'StatusController::show/$1');
    $routes->get('(:num)', 'StatusController::show/$1');
    $routes->get('(:num)/edit', 'StatusController::edit/$1');
    $routes->post('(:num)/update', 'StatusController::update/$1');
    $routes->post('update/(:num)', 'StatusController::update/$1');
    $routes->post('(:num)/delete', 'StatusController::delete/$1');
    $routes->post('delete/(:num)', 'StatusController::delete/$1');
    $routes->get('module/(:num)', 'StatusController::getByModule/$1');
    $routes->get('api', 'StatusController::api');
    $routes->get('modules', 'StatusController::getModules');
});

// Modules CRUD routes
$routes->group('modules', ['filter' => 'login'], function($routes) {
    $routes->get('/', 'ModulesController::index');
    $routes->get('create', 'ModulesController::create');
    $routes->post('store', 'ModulesController::store');
    $routes->get('show/(:num)', 'ModulesController::show/$1');
    $routes->get('(:num)', 'ModulesController::show/$1');
    $routes->get('(:num)/edit', 'ModulesController::edit/$1');
    $routes->post('(:num)/update', 'ModulesController::update/$1');
    $routes->post('update/(:num)', 'ModulesController::update/$1');
    $routes->post('(:num)/delete', 'ModulesController::delete/$1');
    $routes->post('delete/(:num)', 'ModulesController::delete/$1');
    $routes->get('api', 'ModulesController::api');
    $routes->get('statuses', 'ModulesController::getStatuses');
});

// Log Management Routes
$routes->group('logs', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'LogController::index');
    $routes->get('show/(:num)', 'LogController::show/$1');
    $routes->post('store', 'LogController::store');
    $routes->post('delete/(:num)', 'LogController::delete/$1');
    $routes->post('clear', 'LogController::clear');
    $routes->get('export', 'LogController::export');
    $routes->get('stats', 'LogController::stats');
    $routes->get('api', 'LogController::api');
});

// Main Auth routes (clean URLs)
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::attemptLogin');
$routes->get('logout', 'AuthController::logout');
$routes->get('register', 'AuthController::register');
$routes->post('register', 'AuthController::attemptRegister');
$routes->get('forgot', 'AuthController::forgotPassword');
$routes->post('forgot', 'AuthController::attemptForgot');

// Additional auth routes (keeping /auth prefix for these)
$routes->group('auth', function($routes) {
    $routes->get('reset/(:any)', 'AuthController::resetPassword/$1');
    $routes->post('reset/(:any)', 'AuthController::attemptReset/$1');
    $routes->get('activate-account', 'AuthController::activateAccount');
    $routes->get('resend-activate-account', 'AuthController::resendActivateAccount');
});
