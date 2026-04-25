<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePlannedShowcaseTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'web_planned_showcase_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'web_tag' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'web_title' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'web_tech_line' => [
                'type'       => 'VARCHAR',
                'constraint' => '500',
            ],
            'web_features' => [
                'type' => 'TEXT',
            ],
            'web_footer' => [
                'type'       => 'VARCHAR',
                'constraint' => '500',
                'null'       => true,
            ],
            'theme_class' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'default'    => 'bms-theme',
            ],
            'anchor_id' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
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
        ]);
        $this->forge->addKey('web_planned_showcase_id', true);
        $this->forge->createTable('web_planned_showcase');
    }

    public function down()
    {
        $this->forge->dropTable('web_planned_showcase');
    }
}
