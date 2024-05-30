<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDynamicLinksTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'dynamic_link' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('dynamic_links');
    }

    public function down()
    {
        $this->forge->dropTable('dynamic_links');
    }
}
