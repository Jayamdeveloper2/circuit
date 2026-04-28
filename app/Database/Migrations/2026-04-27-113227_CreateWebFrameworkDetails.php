<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWebFrameworkDetails extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'web_framework_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'anchor_id' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'title_eb' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'heading' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'quote' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'theme_color' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'default'    => '#1B5E82',
            ],
            'chart_label' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'chart_data' => [
                'type' => 'JSON',
                'null' => true,
            ],
            'counters' => [
                'type' => 'JSON',
                'null' => true,
            ],
            'deliverables' => [
                'type' => 'JSON',
                'null' => true,
            ],
            'extra_content' => [
                'type' => 'JSON',
                'null' => true,
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
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('web_framework_id', true);
        $this->forge->createTable('web_framework_details');
    }

    public function down()
    {
        $this->forge->dropTable('web_framework_details');
    }
}
