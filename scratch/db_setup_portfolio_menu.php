<?php
require_once 'app/Config/Database.php';
$db = \Config\Database::connect();

$queries = [
    "INSERT INTO `web_menu` (`web_menu_id`, `web_title`, `web_url`, `is_active`, `is_deleted`) 
    SELECT 6, 'Portfolio', 'portfolio', 1, 0
    WHERE NOT EXISTS (SELECT 1 FROM `web_menu` WHERE `web_menu_id` = 6);"
];

foreach ($queries as $query) {
    $db->query($query);
}
echo "Menu setup check done.\n";
