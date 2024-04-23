<?php
namespace App\Validation;

use App\Modules\Users\Models\Users;

class UserRules
{
    public function customer($userid) 
    {
        return $this->checkType($userid, 'customer');
    }
    public function provider($userid) 
    {
        return $this->checkType($userid, 'salesman');
    }

    public function checkType($userid, $type)
    {
        $userModel = new Users();

        $user = $userModel->where('type =', $type)->find($userid);
        return $user != null;
    }
}