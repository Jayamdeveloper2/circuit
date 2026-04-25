<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller {

    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        $session = \Config\Services::session();
        $user_login_id = $session->get('user_login_id');

        // Global validation: Log the user out if their password has changed
        if ($user_login_id) {
            $db = \Config\Database::connect();
            $user_data = $db->table('user_login')->select('user_password')->where('user_login_id', $user_login_id)->get()->getRowArray();
            
            if ($user_data && $session->get('user_password_hash') && $session->get('user_password_hash') !== $user_data['user_password']) {
                $session->remove('user_login_id');
                $session->destroy();
            }
        }
    }

    /**
     * Sends a standardized response.
     *
     * @param mixed $data
     * @param string $message
     * @param int $statusCode
     * @param string $status
     * @return \CodeIgniter\HTTP\Response
     */
    protected function respond($data = null, string $message = '', int $statusCode = 200, string $status = 'success', $last_count = -1) {
        // Prepare response data
        $response = [
            'csrf_token' => csrf_token(),
            'csrf_hash' => csrf_hash(),
            'status' => $status, // 'success' or 'error'
            'message' => $message, // A custom message
            'data' => $data, // Actual data payload
            'code' => $statusCode, // HTTP status code
        ];
        if ($last_count !== -1) {
            $response['last_count'] = $last_count;
        }

        // Return the response in JSON format
        return $this->response
                        ->setStatusCode(200)
                        ->setContentType('application/json')
                        ->setJSON($response);
    }
}
