<?php

namespace App\Models;

use CodeIgniter\Model;

class Administrator extends Model
{
    protected $table      = 'administrators';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'email',
      	'cabang',
        'username',
        'password',
        'name',
        'phone',
        'address',
        'role',
        'active',
        'sale_target',
        'allow_warehouses',
    ];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
