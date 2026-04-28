<?php
$mysqli = new mysqli("localhost", "root", "", "circuitbrilliance_db");

// Fix ID 6
$d6 = json_encode([
    "CB-CRAFT Review Record: every checkpoint reviewed",
    "Framework Summary Report: one-page confirmation",
    "Design Rationale Note: switching loop area, copper weight"
]);
$mysqli->query("UPDATE web_framework_details SET deliverables = '" . $mysqli->real_escape_string($d6) . "' WHERE web_framework_id = 6");

// Fix ID 2
$d2 = json_encode([
    "Thermal analysis per operating point",
    "Junction temperature validation",
    "Heat sink optimization report"
]);
$mysqli->query("UPDATE web_framework_details SET deliverables = '" . $mysqli->real_escape_string($d2) . "' WHERE web_framework_id = 2");

echo "Data cleaned successfully\n";
