<?php
require 'app/Config/Paths.php';
$paths = new Config\Paths();
require $paths->systemDirectory . '/Boot.php';
$db = \Config\Database::connect();

try {
    if ($db->tableExists('web_cred_badges')) {
        echo "Table web_cred_badges exists.\n";
        $count = $db->table('web_cred_badges')->countAllResults();
        echo "Row count: $count\n";
    } else {
        echo "Table web_cred_badges DOES NOT exist.\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
