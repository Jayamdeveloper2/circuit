<?php
require 'vendor/autoload.php';
$paths = new \Config\Paths();
require 'system/bootstrap.php';
$db = \Config\Database::connect();
$res = $db->query("SELECT anchor_id, chart_data FROM web_framework_details")->getResultArray();
echo json_encode($res, JSON_PRETTY_PRINT);
