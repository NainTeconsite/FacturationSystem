<?php
namespace App\Modules\Categories\Models;

use CodeIgniter\Model;

class Categories extends Model
{
    protected $primaryKey = 'categoryid';
    protected $table = 'categories';

    protected $allowedFields = ['name'];

    protected $returnType = 'object';
}
