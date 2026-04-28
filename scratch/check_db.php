<?php
require 'vendor/autoload.php';
$mysqli = new mysqli("localhost", "root", "", "circuitbrilliance_db");
$table = $argv[1];
$col = $argv[2];
$id = $argv[3];
$pk = ($table == 'web_framework_details') ? 'web_framework_id' : 'id';
$result = $mysqli->query("SELECT $col FROM $table WHERE $pk = $id");
if($row = $result->fetch_assoc()) {
    echo $row[$col];
} else {
    echo "No record found";
}
