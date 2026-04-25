<?php
require 'app/Config/Database.php';
$db = \Config\Database::connect();
$row = $db->table('web_menu')->where('web_menu_id', 1)->get()->getRowArray();
echo json_encode($row, JSON_PRETTY_PRINT);
