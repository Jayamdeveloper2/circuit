<?php
require 'app/Config/Paths.php';
$paths = new Config\Paths();
require $paths->systemDirectory . '/Boot.php';
$db = \Config\Database::connect();
try {
    $fields = $db->getFieldNames('web_why_choose');
    echo "Fields in web_why_choose: " . implode(', ', $fields) . "\n";
    
    $fields2 = $db->getFieldNames('web_content');
    echo "Fields in web_content: " . implode(', ', $fields2) . "\n";
    
    $res = $db->table('web_content')->where('web_content_id', 12)->get()->getRowArray();
    if ($res) {
        echo "web_content_id 12 exists\n";
    } else {
        echo "web_content_id 12 MISSING\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
