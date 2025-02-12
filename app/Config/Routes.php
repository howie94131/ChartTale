<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Home::index');

//Home
$routes->get('/', 'ChartController::index');

//Admin Page
$routes->group('admin', ['filter' => 'admin'], function($routes) {
    $routes->get('/', 'ChartController::admin');
    $routes->match(['GET', 'POST'], 'addedit', 'ChartController::addedit');
    $routes->match(['GET', 'POST'], 'addedit/(:num)', 'ChartController::addedit/$1');
    $routes->get('delete/(:num)', 'ChartController::delete/$1');
});

//Google Social login
$routes->get('/login', 'Auth::google_login');  // Route to initiate Google login
$routes->get('/login/callback', 'Auth::google_callback');  // Callback route after Google auth
$routes->get('/logout', 'Auth::logout');

//Upload page
$routes->get('/upload', 'FileUploadController::index', ['filter' => 'login']);
$routes->post('/upload', 'FileUploadController::upload');
$routes->get('upload/view/(:num)', 'FileUploadController::view/$1');
$routes->get('upload/delete/(:num)', 'FileUploadController::delete/$1');

//Chart Generation
$routes->get('upload/chart/(:num)', 'FileUploadController::chart/$1', ['filter' => 'login']);
$routes->post('upload/generate_chart', 'FileUploadController::generateChart', ['filter' => 'login']);

//Chart Page
$routes->get('user/charts', 'FileUploadController::userCharts', ['filter' => 'login']);
$routes->get('user/charts/delete/(:num)', 'FileUploadController::deleteChart/$1', ['filter' => 'login']);
$routes->get('user/charts/view/(:num)', 'FileUploadController::viewChart/$1', ['filter' => 'login']);
$routes->get('user/charts/edit_story/(:num)', 'FileUploadController::editStory/$1', ['filter' => 'login']);
$routes->post('user/charts/save_story', 'FileUploadController::saveStory', ['filter' => 'login']);


//Authorization pop-up page
$routes->get('/denied', 'ChartController::denied'); 
$routes->get('/loginpls', 'ChartController::loginpls'); 
