<?php
require 'vendor/autoload.php';
// Raw DB check
$mysqli = new mysqli("localhost", "root", "", "circuitbrilliance_db");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$result = $mysqli->query("SELECT * FROM web_framework_details");
echo "Rows: " . ($result ? $result->num_rows : "ERROR") . "\n";
if($result) {
    while($row = $result->fetch_assoc()) {
        echo "ID: " . $row['web_framework_id'] . " | Anchor: " . $row['anchor_id'] . "\n";
    }
}

$result2 = $mysqli->query("SELECT * FROM web_content WHERE `for` = 'framework_hero'");
echo "\nHero Rows: " . ($result2 ? $result2->num_rows : "ERROR") . "\n";
if($result2) {
    while($row = $result2->fetch_assoc()) {
        echo "Title: " . $row['web_content_1'] . "\n";
    }
}
