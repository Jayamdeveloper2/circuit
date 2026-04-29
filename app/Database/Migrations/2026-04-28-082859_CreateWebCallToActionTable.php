<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWebCallToActionTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'web_call_to_action_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'tag' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'content' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
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

        $this->forge->addKey('web_call_to_action_id', true);
        $this->forge->createTable('web_call_to_action', true);
    }

    public function down()
    {
        $this->forge->dropTable('web_call_to_action', true);
    }
}
