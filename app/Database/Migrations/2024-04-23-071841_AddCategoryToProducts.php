<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCategoryToProducts extends Migration
{
    public function up()
    {
        $this->forge->addColumn('products', [
            'COLUMN categoryid INT(10) UNSIGNED'
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('products', 'categoryid');
    }
}
