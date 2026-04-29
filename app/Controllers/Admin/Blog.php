<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Blog extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        helper('url');
        helper("util");
    }

    public function pageBlog()
    {
        if (!session()->get('user_login_id')) {
            return redirect()->to(base_url(ADMIN_NAME));
        }
        $page['title'] = "Blog";
        $page['breadcrumb'] = '<div class="own-breadcrumb">Blog <i style="font-size:14px" class="fas fa-chevron-right"></i> <span>Blog List</span></div>';
        
        // Fetch the global status for the blog page from web_content if needed
        // For now, following the pattern in the view (data-section="26")
        $page['blogdatamaster'] = $this->db->table('web_content')->where('web_content_id', 26)->get()->getRowArray();
        
        return view('admin/pages/blog', $page);
    }

    public function getBlog()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }

        $builder = $this->db->table('web_blog')
            ->select('web_blog_id, web_title, web_tag, web_desc, web_content, web_time, display_order, meta_title, meta_desc, meta_key, is_active, 
                concat("' . BLOG_IMG . '", web_image) as web_image')

            ->where('is_deleted', 0);

        if ($this->request->getPost('web_blog_id')) {
            $builder->where('web_blog_id', $this->request->getPost('web_blog_id'));
        }

        $data = $builder->orderBy('display_order', 'ASC')->get()->getResultArray();

        foreach ($data as $i => &$row) {
            $row['serial_no'] = $i + 1;
        }

        $data_count = $this->db->table('web_blog')->select('count(*) as data_count')->where('is_deleted', 0)->get()->getRowArray();

        return $this->respond($data, 'successfully', 200, 'success', ($data_count['data_count'] ?? 0));
    }

    public function saveBlog()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }

        $data = $this->request->getPost();
        $action = $data['for'] ?? '';
        $builder = $this->db->table('web_blog');

        switch ($action) {
            case 'delete':
                if (empty($data['web_blog_id'])) {
                    return $this->respond([], 'ID required', 400);
                }
                $builder->where('web_blog_id', $data['web_blog_id'])->update(['is_deleted' => 1]);
                return $this->respond([], 'successfully');

            case 'status':
                if (empty($data['web_blog_id']) || !isset($data['is_active'])) {
                    return $this->respond([], 'Invalid status', 400);
                }
                $builder->where('web_blog_id', $data['web_blog_id'])->update(['is_active' => $data['is_active']]);
                return $this->respond([], 'successfully');

            case 'edit':
                $id = $data['web_blog_id'];
                $isNew = ($id == -1);

                $allowedFields = [
                    'web_title', 'web_tag', 'web_desc', 'web_content', 
                    'web_time', 'display_order', 'meta_title', 
                    'meta_desc', 'meta_key'
                ];

                $saveData = array_intersect_key($data, array_flip($allowedFields));
                
                // Generate slug
                if (!empty($saveData['web_title'])) {
                    $saveData['web_slug'] = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $saveData['web_title']), '-'));
                }

                // Handle Featured Image
                $file = $this->request->getFile('web_image');
                if ($file && $file->isValid() && !$file->hasMoved()) {
                    $uploadPath = ROOTPATH . 'images/blog/';
                    if (!is_dir($uploadPath)) mkdir($uploadPath, 0755, true);
                    $newName = "blog_" . time() . "_" . rand(1000, 9999) . "." . $file->getExtension();
                    $file->move($uploadPath, $newName);
                    $saveData['web_image'] = $newName;
                }


                if ($isNew) {
                    $saveData['created_by'] = session()->get('user_login_id');
                    $saveData['created_on'] = date('Y-m-d H:i:s');
                    $saveData['is_active'] = 1;
                    $saveData['is_deleted'] = 0;
                    $builder->insert($saveData);
                } else {
                    $saveData['updated_by'] = session()->get('user_login_id');
                    $saveData['updated_on'] = date('Y-m-d H:i:s');
                    $builder->where('web_blog_id', $id)->update($saveData);
                }
                return $this->respond([], 'successfully');

            default:
                return $this->respond([], "Invalid action", 400);
        }
    }

    public function upload_image()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)
                ->setJSON(['error' => ['message' => 'Direct access not allowed']]);
        }

        $file = $this->request->getFile('upload');
        if (!$file || !$file->isValid()) {
            return $this->response->setStatusCode(400)
                ->setJSON(['error' => ['message' => $file ? $file->getErrorString() : 'No file uploaded']]);
        }

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        if (!in_array(strtolower($file->getExtension()), $allowedExtensions)) {
            return $this->response->setStatusCode(400)
                ->setJSON(['error' => ['message' => 'Invalid file type. Allowed types: jpg, jpeg, png, webp, gif']]);
        }

        $uploadPath = ROOTPATH . 'uploads/blog_content_images/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $newName = "blog_" . rand(99, 9999) . time() . '.' . $file->getExtension();
        if (!$file->move($uploadPath, $newName)) {
            return $this->response->setStatusCode(500)
                ->setJSON(['error' => ['message' => 'Unable to save image']]);
        }

        $fileUrl = base_url('uploads/blog_content_images/' . $newName);
        return $this->response->setStatusCode(200)
            ->setJSON(['url' => $fileUrl]);
    }

    public function delete_image()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)
                ->setJSON(['error' => ['message' => 'Direct access not allowed']]);
        }

        $data = json_decode($this->request->getBody(), true);
        if (!isset($data['url']) || empty($data['url'])) {
            return $this->response->setStatusCode(400)
                ->setJSON(['error' => ['message' => 'Image URL is required']]);
        }

        $url = $data['url'];
        $filename = basename($url);
        $filePath = ROOTPATH . 'uploads/blog_content_images/' . $filename;

        if (file_exists($filePath)) {
            if (unlink($filePath)) {
                return $this->response->setStatusCode(200)
                    ->setJSON(['message' => 'Image deleted successfully']);
            } else {
                return $this->response->setStatusCode(500)
                    ->setJSON(['error' => ['message' => 'Unable to delete image']]);
            }
        } else {
            return $this->response->setStatusCode(404)
                ->setJSON(['error' => ['message' => 'Image not found']]);
        }
    }
}