<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

helper('cors'); // import our helper globally

class Cors implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        set_cors_headers();

        // Handle preflight requests immediately
        if ($request->getMethod() === 'options') {
            http_response_code(200);
            exit;
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        set_cors_headers(); // ensure all responses have correct headers
        return $response;
    }
}
