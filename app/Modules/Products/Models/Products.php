<?php
namespace App\Modules\Products\Models;

use CodeIgniter\Model;

class Products extends Model
{
    protected $primaryKey = 'productid';
    protected $table = 'products';

    protected $allowedFields = ['name', 'code', 'description', 'entry', 'exit', 'stock', 'price', 'categoryid'];

    protected $returnType = 'object';
}
