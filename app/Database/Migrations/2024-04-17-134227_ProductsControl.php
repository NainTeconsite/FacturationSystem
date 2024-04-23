<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class ProductsControl extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'products_controlid' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'count' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
            ],
            'productid' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'type' => [
                'type' => 'ENUM',
                'constraint' => ['exit', 'entry'],
                'default' => 'entry',
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),

            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            
        ]);
        $this->forge->addPrimaryKey('products_controlid');
        $this->forge->createTable('products_control');
    }

    public function down()
    {
        $this->forge->dropTable('products_control');
    }
}
