<?php
require_once 'app/Config/Database.php';
$config = new \Config\Database();
$db = \Config\Database::connect();

echo "<pre>";

$queries = [
    "CREATE TABLE IF NOT EXISTS `web_portfolio_domain` (
        `web_portfolio_domain_id` int(11) NOT NULL AUTO_INCREMENT,
        `web_title` varchar(255) DEFAULT NULL,
        `web_content` text DEFAULT NULL,
        `web_image` varchar(255) DEFAULT NULL,
        `web_url` varchar(255) DEFAULT NULL,
        `display_order` int(11) DEFAULT 0,
        `is_active` tinyint(1) DEFAULT 1,
        `is_deleted` tinyint(1) DEFAULT 0,
        `created_on` datetime DEFAULT current_timestamp(),
        PRIMARY KEY (`web_portfolio_domain_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",
    
    "INSERT INTO `web_content` (`web_content_id`, `web_content_1`, `web_content_2`, `status`, `page_name`, `section_name`) 
    SELECT 16, 'Portfolio Intro', 'If you are developing a power electronics product...', 1, 'Portfolio', 'Intro'
    WHERE NOT EXISTS (SELECT 1 FROM `web_content` WHERE `web_content_id` = 16);",
    
    "INSERT INTO `web_menu` (`web_menu_id`, `web_title`, `web_url`, `is_active`, `is_deleted`) 
    SELECT 6, 'Portfolio', 'portfolio', 1, 0
    WHERE NOT EXISTS (SELECT 1 FROM `web_menu` WHERE `web_menu_id` = 6);"
];

foreach ($queries as $query) {
    if ($db->query($query)) {
        echo "Success: " . substr($query, 0, 50) . "...\n";
    } else {
        echo "Error: " . $db->error() . "\n";
    }
}

echo "\nSetup Complete. Please refresh your page.";
echo "</pre>";
