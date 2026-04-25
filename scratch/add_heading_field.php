<?php
require 'app/Config/Database.php';
$db = \Config\Database::connect();
$db->query("ALTER TABLE web_why_choose ADD COLUMN web_heading VARCHAR(255) AFTER web_subtitle");
echo "Done";
