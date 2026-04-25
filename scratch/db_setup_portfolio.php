<?php
require_once 'app/Config/Database.php';
$config = new \Config\Database();
$db = \Config\Database::connect();

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
    
    "INSERT INTO `web_content` (`web_content_id`, `web_content_1`, `web_content_2`, `status`) 
    SELECT 16, 'Portfolio Intro', 'If you are developing a power electronics product — an EV charger, a battery management system, a solar inverter, or a high-power converter — you already know that finding a design partner who genuinely understands the hardware is not straightforward. Circuit Brilliance was built for exactly that gap. Every case study on this page represents a complete design engagement — schematic, simulation, PCB layout, and documentation — executed with the same structured methodology we bring to every client project.', 1
    WHERE NOT EXISTS (SELECT 1 FROM `web_content` WHERE `web_content_id` = 16);"
];

foreach ($queries as $query) {
    if ($db->query($query)) {
        echo "Success: " . substr($query, 0, 50) . "...\n";
    } else {
        echo "Error: " . $db->error() . "\n";
    }
}
