<?php
require 'app/Config/Paths.php';
$paths = new Config\Paths();
require $paths->systemDirectory . '/Boot.php';
$db = \Config\Database::connect();

try {
    $fields = $db->getFieldNames('web_cred_badges');
    echo "Fields in web_cred_badges: " . implode(', ', $fields) . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
