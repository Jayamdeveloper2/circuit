<?php
require_once 'app/Config/Database.php';
$db = \Config\Database::connect();

$query = "CREATE TABLE IF NOT EXISTS `web_portfolio_showcase` (
    `web_portfolio_showcase_id` int(11) NOT NULL AUTO_INCREMENT,
    `web_title` varchar(255) DEFAULT NULL,
    `web_anchor_id` varchar(100) DEFAULT NULL,
    `web_status_text` varchar(100) DEFAULT 'In Active Execution',
    `web_tech_line` varchar(255) DEFAULT NULL,
    `web_hook` text DEFAULT NULL,
    `execution_progress` text DEFAULT NULL, 
    `key_specifications` text DEFAULT NULL, 
    `design_highlights` text DEFAULT NULL, 
    `pcb_challenges` text DEFAULT NULL,    
    `frameworks_applied` text DEFAULT NULL, 
    `design_deliverables` text DEFAULT NULL, 
    `display_order` int(11) DEFAULT 0,
    `is_active` tinyint(1) DEFAULT 1,
    `is_deleted` tinyint(1) DEFAULT 0,
    `created_on` datetime DEFAULT current_timestamp(),
    PRIMARY KEY (`web_portfolio_showcase_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($db->query($query)) {
    echo "Showcase table created successfully.";
} else {
    echo "Error creating table: " . $db->error();
}
