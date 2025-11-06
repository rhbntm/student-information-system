<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Handle preflight CORS requests for all API routes
$routes->options('(:any)', 'Home::options');

$routes->group('api', ['namespace' => 'App\Controllers'], function($routes) {
    // api test routes
    $routes->get('weather', 'ApiTest::weather');
    $routes->get('weather/(:any)', 'ApiTest::weather/$1');
    $routes->get('qrcode', 'ApiTest::qrcode');
    $routes->get('qrcode/(:any)', 'ApiTest::qrcode/$1');
    $routes->get('iplookup', 'ApiTest::iplookup');
    $routes->get('iplookup/(:any)', 'ApiTest::iplookup/$1');
    $routes->get('quotes', 'ApiTest::quotes');

    // cors test route
    $routes->get('cors-test', 'Home::corsTest');

    // resource routes
    $routes->resource('students', ['controller' => 'StudentController']);
    $routes->resource('courses', ['controller' => 'CourseController']);
    $routes->resource('departments', ['controller' => 'DepartmentController']);
    $routes->resource('attendance', ['controller' => 'AttendanceController']);
    $routes->resource('sections', ['controller' => 'SectionController']);

});

