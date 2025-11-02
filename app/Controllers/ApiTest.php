<?php
namespace App\Controllers;  // ✅ required for CI4

use CodeIgniter\Controller;

class ApiTest extends Controller {

    private $api_key = 'N0dpxSF7n9ZzQWlKR7PTMw==89CmXknSEHwbmZrQ'; // 🔒 Replace with your real API Ninjas key

    // public function __construct() {
    //     parent::__construct();
    // }

    public function qrcode($student_id = 'SIS2025-001') {
        $api_url = "https://api.api-ninjas.com/v1/qrcode?data=" . urlencode($student_id);
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Api-Key: ' . $this->api_key));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($status_code == 200 && $response) {
            header('Content-Type: image/png');
            echo $response;
        } else {
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to generate QR Code.',
                'http_code' => $status_code
            ]);
        }
    }

    public function weather() {
        $api_url = "https://api.open-meteo.com/v1/forecast?latitude=52.52&longitude=13.41&hourly=temperature_2m";

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $api_url,
            CURLOPT_HTTPHEADER => [
                // 'X-Api-Key: ' . $this->api_key,
                'Accept: application/json'
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10
        ]);

        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        header('Content-Type: application/json');

        if ($status_code == 200 && $response) {
            echo $response;
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to fetch weather data.',
                'http_code' => $status_code,
                'curl_error' => $error ?: 'None',
                'endpoint_used' => $api_url
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
