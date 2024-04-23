<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateUsers extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('users', [
            'type' => [
                'type' => 'ENUM',
                'constraint' => ['admin', 'customer', 'salesman', 'provider'],
                'default' => 'customer'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('users', [
            'type' => [
                'type' => 'ENUM',
                'constraint' => ['admin', 'customer', 'salesman'],
                'default' => 'customer'
            ]
        ]);
    }
}
