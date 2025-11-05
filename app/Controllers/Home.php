<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }

    // Handles preflight (OPTIONS) requests globally
    public function options()
    {
        helper('cors');
        set_cors_headers();
        http_response_code(200);
        exit;
    }

    public function corsTest()
    {
        helper('cors');
        set_cors_headers();

        $info = get_cors_info();

        return $this->response->setJSON([
            'status' => 'ok',
            'message' => 'CORS headers applied successfully!',
            ...$info // PHP 7.4+ spread operator for merging arrays
        ]);
    }


}
