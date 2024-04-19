<?php

namespace App\Models;

use CodeIgniter\Model;

class Sale extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'sales';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id',
        'number',
        'admin_id',
        'member_id',
      	'cabang_id',
        'contact_id',
        'payment_id',
        'promo_id',
        'warehouse_id',
        'vehicle_id',
        'driver_name',
        'invoice_address',
        'transaction_type',
        'transaction_date',
        'expired_date',
        'sent_date',
        'received_date',
        'time_create',
        'time_done',
        'customer_reference_code',
        'tags',
        'tax',
        'status',
        'need_approve_owner',
        'approve_owner',
        'owner_appriove_id',
        'need_approve_spv_grosir',
        'approve_spv_grosir',
        'spv_grosir_appriove_id',
        'need_approve_spv_retail',
        'approve_spv_retail',
        'spv_retail_appriove_id',
        'details',
        'sales_notes',
        'warehouse_notes',
        'shipping_receipt_file',
        'location_id',
      	'total_discount',
      	'order_id',
      	'is_saved',
      	'trash',
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
