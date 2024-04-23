<?php

namespace App\Database\Seeds;

use App\Modules\Users\Models\Users;
use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $userModel = new Users();
        for ($i = 0; $i < 5; $i++) {
            $userModel->insert([
                'username' => "regular $i",
                'email' => "regular$i@gmail.com",
                'password' => '12345',
                'type' => 'customer'
            ]);
        }
        for ($i = 0; $i < 5; $i++) {
            $userModel->insert([
                'username' => "salesman $i",
                'email' => "salesman$i@gmail.com",
                'password' => '12345',
                'type' => 'salesman'
            ]);
        }
        $userModel->insert([
            'username' => "admin",
            'email' => "admin@gmail.com",
            'password' => '12345',
            'type' => 'admin'
        ]);
    }
}
