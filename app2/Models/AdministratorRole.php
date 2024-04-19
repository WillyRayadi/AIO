<?php

namespace App\Models;

use CodeIgniter\Model;

class AdministratorRole extends Model
{
    protected $table      = 'administrator_role';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'role_name',
        'purchase_order_buat',
        'purchase_order_edit',
        'purchase_order_lihat',
        'purchase_order_hapus',
        'sales_order_buat',
        'sales_order_edit',
        'sales_order_lihat',
        'sales_order_hapus',
        'delivery_order_buat',
        'delivery_order_edit',
        'delivery_order_lihat',
        'delivery_order_hapus',
        'transfer_warehouse_buat',
        'transfer_warehouse_edit',
        'transfer_warehouse_lihat',
        'transfer_warehouse_hapus',
        'retur_product_buat',
        'retur_product_edit',
        'retur_product_lihat',
        'retur_product_hapus',
        'manifest_so_buat',
        'manifest_so_edit',
        'manifest_so_lihat',
        'manifest_so_hapus',
        'stokopname_buat',
        'stokopname_edit',
        'stokopname_lihat',
        'stokopname_hapus',
        'products_buat',
        'products_edit',
        'products_lihat',
        'products_hapus',
        'agreement_edit',
        'agreement_hapus',
    ];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
