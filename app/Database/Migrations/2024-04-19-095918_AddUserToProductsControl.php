<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUserToProductsControl extends Migration
{
    public function up()
    {
        $this->forge->addColumn('products_control', [
            'userid' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('products_control','userid');
    }
}
