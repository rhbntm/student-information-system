<?php
namespace App\Controllers;  

use CodeIgniter\Controller;

class ApiTest extends Controller {

    private $api_key = 'N0dpxSF7n9ZzQWlKR7PTMw==89CmXknSEHwbmZrQ'; 


    // ApiNinjas broken image output
// public function qrcode($student_id = 'SIS2025-001')
// {
//     $api_url = "https://api.api-ninjas.com/v1/qrcode?data=" . rawurlencode($student_id);

//     $ch = curl_init($api_url);
//     curl_setopt($ch, CURLOPT_HTTPHEADER, ['X-Api-Key: ' . $this->api_key]);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     $response = curl_exec($ch);
//     $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//     curl_close($ch);


//     return $this->response->setJSON([
//         'status_code' => $status_code,
//         'length'      => strlen($response),
//         'snippet'     => substr($response, 0, 200)
//     ]);
// }

    // alternative to ApiNinjas
    public function qrcode($data = null)
    {
        // Allowed frontend origins
        $allowedOrigins = [
            'http://localhost:5173',
            'http://127.0.0.1:5173',
        ];

        // Handle OPTIONS preflight
        if ($this->request->getMethod() === 'options') {
            $origin = $_SERVER['HTTP_ORIGIN'] ?? '';
            if (in_array($origin, $allowedOrigins)) {
                return $this->response
                    ->setHeader('Access-Control-Allow-Origin', $origin)
                    ->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
                    ->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With')
                    ->setHeader('Access-Control-Allow-Credentials', 'true')
                    ->setStatusCode(200);
            }
        }

        // Read input text (supports POST and GET)
        $text = $this->request->getPost('data') ?? $data ?? 'SIS2025-001';

        // QR Server API
        $url = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . rawurlencode($text);

        $response = @file_get_contents($url);

        if ($response === false) {
            return $this->response
                ->setStatusCode(500)
                ->setJSON([
                    'error' => 'Failed to fetch QR from QRServer API.',
                    'input' => $text
                ]);
        }

        // Apply correct CORS
        $origin = $_SERVER['HTTP_ORIGIN'] ?? '';
        if (in_array($origin, $allowedOrigins)) {
            $this->response->setHeader('Access-Control-Allow-Origin', $origin);
        }

        return $this->response
            ->setHeader('Access-Control-Allow-Credentials', 'true')
            ->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
            ->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With')
            ->setHeader('Content-Type', 'image/png')
            ->setBody($response);
    }







    public function weather($city = 'Manila') {
        // available cities
        $city_coords = [
            'Manila' => ['lat' => 14.5995, 'lon' => 120.9842],
            'Cebu' => ['lat' => 10.3157, 'lon' => 123.8854],
            'Davao' => ['lat' => 7.1907, 'lon' => 125.4553],
            'Tokyo' => ['lat' => 35.6828, 'lon' => 139.759],
            'London' => ['lat' => 51.5072, 'lon' => -0.1276],
        ];

        if (!array_key_exists($city, $city_coords)) {
            return $this->response->setStatusCode(400)
                ->setJSON(['error' => 'City not supported. Try Manila, Cebu, Davao, Tokyo, or London.']);
        }

        $lat = $city_coords[$city]['lat'];
        $lon = $city_coords[$city]['lon'];

        $api_url = "https://api.open-meteo.com/v1/forecast?latitude={$lat}&longitude={$lon}&current_weather=true";

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $api_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10
        ]);

        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($status_code == 200 && $response) {
            return $this->response->setJSON(json_decode($response, true));
        } else {
            return $this->response->setStatusCode($status_code ?: 500)
                ->setJSON([
                    'status' => 'error',
                    'message' => 'Failed to fetch weather data.',
                    'curl_error' => $error ?: 'None',
                    'endpoint' => $api_url
                ]);
        }
    }



    public function iplookup($ip = '8.8.8.8') {
        $api_url = "https://api.api-ninjas.com/v1/iplookup?address=" . urlencode($ip);
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Api-Key: ' . $this->api_key));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        header('Content-Type: application/json');
        if ($status_code == 200 && $response) {
            echo $response;
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to fetch IP info.',
                'http_code' => $status_code
            ]);
        }
    }

    public function quotes() {
        $api_url = "https://api.api-ninjas.com/v1/quotes";
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Api-Key: ' . $this->api_key));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        header('Content-Type: application/json');
        if ($status_code == 200 && $response) {
            echo $response;
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to fetch quote.',
                'http_code' => $status_code
            ]);
        }
    }
}
