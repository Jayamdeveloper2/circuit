<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthSession implements FilterInterface {

    public function before(RequestInterface $request, $arguments = null) {
//        $path = $request->getPath();         
//        if (!session()->get('user_login_id')) {
//            // Redirect to login if session is missing          
//            return redirect()->to(base_url('/'));
//        }
//         
//
//        if (!in_array($path, USER_ACCESS[session()->get('m_user_type_id')]??[])) {
//            return redirect()->to(base_url('accessdenied'));
//        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
        // Do nothing
    }
}
