<?php

namespace App\Controllers\Admin;


use App\Controllers\BaseController;

class Auth extends BaseController {

    public function __construct() {
        $this->db = \Config\Database::connect();
        helper("util");
    }

    public function index() {

       
        return view('admin/login');
    }

    public function loginCheck() {
        //get User Request
        $params = $this->request->getPost();

        //check Mandatory Field
        $vaild = checkMandatory(['user_email', 'user_password'], $params);
        
        if ($vaild) {
            return $this->respond([], $vaild, 404);
        }

        //check User id 
        $user_data = $this->db->table('user_login ul')
                        ->join('m_user_type mut', 'mut.m_user_type_id = ul.m_user_type_id', 'inner')
                        ->where('ul.is_deleted', 0)
                        ->where('ul.user_email', trim($params['user_email']))
                        ->get()->getRowArray();

        if (!$user_data) {
            return $this->respond([], 'Wrong User Email', 404);
        }

        if ($user_data['user_password'] !== md5($params['user_password'])) {
            return $this->respond([], 'Wrong Password', 404);
        }
        $pass_hash = $user_data['user_password'];
        unset($user_data['user_password']);
        $user_data['user_password_hash'] = $pass_hash;
        session()->set($user_data);

        $user_data['redirect'] = base_url(ADMIN_NAME.'/menu-manage');
        return $this->respond($user_data, 'Successfully Login');
    }
    
     public function changeUserPassword() {
        $param = $this->request->getPost();
        $user_id = session()->get('user_login_id');
        if (!$user_id) {
            return $this->respond([], 'Something Error', 404);
        }

        $user_data = $this->db->table('user_login')
                        ->where('is_deleted', 0)
                        ->where('user_login_id', $user_id)
                        ->get()->getRowArray();
        if (!$user_data) {
            return $this->respond([], 'Something Error', 404);
        }

        if ($user_data['user_password'] != md5($param["user_old_pass"])) {
            return $this->respond([], 'Wrong Old Password', 404);
        }

        if (!$this->db->table('user_login')->where('user_login_id', $user_id)->update(['user_password' => md5($param["user_new_pass"])])) {
            return $this->respond([], 'Something Error', 404);
        }

        session()->remove('user_login_id');
        session()->destroy();

        return $this->respond([], 'successfully Changed password');
    }
    
     public function changeUserEmail() {
        $param = $this->request->getPost();
        $user_id = session()->get('user_login_id');
        if (!$user_id) {
            return $this->respond([], 'Something Error', 404);
        }

        $user_data = $this->db->table('user_login')
                        ->where('is_deleted', 0)
                        ->where('user_login_id', $user_id)
                        ->get()->getRowArray();
        if (!$user_data) {
            return $this->respond([], 'Something Error', 404);
        }

        if (empty($param["user_new_email"])) {
            return $this->respond([], 'Email cannot be empty', 404);
        }

        $existing = $this->db->table('user_login')
                             ->where('is_deleted', 0)
                             ->where('user_email', $param["user_new_email"])
                             ->where('user_login_id !=', $user_id)
                             ->get()->getRowArray();
        if ($existing) {
             return $this->respond([], 'Email is already taken', 404);
        }

        if (!$this->db->table('user_login')->where('user_login_id', $user_id)->update(['user_email' => $param["user_new_email"]])) {
            return $this->respond([], 'Something Error', 404);
        }
        
        session()->set('user_email', $param["user_new_email"]);

        return $this->respond([], 'successfully Changed Email');
    }
    
     public function logout() {
        session()->remove('user_login_id');
        session()->destroy();
        return redirect()->to(base_url(ADMIN_NAME));
    }
    
}
