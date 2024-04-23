<?php
namespace App\Modules\Users\Controller;
use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Users extends BaseController
{
    use ResponseTrait;

    public function getUsers($type)
    {
        $userModel = new \App\Modules\Users\Models\Users();
        if($type == 'provider'){
           return $this->respond($userModel->where('type =','salesman')->findAll());
        }
        if($type == 'customer'){
            return $this->respond($userModel->where('type =','customer')->findAll());
         }
    }
}