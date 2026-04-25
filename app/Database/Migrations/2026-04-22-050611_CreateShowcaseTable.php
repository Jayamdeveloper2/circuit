<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateShowcaseTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'web_portfolio_showcase_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => false,
                'auto_increment' => true,
            ],
            'web_title' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'web_anchor_id' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'web_status_text' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'default'    => 'In Active Execution',
            ],
            'web_tech_line' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'web_hook' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'execution_progress' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'key_specifications' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'design_highlights' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'pcb_challenges' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'frameworks_applied' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'design_deliverables' => [
                'type' => 'TEXT',
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
            'is_deleted' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
            'created_on' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
        ]);
        $this->forge->addKey('web_portfolio_showcase_id', true);
        $this->forge->createTable('web_portfolio_showcase');
        
        // Add current_timestamp default for created_on manually if forge doesn't support it directly in older CI4 versions
        $this->db->query("ALTER TABLE web_portfolio_showcase MODIFY created_on DATETIME DEFAULT CURRENT_TIMESTAMP");
    }

    public function down()
    {
        $this->forge->dropTable('web_portfolio_showcase');
    }
}
