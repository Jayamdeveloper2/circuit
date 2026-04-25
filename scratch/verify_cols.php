<?php
require 'app/Config/Database.php';
$db = \Config\Database::connect();
$cols = $db->getFieldNames('web_why_choose');
if (in_array('web_heading', $cols)) {
    echo "EXISTS";
} else {
    echo "MISSING";
    // Try to fix it here if possible, but I can't run it
}
