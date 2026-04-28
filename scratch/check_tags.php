<?php
include 'app/Config/Constants.php';
$db = mysqli_connect('localhost', 'root', '', 'circuit'); // Assuming standard XAMPP
$query = mysqli_query($db, "SELECT tag FROM web_call_to_action");
while($row = mysqli_fetch_assoc($query)) {
    echo $row['tag'] . "\n";
}
?>
