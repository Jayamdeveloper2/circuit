<?php
$mysqli = new mysqli("localhost", "root", "", "circuitbrilliance_db");
$res = $mysqli->query("SELECT web_framework_id, deliverables FROM web_framework_details");
while($row = $res->fetch_assoc()) {
    echo "ID " . $row['web_framework_id'] . ": " . $row['deliverables'] . "\n";
}
