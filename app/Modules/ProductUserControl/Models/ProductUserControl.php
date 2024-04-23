<?php
namespace App\Modules\ProductUserControl\Models;

use CodeIgniter\BaseModel;
use CodeIgniter\Model;

class ProductUserControl extends Model
{
    protected $table = 'products_users_control';
    protected $primaryKey = 'products_users_controlid';
    protected $returnType = 'object';
    protected $allowedFields = ['created_at', 'updated_at', 'products_controlid', 'description', 'direction'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}