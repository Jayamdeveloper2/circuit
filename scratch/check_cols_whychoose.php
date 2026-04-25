<?php
require 'app/Config/Database.php';
$db = \Config\Database::connect();
$cols = $db->getFieldNames('web_why_choose');
echo json_encode($cols, JSON_PRETTY_PRINT);
