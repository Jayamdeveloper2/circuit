<?php
$db = new PDO('mysql:host=localhost;dbname=aastra_db', 'root', '');
$stmt = $db->query('SELECT web_menu_id, web_title, web_url, is_active FROM web_menu');
file_put_contents('aastra_temp.txt', print_r($stmt->fetchAll(PDO::FETCH_ASSOC), true));
