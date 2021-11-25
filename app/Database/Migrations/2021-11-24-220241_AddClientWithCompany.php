<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddClientWithCompany extends Migration
{
    public function up()
    {
        // Create Client With Company Table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'client_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'null' => false,
                'unsigned' => true
            ],
            'company_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'null' => false,
                'unsigned' => true
            ],
        ]);
        $this->forge->addForeignKey('company_id','companies','id','cascade','cascade');
        $this->forge->addForeignKey('client_id','clients','id','cascade','cascade');
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('client_w_company',true);
    }

    public function down()
    {
        // Drop Client With Company
        $this->forge->dropTable('client_w_company');
    }
}
