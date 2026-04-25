<?php
require 'app/Config/Paths.php';
$paths = new Config\Paths();
require $paths->systemDirectory . '/Boot.php';
$db = \Config\Database::connect();
$res = $db->table('web_menu')->where('web_menu_id', 1)->get()->getRowArray();
echo "Menu 1: " . json_encode($res) . "\n";
$res2 = $db->table('web_content')->where('web_content_id', 10)->get()->getRowArray();
echo "Content 10: " . json_encode($res2) . "\n";
