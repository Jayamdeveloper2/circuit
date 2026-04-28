<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWebServiceDetails extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'web_service_details_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'section_anchor' => [
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
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'image' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'theme_color' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'what_we_design' => [
                'type' => 'TEXT', // JSON
                'null' => true,
            ],
            'deliverables' => [
                'type' => 'TEXT', // JSON
                'null' => true,
            ],
            'technologies' => [
                'type' => 'TEXT', // JSON
                'null' => true,
            ],
            'display_order' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 1,
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
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_on' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('web_service_details_id', true);
        $this->forge->createTable('web_service_details');
    }

    public function down()
    {
        $this->forge->dropTable('web_service_details');
    }
}
