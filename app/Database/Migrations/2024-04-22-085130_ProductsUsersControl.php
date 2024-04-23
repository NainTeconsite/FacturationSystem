<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class ProductsUsersControl extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'products_users_controlid' => [
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),

            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),

            ],
            'products_controlid' => [
                'type' => 'INT',
                'constraint' => 10,
            ],
            'description' => [
                'type' => 'text',
            ],
            'direction' => [
                'type' => 'text',
            ]

        ]);

        $this->forge->addPrimaryKey('products_users_controlid');
        $this->forge->createTable('products_users_control');
    }

    public function down()
    {
        $this->forge->dropTable('products_users_control');
    }
}
