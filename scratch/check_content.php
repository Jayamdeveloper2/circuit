<?php
require 'public/index.php';
$db = \Config\Database::connect();
$res = $db->table('web_content')->select('web_content_id, for')->get()->getResultArray();
foreach($res as $r) {
    echo $r['web_content_id'] . ': ' . ($r['for'] ?? 'N/A') . "\n";
}
