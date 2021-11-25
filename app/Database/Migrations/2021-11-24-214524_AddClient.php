<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddClient extends Migration
{
    public function up()
    {
        // Create Clients Table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'unique' => true
            ],
            'identity' => [
                'type' => 'BIGINT',
                'constraint' => 11,
                'null' => false,
                'unique' => true
            ],
            'mernis_status' =>[
                'type' => 'TINYINT',
                'null' => false,
                'default' => 0
            ],
            'birth_date' =>[
              'type' => 'date',
              'null' => false,
            ],
            'is_active' => [
                'type' => 'TINYINT',
                'null' => false,
                'default' => 0
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
        'created_at datetime default current_timestamp',
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('clients',true);
    }

    public function down()
    {
        // Drop Table
        $this->forge->dropTable('clients');
    }
}
