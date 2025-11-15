<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Global CORS preflight handler
$routes->options('(:any)', 'Home::options');

$routes->group('api', ['namespace' => 'App\Controllers'], function($routes) {

    /*
    |--------------------------------------------------
    |  API TEST ROUTES
    |--------------------------------------------------
    */
    $routes->get('weather', 'ApiTest::weather');
    $routes->get('weather/(:any)', 'ApiTest::weather/$1');

    // QR Code routes
    $routes->get('qrcode', 'ApiTest::qrcode');
    $routes->post('qrcode', 'ApiTest::qrcode');
    $routes->options('qrcode', 'Home::options');
    $routes->get('qrcode/(:any)', 'ApiTest::qrcode/$1');

    $routes->get('iplookup', 'ApiTest::iplookup');
    $routes->get('iplookup/(:any)', 'ApiTest::iplookup/$1');
    $routes->get('quotes', 'ApiTest::quotes');
    $routes->get('gpa/(:num)', 'GradeController::studentGPA/$1');
    $routes->get('cors-test', 'Home::corsTest');

    /*
    |--------------------------------------------------
    |  TEACHER MODULE (CUSTOM ENDPOINTS)
    |--------------------------------------------------
    */
    $routes->get('teacher/classes/(:num)', 'TeacherController::getTeacherClasses/$1');
    $routes->get('class/students/(:num)', 'ClassController::getClassStudents/$1');
    $routes->post('teacher/attendance', 'AttendanceController::submitAttendance');
    $routes->post('teacher/grades', 'GradeController::submitGrades');

    /*
    |--------------------------------------------------
    |  REST RESOURCE ROUTES
    |--------------------------------------------------
    */
    $routes->resource('students', ['controller' => 'StudentController']);
    $routes->resource('courses', ['controller' => 'CourseController']);
    $routes->resource('departments', ['controller' => 'DepartmentController']);
    $routes->resource('attendance', ['controller' => 'AttendanceController']);
    $routes->resource('sections', ['controller' => 'SectionController']);
    $routes->resource('grades', ['controller' => 'GradeController']);
    $routes->resource('payments', ['controller' => 'PaymentController']);
    $routes->resource('balances', ['controller' => 'StudentBalanceController']);

    // Custom Balance lookup
    $routes->get('balances/student/(:num)', 'StudentBalanceController::getByStudent/$1');
});
