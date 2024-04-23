<?php
namespace App\Modules\Tags\Models;

use CodeIgniter\Model;

class Tags extends Model
{
    protected $primaryKey = 'tagid';
    protected $table = 'tags';

    protected $allowedFields = ['name'];

    protected $returnType = 'object';
}
