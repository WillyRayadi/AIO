<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductStock extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'product_stocks';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'warehouse_id',
        'product_id',
        'date',
        'qty_recorded',
        'qty_real',
        'quantity',
        'sale_item_id',
        'buy_item_id',
        'purchase_order_id',
        'product_repair_id',
        'product_return_id',
        'product_display_id',
        'warehouse_transfer_id',
        'inden_warehouse_id',
        'voucher_id',
        'details',
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
