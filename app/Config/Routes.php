<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Students resource controller
$routes->resource('students', ['controller' => 'StudentController']);

// API Test routes
$routes->get('api/weather', 'ApiTest::weather');
$routes->get('api/weather/(:any)', 'ApiTest::weather/$1');

$routes->get('api/qrcode', 'ApiTest::qrcode');
$routes->get('api/qrcode/(:any)', 'ApiTest::qrcode/$1');

$routes->get('api/iplookup', 'ApiTest::iplookup');
$routes->get('api/iplookup/(:any)', 'ApiTest::iplookup/$1');

$routes->get('api/quotes', 'ApiTest::quotes');
