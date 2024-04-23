<?php
namespace App\Modules\ProductTag\Models;

use CodeIgniter\Model;

class ProductTag extends Model
{
    protected $table = 'product_tag';
    protected $allowedFields = ['productid', 'tagid'];
    protected $returnType = 'object';
}