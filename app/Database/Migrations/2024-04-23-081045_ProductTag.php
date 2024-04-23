<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProductTag extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'productid' =>[
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE, 
            ],
            'tagid' =>[
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE, 
            ]
        ]);
        $this->forge->addPrimaryKey(['productid', 'tagid']);
        $this->forge->createTable('product_tag');
    }

    public function down()
    {
        $this->forge->dropTable('product_tag');
    }
}
