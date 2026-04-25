<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Config\Services;

class CacheController extends Controller
{
    public function clear()
    {
        // Clear application cache
        $cache = Services::cache();
        $cache->clean();

        // Clear writable/cache manually
        $cachePath = WRITEPATH . 'cache/';
        $this->deleteFiles($cachePath);

        return response()->setJSON([
            'status'  => true,
            'message' => 'Cache cleared successfully'
        ]);
    }

    private function deleteFiles($dir)
    {
        if (!is_dir($dir)) return;

        foreach (glob($dir . '*') as $file) {
            if (is_file($file)) {
                @unlink($file);
            }
        }
    }
}
