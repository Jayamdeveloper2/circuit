<?php
$conn = new mysqli("localhost", "root", "", "circuitbrilliance_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT web_content_id FROM web_content ORDER BY web_content_id";
$result = $conn->query($sql);
if ($result) {
    echo "Existing web_content_ids: ";
    while ($row = $result->fetch_assoc()) {
        echo $row['web_content_id'] . ", ";
    }
    echo "\n";
}
$conn->close();
