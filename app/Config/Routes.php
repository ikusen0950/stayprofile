
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

// Test permissions route
$routes->get('test-permissions/authorization-rules', 'TestPermissions::authorizationRules');

// Agreement acceptance route
$routes->post('accept-agreement', 'Dashboard::acceptAgreement', ['filter' => 'login']);

// Testing route to reset current user's agreement
$routes->get('reset-my-agreement', 'Dashboard::resetMyAgreement', ['filter' => 'login']);

// Check permissions route (for debugging)
$routes->get('check-permissions/visitors', 'CheckPermissions::visitors');

// API routes for cascading dropdowns (authenticated AJAX calls)
$routes->group('api', function($routes) {
    $routes->get('test', 'Api::test');
    $routes->get('departments-by-division', 'Api::departmentsByDivision');
    $routes->get('sections-by-department', 'Api::sectionsByDepartment');
    $routes->get('positions-by-status', 'Api::positionsByStatus');
    $routes->post('check-islander-number', 'VisitorsController::checkIslanderNumber');
    
    // Device token management for push notifications
    $routes->post('device/register-token', 'Api\DeviceController::registerToken', ['filter' => 'login']);
    $routes->post('device/remove-token', 'Api\DeviceController::removeToken', ['filter' => 'login']);
    $routes->get('device/token-status', 'Api\DeviceController::tokenStatus', ['filter' => 'login']);
});

// Test route first
$routes->get('api/test', 'TestController::test');

// Working FCM routes from other CI4 app (outside api group to avoid double /api)
$routes->get('api/save-token', 'Notification::saveToken');
$routes->post('api/save-token', 'Notification::saveToken');
$routes->get('api/test-push', 'Notification::testPush');
$routes->get('api/test-push-simple', 'Notification::testPushSimple'); // Test without auth

// Button preview route
$routes->get('button-preview', function() {
    return view('button-preview');
});

// Debug routes (development only)
$routes->get('debug/test-token-save', 'Debug::testTokenSave');
$routes->get('debug/check-user', 'Debug::checkCurrentUser');
$routes->post('notifications/markAsRead', 'Notification::markAsRead');
$routes->get('notification/read/(:num)', 'Notification::markAsReadAndRedirect/$1');

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

// Notifications CRUD routes
$routes->group('notifications', ['filter' => 'login'], function($routes) {
    $routes->get('/', 'NotificationsController::index');
    $routes->get('create', 'NotificationsController::create');
    $routes->post('store', 'NotificationsController::store');
    $routes->get('show/(:num)', 'NotificationsController::show/$1');
    $routes->get('(:num)', 'NotificationsController::show/$1');
    $routes->get('(:num)/edit', 'NotificationsController::edit/$1');
    $routes->post('(:num)/update', 'NotificationsController::update/$1');
    $routes->post('update/(:num)', 'NotificationsController::update/$1');
    $routes->post('(:num)/delete', 'NotificationsController::delete/$1');
    $routes->post('delete/(:num)', 'NotificationsController::delete/$1');
    
    // Bulk notification routes
    $routes->get('recipient-stats', 'NotificationsController::recipientStats');
    $routes->post('send-bulk', 'NotificationsController::sendBulk');
});

// Authorization Rules CRUD routes
$routes->group('authorization-rules', ['filter' => 'login'], function($routes) {
    $routes->get('/', 'AuthorizationRulesController::index');
    $routes->get('create', 'AuthorizationRulesController::create');
    $routes->post('store', 'AuthorizationRulesController::store');
    $routes->post('store-multiple', 'AuthorizationRulesController::storeMultiple');
    $routes->get('show/(:num)', 'AuthorizationRulesController::show/$1');
    $routes->get('(:num)', 'AuthorizationRulesController::show/$1');
    $routes->get('(:num)/edit', 'AuthorizationRulesController::edit/$1');
    $routes->post('(:num)/update', 'AuthorizationRulesController::update/$1');
    $routes->post('update/(:num)', 'AuthorizationRulesController::update/$1');
    $routes->post('(:num)/delete', 'AuthorizationRulesController::delete/$1');
    $routes->post('delete/(:num)', 'AuthorizationRulesController::delete/$1');
    $routes->get('api', 'AuthorizationRulesController::api');
    $routes->get('departments-by-division/(:num)', 'AuthorizationRulesController::getDepartmentsByDivision/$1');
    $routes->get('sections-by-department/(:num)', 'AuthorizationRulesController::getSectionsByDepartment/$1');
});

// Requesting Rules CRUD routes  
$routes->group('requesting-rules', ['filter' => 'login'], function($routes) {
    $routes->get('/', 'RequestingRulesController::index');
    $routes->get('create', 'RequestingRulesController::create');
    $routes->post('store', 'RequestingRulesController::store');
    $routes->post('store-multiple', 'RequestingRulesController::storeMultiple');
    $routes->get('show/(:num)', 'RequestingRulesController::show/$1');
    $routes->get('(:num)', 'RequestingRulesController::show/$1');
    $routes->get('(:num)/edit', 'RequestingRulesController::edit/$1');
    $routes->post('(:num)/update', 'RequestingRulesController::update/$1');
    $routes->post('update/(:num)', 'RequestingRulesController::update/$1');
    $routes->post('(:num)/delete', 'RequestingRulesController::delete/$1');
    $routes->post('delete/(:num)', 'RequestingRulesController::delete/$1');
    $routes->get('api', 'RequestingRulesController::api');
    $routes->get('departments-by-division/(:num)', 'RequestingRulesController::getDepartmentsByDivision/$1');
    $routes->get('sections-by-department/(:num)', 'RequestingRulesController::getSectionsByDepartment/$1');
});

// Requests CRUD routes
$routes->group('requests', ['filter' => 'login'], function($routes) {
    $routes->get('/', 'RequestController::index');
    $routes->get('add_request', 'RequestController::add');
    $routes->get('create', 'RequestController::create');
    $routes->post('store', 'RequestController::store');
    $routes->get('show/(:num)', 'RequestController::show/$1');
    $routes->get('(:num)', 'RequestController::show/$1');
    $routes->get('(:num)/edit', 'RequestController::edit/$1');
    $routes->post('(:num)/update', 'RequestController::update/$1');
    $routes->post('update/(:num)', 'RequestController::update/$1');
    $routes->post('(:num)/delete', 'RequestController::delete/$1');
    $routes->post('delete/(:num)', 'RequestController::delete/$1');
    $routes->get('api', 'RequestController::api');
    $routes->get('statuses', 'RequestController::getStatuses');
    $routes->get('users', 'RequestController::getUsers');
});

// Sessions CRUD routes
$routes->group('sessions', ['filter' => 'login'], function($routes) {
    $routes->get('/', 'SessionsController::index');
    $routes->post('cleanup-expired', 'SessionsController::cleanupExpired');
    $routes->get('api', 'SessionsController::api');
    $routes->get('show/(.+)', 'SessionsController::show/$1');
    $routes->post('(.+)/force-logout', 'SessionsController::forceLogout/$1');
    $routes->get('(.+)', 'SessionsController::show/$1');
});

// Roles CRUD routes
$routes->group('roles', ['filter' => 'login'], function($routes) {
    $routes->get('/', 'RoleController::index');
    $routes->post('/', 'RoleController::store');
    $routes->get('create', 'RoleController::create');
    $routes->post('store', 'RoleController::store');
    $routes->get('show/(:num)', 'RoleController::show/$1');
    $routes->get('(:num)', 'RoleController::show/$1');
    $routes->get('(:num)/edit', 'RoleController::edit/$1');
    $routes->post('(:num)/update', 'RoleController::update/$1');
    $routes->post('update/(:num)', 'RoleController::update/$1');
    $routes->post('(:num)/delete', 'RoleController::delete/$1');
    $routes->post('delete/(:num)', 'RoleController::delete/$1');
    $routes->get('api', 'RoleController::api');
});

// Group Permissions CRUD routes
$routes->group('group-permissions', ['filter' => 'login'], function($routes) {
    $routes->get('/', 'GroupPermissionController::index');
    $routes->post('update', 'GroupPermissionController::update');
    $routes->get('api', 'GroupPermissionController::api');
});

// User Permissions CRUD routes
$routes->group('user-permissions', ['filter' => 'login'], function($routes) {
    $routes->get('/', 'UserPermissionController::index');
    $routes->post('update', 'UserPermissionController::update');
    $routes->get('api', 'UserPermissionController::api');
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

// Divisions CRUD routes
$routes->group('divisions', ['filter' => 'login'], function($routes) {
    $routes->get('/', 'DivisionsController::index');
    $routes->get('create', 'DivisionsController::create');
    $routes->post('store', 'DivisionsController::store');
    $routes->get('show/(:num)', 'DivisionsController::show/$1');
    $routes->get('(:num)', 'DivisionsController::show/$1');
    $routes->get('(:num)/edit', 'DivisionsController::edit/$1');
    $routes->post('(:num)/update', 'DivisionsController::update/$1');
    $routes->post('update/(:num)', 'DivisionsController::update/$1');
    $routes->post('(:num)/delete', 'DivisionsController::delete/$1');
    $routes->post('delete/(:num)', 'DivisionsController::delete/$1');
    $routes->get('api', 'DivisionsController::api');
    $routes->get('divisions', 'DivisionsController::getDivisions');
    $routes->get('statuses', 'DivisionsController::getStatuses');
});

// Houses CRUD routes
$routes->group('houses', ['filter' => 'login'], function($routes) {
    $routes->get('/', 'HousesController::index');
    $routes->get('create', 'HousesController::create');
    $routes->post('store', 'HousesController::store');
    $routes->get('show/(:num)', 'HousesController::show/$1');
    $routes->get('(:num)', 'HousesController::show/$1');
    $routes->get('(:num)/edit', 'HousesController::edit/$1');
    $routes->post('(:num)/update', 'HousesController::update/$1');
    $routes->post('update/(:num)', 'HousesController::update/$1');
    $routes->post('(:num)/delete', 'HousesController::delete/$1');
    $routes->post('delete/(:num)', 'HousesController::delete/$1');
    $routes->get('api', 'HousesController::api');
    $routes->get('getHouses', 'HousesController::getHouses');
    $routes->get('statuses', 'HousesController::getStatuses');
});

// Genders CRUD routes
$routes->group('genders', ['filter' => 'login'], function($routes) {
    $routes->get('/', 'GendersController::index');
    $routes->get('create', 'GendersController::create');
    $routes->post('store', 'GendersController::store');
    $routes->get('show/(:num)', 'GendersController::show/$1');
    $routes->get('(:num)', 'GendersController::show/$1');
    $routes->get('(:num)/edit', 'GendersController::edit/$1');
    $routes->post('(:num)/update', 'GendersController::update/$1');
    $routes->post('update/(:num)', 'GendersController::update/$1');
    $routes->post('(:num)/delete', 'GendersController::delete/$1');
    $routes->post('delete/(:num)', 'GendersController::delete/$1');
    $routes->get('api', 'GendersController::api');
    $routes->get('genders', 'GendersController::getGenders');
    $routes->get('statuses', 'GendersController::getStatuses');
});

// Nationalities CRUD routes
$routes->group('nationalities', ['filter' => 'login'], function($routes) {
    $routes->get('/', 'NationalitiesController::index');
    $routes->get('create', 'NationalitiesController::create');
    $routes->post('store', 'NationalitiesController::store');
    $routes->get('show/(:num)', 'NationalitiesController::show/$1');
    $routes->get('(:num)', 'NationalitiesController::show/$1');
    $routes->get('(:num)/edit', 'NationalitiesController::edit/$1');
    $routes->post('(:num)/update', 'NationalitiesController::update/$1');
    $routes->post('update/(:num)', 'NationalitiesController::update/$1');
    $routes->post('(:num)/delete', 'NationalitiesController::delete/$1');
    $routes->post('delete/(:num)', 'NationalitiesController::delete/$1');
    $routes->get('api', 'NationalitiesController::api');
    $routes->get('nationalities', 'NationalitiesController::getNationalities');
    $routes->get('statuses', 'NationalitiesController::getStatuses');
});

// Departments CRUD routes
$routes->group('departments', ['filter' => 'login'], function($routes) {
    $routes->get('/', 'DepartmentsController::index');
    $routes->get('create', 'DepartmentsController::create');
    $routes->post('store', 'DepartmentsController::store');
    $routes->get('show/(:num)', 'DepartmentsController::show/$1');
    $routes->get('(:num)', 'DepartmentsController::show/$1');
    $routes->get('(:num)/edit', 'DepartmentsController::edit/$1');
    $routes->post('(:num)/update', 'DepartmentsController::update/$1');
    $routes->post('update/(:num)', 'DepartmentsController::update/$1');
    $routes->post('(:num)/delete', 'DepartmentsController::delete/$1');
    $routes->post('delete/(:num)', 'DepartmentsController::delete/$1');
    $routes->get('api', 'DepartmentsController::api');
    $routes->get('divisions', 'DepartmentsController::getDivisions');
    $routes->get('statuses', 'DepartmentsController::getStatuses');
});

// Sections CRUD routes
$routes->group('sections', ['filter' => 'login'], function($routes) {
    $routes->get('/', 'SectionsController::index');
    $routes->get('create', 'SectionsController::create');
    $routes->post('store', 'SectionsController::store');
    $routes->get('show/(:num)', 'SectionsController::show/$1');
    $routes->get('(:num)', 'SectionsController::show/$1');
    $routes->get('(:num)/edit', 'SectionsController::edit/$1');
    $routes->post('(:num)/update', 'SectionsController::update/$1');
    $routes->post('update/(:num)', 'SectionsController::update/$1');
    $routes->post('(:num)/delete', 'SectionsController::delete/$1');
    $routes->post('delete/(:num)', 'SectionsController::delete/$1');
    $routes->get('api', 'SectionsController::api');
    $routes->get('departments', 'SectionsController::getDepartments');
    $routes->get('statuses', 'SectionsController::getStatuses');
});

// Positions CRUD routes
$routes->group('positions', ['filter' => 'login'], function($routes) {
    $routes->get('/', 'PositionsController::index');
    $routes->get('create', 'PositionsController::create');
    $routes->post('store', 'PositionsController::store');
    $routes->get('show/(:num)', 'PositionsController::show/$1');
    $routes->get('(:num)', 'PositionsController::show/$1');
    $routes->get('(:num)/edit', 'PositionsController::edit/$1');
    $routes->post('(:num)/update', 'PositionsController::update/$1');
    $routes->post('update/(:num)', 'PositionsController::update/$1');
    $routes->post('(:num)/delete', 'PositionsController::delete/$1');
    $routes->post('delete/(:num)', 'PositionsController::delete/$1');
    $routes->get('api', 'PositionsController::api');
    $routes->get('sections', 'PositionsController::getSections');
    $routes->get('statuses', 'PositionsController::getStatuses');
});

// Islanders CRUD routes
$routes->group('islanders', ['filter' => 'login'], function($routes) {
    $routes->get('/', 'IslandersController::index');
    $routes->post('/', 'IslandersController::store');
    $routes->get('create', 'IslandersController::create');
    $routes->post('store', 'IslandersController::store');
    $routes->get('show/(:num)', 'IslandersController::show/$1');
    $routes->get('(:num)', 'IslandersController::show/$1');
    $routes->get('(:num)/edit', 'IslandersController::edit/$1');
    $routes->put('(:num)', 'IslandersController::update/$1');
    $routes->post('(:num)/update', 'IslandersController::update/$1');
    $routes->post('update/(:num)', 'IslandersController::update/$1');
    $routes->delete('(:num)', 'IslandersController::delete/$1');
    $routes->post('(:num)/delete', 'IslandersController::delete/$1');
    $routes->post('delete/(:num)', 'IslandersController::delete/$1');
    $routes->post('(:num)/reset-password', 'IslandersController::resetPassword/$1');
    $routes->get('api', 'IslandersController::api');
    $routes->get('divisions', 'IslandersController::getDivisions');
    $routes->get('departments', 'IslandersController::getDepartments');
    $routes->get('sections', 'IslandersController::getSections');
    $routes->get('positions', 'IslandersController::getPositions');
    $routes->get('genders', 'IslandersController::getGenders');
    $routes->get('houses', 'IslandersController::getHouses');
    $routes->get('nationalities', 'IslandersController::getNationalities');
    $routes->get('statuses', 'IslandersController::getStatuses');
    // Cascading dropdown routes
    $routes->get('departments-by-division', 'IslandersController::getDepartmentsByDivision');
    $routes->get('sections-by-department', 'IslandersController::getSectionsByDepartment');
    $routes->get('positions-by-section', 'IslandersController::getPositionsBySection');
});

// Visitors CRUD routes
$routes->group('visitors', ['filter' => 'login'], function($routes) {
    $routes->get('/', 'VisitorsController::index');
    $routes->post('/', 'VisitorsController::store');
    $routes->get('create', 'VisitorsController::create');
    $routes->post('store', 'VisitorsController::store');
    $routes->get('show/(:num)', 'VisitorsController::show/$1');
    $routes->get('(:num)', 'VisitorsController::show/$1');
    $routes->get('(:num)/edit', 'VisitorsController::edit/$1');
    $routes->put('(:num)', 'VisitorsController::update/$1');
    $routes->post('(:num)/update', 'VisitorsController::update/$1');
    $routes->post('update/(:num)', 'VisitorsController::update/$1');
    $routes->delete('(:num)', 'VisitorsController::delete/$1');
    $routes->post('(:num)/delete', 'VisitorsController::delete/$1');
    $routes->post('delete/(:num)', 'VisitorsController::delete/$1');
    $routes->post('(:num)/enrol-as-islander', 'VisitorsController::enrolAsIslander/$1');
    $routes->get('api', 'VisitorsController::api');
    $routes->get('genders', 'VisitorsController::getGenders');
    $routes->get('nationalities', 'VisitorsController::getNationalities');
    $routes->get('statuses', 'VisitorsController::getStatuses');
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

// Leave CRUD routes
$routes->group('leave', ['filter' => 'login'], function($routes) {
    $routes->get('/', 'LeaveController::index');
        $routes->get('show/(:num)', 'LeaveController::show/$1');
    $routes->get('create', 'LeaveController::create');
    $routes->post('store', 'LeaveController::store');
    $routes->get('edit/(:num)', 'LeaveController::edit/$1');
    $routes->post('update/(:num)', 'LeaveController::update/$1');
    $routes->get('delete/(:num)', 'LeaveController::delete/$1');
    $routes->get('view/(:num)', 'LeaveController::view/$1');
});
