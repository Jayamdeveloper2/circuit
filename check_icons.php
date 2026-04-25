<?php
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR);
chdir(FCPATH);
require FCPATH . '../app/Config/Paths.php';
$paths = new Config\Paths();
require $paths->systemDirectory . '/bootstrap.php';
$db = \Config\Database::connect();
$icons = $db->table('web_service_cate')->select('web_icon')->get()->getResultArray();
echo "Icons in DB:\n";
foreach ($icons as $icon) {
    echo "- " . $icon['web_icon'] . "\n";
}
echo "\n";
