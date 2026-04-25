<?php
require 'd:/xampp/htdocs/ufes/app/Config/Constants.php';
$conn = mysqli_connect('localhost', 'root', '', 'travelneeds_db');
if (!$conn) die("Connection failed: " . mysqli_connect_error());

$sql = "SELECT count(*) as total FROM web_approach WHERE is_deleted = 0";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
echo "Total (is_deleted=0): " . $row['total'] . "\n";

$sql = "SELECT web_approach_id, web_title, is_deleted FROM web_approach LIMIT 100";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    echo "ID: " . $row['web_approach_id'] . " | Title: " . $row['web_title'] . " | Deleted: " . $row['is_deleted'] . "\n";
}
