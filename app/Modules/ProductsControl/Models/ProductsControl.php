<?php

namespace App\Modules\ProductsControl\Models;

use CodeIgniter\Model;

class ProductsControl extends Model
{
    protected $table = 'products_control';
    protected $primaryKey = 'products_controlid';
    protected $returnType = 'object';
    protected $allowedFields =  ['count', 'productid','type', 'created_at', 'updated_at','userid'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
