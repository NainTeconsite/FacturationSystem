<?php
namespace App\Modules\Users\Models;
use CodeIgniter\Model;

class Users extends Model 
{
    protected $primaryKey = 'userid';
    protected $table = 'users';
    protected $allowedFields =  ['username','email','password','type'];
    protected $returnType = 'object';
}