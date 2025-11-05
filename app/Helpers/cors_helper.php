<?php

if (!function_exists('set_cors_headers')) {
    function set_cors_headers() {
        $allowedOrigins = [
            'http://localhost:5173',
            'http://127.0.0.1:5173',
        ];

        $origin = $_SERVER['HTTP_ORIGIN'] ?? '';

        if (in_array($origin, $allowedOrigins)) {
            header("Access-Control-Allow-Origin: $origin");
        }

        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
        header("Access-Control-Allow-Credentials: true");
    }
}

if (!function_exists('get_cors_info')) {
    function get_cors_info() {
        return [
            'detected_origin' => $_SERVER['HTTP_ORIGIN'] ?? 'none',
            'allowed_origins' => [
                'http://localhost:5173',
                'http://127.0.0.1:5173'
            ],
            'allowed_methods' => 'GET, POST, PUT, DELETE, OPTIONS',
            'request_method' => $_SERVER['REQUEST_METHOD'] ?? 'unknown',
            'timestamp' => date(DATE_ISO8601),
        ];
    }
}
