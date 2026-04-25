<?php
$conn = new mysqli("localhost", "root", "", "circuitbrilliance_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fix web_why_choose table schema
$sqls = [
    "ALTER TABLE web_why_choose ADD COLUMN is_deleted TINYINT(1) DEFAULT 0",
    "ALTER TABLE web_why_choose ADD COLUMN created_by INT(11) DEFAULT NULL",
    "ALTER TABLE web_why_choose ADD COLUMN updated_by INT(11) DEFAULT NULL",
    "ALTER TABLE web_why_choose ADD COLUMN updated_on TIMESTAMP NULL DEFAULT NULL",
];

foreach ($sqls as $sql) {
    if ($conn->query($sql) === TRUE) {
        echo "Success: $sql\n";
    } else {
        echo "Error: " . $conn->error . " for query: $sql\n";
    }
}

// Ensure web_content ID 12 exists (redundant since I added it in PHP, but good for safety)
$sql_check = "SELECT * FROM web_content WHERE web_content_id = 12";
$res = $conn->query($sql_check);
if ($res->num_rows == 0) {
    $sql_insert = "INSERT INTO web_content (web_content_id, status) VALUES (12, 1)";
    $conn->query($sql_insert);
    echo "Inserted web_content ID 12\n";
}

$conn->close();
