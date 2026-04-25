<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Blog extends BaseController
{
    public function __construct() {
        helper('url');
        helper("util");
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

        $uploadPath = FCPATH . 'uploads/blog_content_images/';
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

        // Extract filename from URL
        $url = $data['url'];
        $filename = basename($url);
        $filePath = FCPATH . 'uploads/blog_content_images/' . $filename;

        // Security check: Ensure the file is in the uploads directory
        if (strpos($filePath, FCPATH . 'uploads/blog_content_images/') !== 0) {
            return $this->response->setStatusCode(400)
                ->setJSON(['error' => ['message' => 'Invalid file path']]);
        }

        // Check if file exists and delete it
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