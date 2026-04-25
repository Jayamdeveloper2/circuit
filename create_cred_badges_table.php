<?php
require 'app/Config/Paths.php';
$paths = new Config\Paths();
require $paths->systemDirectory . '/Boot.php';
$db = \Config\Database::connect();

$forge = \Config\Database::forge();

$fields = [
    'web_cred_badge_id' => [
        'type'           => 'INT',
        'constraint'     => 11,
        'unsigned'       => true,
        'auto_increment' => true,
    ],
    'web_icon' => [
        'type'       => 'VARCHAR',
        'constraint' => '255',
        'null'       => true,
    ],
    'web_title' => [
        'type'       => 'VARCHAR',
        'constraint' => '255',
        'null'       => true,
    ],
    'web_label' => [
        'type'       => 'VARCHAR',
        'constraint' => '255',
        'null'       => true,
    ],
    'display_order' => [
        'type'       => 'INT',
        'constraint' => 11,
        'default'    => 0,
    ],
    'is_active' => [
        'type'       => 'TINYINT',
        'constraint' => 1,
        'default'    => 1,
    ],
    'is_deleted' => [
        'type'       => 'TINYINT',
        'constraint' => 1,
        'default'    => 0,
    ],
    'created_at' => [
        'type' => 'DATETIME',
        'null' => true,
    ],
    'updated_at' => [
        'type' => 'DATETIME',
        'null' => true,
    ],
];

$forge->addField($fields);
$forge->addKey('web_cred_badge_id', true);
$forge->createTable('web_cred_badges', true);

echo "Table web_cred_badges created successfully.\n";

// Seed initial data
$data = [
    [
        'web_icon' => 'fas fa-history',
        'web_title' => '18+',
        'web_label' => 'Years of Experience',
        'display_order' => 1,
        'created_at' => date('Y-m-d H:i:s'),
    ],
    [
        'web_icon' => 'fas fa-certificate',
        'web_title' => 'CID+',
        'web_label' => 'IPC Certification',
        'display_order' => 2,
        'created_at' => date('Y-m-d H:i:s'),
    ],
    [
        'web_icon' => 'fas fa-calendar-alt',
        'web_title' => 'July 2024',
        'web_label' => 'Founded',
        'display_order' => 3,
        'created_at' => date('Y-m-d H:i:s'),
    ],
    [
        'web_icon' => 'fas fa-bolt',
        'web_title' => 'Power Electronics',
        'web_label' => 'Our Only Focus',
        'display_order' => 4,
        'created_at' => date('Y-m-d H:i:s'),
    ],
    [
        'web_icon' => 'fas fa-lightbulb',
        'web_title' => 'Patent Pending',
        'web_label' => 'Intelligent Energy Sentinel (iBMS)',
        'display_order' => 5,
        'created_at' => date('Y-m-d H:i:s'),
    ],
];

$db->table('web_cred_badges')->insertBatch($data);
echo "Initial data seeded successfully.\n";
