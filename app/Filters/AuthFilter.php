<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\JWT;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        helper('jwt');
        $jwt = $request->getHeaderLine('Authorization');
        $token = str_replace('Bearer ', '', $jwt);

        // Validate the JWT
        $config = new JWT();
        $decodedData = validate_jwt($token, $config->jwtSecret);

        if (!$decodedData) {
            return \Config\Services::response()->setStatusCode(401)->setJSON([
                'message' => 'Unauthorized or Invalid Token',
            ]);
        }
        // $request->setVar('decodedData', $decodedData);
        $request->user_data_app = $decodedData;


    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No post-processing needed
    }
}