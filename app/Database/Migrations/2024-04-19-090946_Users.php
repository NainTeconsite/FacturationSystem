<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'userid' => [
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'unique'=> TRUE
            ],
            'email' =>[
                'type' => 'VARCHAR',
                'constraint' => 100,
                'unique' => TRUE
            ],
            'password' =>[
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'type' => [
                'type' => 'ENUM',
                'constraint' => ['admin', 'customer', 'salesman'],
                'default' => 'customer'
            ]
        ]);

        $this->forge->addPrimaryKey('userid');
        $this->forge->createTable('users');

    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
