<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('api', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->resource('students', ['controller' => 'StudentController']);
    $routes->get('weather', 'ApiTest::weather');
    $routes->get('weather/(:any)', 'ApiTest::weather/$1');
    $routes->get('qrcode', 'ApiTest::qrcode');
    $routes->get('qrcode/(:any)', 'ApiTest::qrcode/$1');
    $routes->get('iplookup', 'ApiTest::iplookup');
    $routes->get('iplookup/(:any)', 'ApiTest::iplookup/$1');
    $routes->get('quotes', 'ApiTest::quotes');
});

