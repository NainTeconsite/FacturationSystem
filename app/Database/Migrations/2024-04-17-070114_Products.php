<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Products extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'productid' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'code' => [
                'type' => 'VARCHAR',
                'constraint' => 10
            ]
            ,
            'description' => [
                'type' => 'TEXT',
            ],
            'entry' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'exit' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'stock' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
        ]);
        $this->forge->addPrimaryKey('productid');
        $this->forge->createTable('products');
    }

    public function down()
    {
        $this->forge->dropTable('products');
    }
}
