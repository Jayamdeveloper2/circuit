<?php
require 'app/Config/Paths.php';
$paths = new Config\Paths();
require $paths->systemDirectory . '/Boot.php';
$db = \Config\Database::connect();

try {
    $results = $db->table('web_content')
        ->select('web_content_id, web_content_1')
        ->get()
        ->getResultArray();
    foreach ($results as $row) {
        echo "ID: " . $row['web_content_id'] . " | Title: " . $row['web_content_1'] . "\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
