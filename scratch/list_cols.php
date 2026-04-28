<?php
require 'vendor/autoload.php';
$mysqli = new mysqli("localhost", "root", "", "circuitbrilliance_db");
$table = $argv[1];
$result = $mysqli->query("SHOW COLUMNS FROM $table");
while($row = $result->fetch_assoc()) {
    print_r($row);
}
