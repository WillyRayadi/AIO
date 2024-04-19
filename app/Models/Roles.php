<?php

namespace App\Models;

use CodeIgniter\Model;

class Roles extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'administrator_role';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'purchase_order_buat',
        'purchase_order_lihat',
        'purchase_order_edit',
        'purchase_order_hapus',
        'sales_order_buat',
        'sales_order_lihat',
        'sales_order_edit',
        'sales_order_hapus',
        'delivery_order_buat',
        'delivery_order_lihat',
        'delivery_order_edit',
        'delivery_order_hapus',
        'transfer_warehouse_buat',
        'transfer_warehouse_lihat',
        'transfer_warehouse_edit',
        'transfer_warehouse_hapus',
        'retur_product_buat',
        'retur_product_lihat',
        'retur_product_edit',
        'retur_product_hapus',
        'manifest_so_buat',
        'manifest_so_lihat',
        'manifest_so_edit',
        'manifest_so_hapus',
        'stokopname_buat',
        'stokopname_lihat',
        'stokopname_edit',
        'stokopname_hapus',
        'products_buat',
        'products_lihat',
        'products_edit',
        'products_hapus',
        'agreement_buat',
        'agreement_lihat',
        'agreement_edit',
        'agreement_hapus'
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
