<?php
require 'app/Config/Constants.php';
require 'system/bootstrap.php';
$db = \Config\Database::connect();
$res = $db->table('web_menu')->get()->getResultArray();
echo json_encode($res, JSON_PRETTY_PRINT);
