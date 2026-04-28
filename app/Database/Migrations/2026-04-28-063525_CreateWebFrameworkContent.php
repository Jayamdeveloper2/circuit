<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWebFrameworkContent extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'framework_slug' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'section_key' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'content_value' => [
                'type' => 'TEXT',
                'null' => true,
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
        $this->forge->addKey('id', true);
        $this->forge->addKey(['framework_slug', 'section_key']);
        $this->forge->createTable('web_framework_content');
    }

    public function down()
    {
        $this->forge->dropTable('web_framework_content');
    }
}
