<?php

namespace App\Controllers;

use Hermawan\DataTables\DataTable;

helper('tools_helper');

class Accounting extends BaseController

{
    protected $buysModel;
    protected $buyItemsModel;
    protected $paymentTermsModel;
    protected $supplierModel;
    protected $warehouseModel;
    protected $contactModel;
    protected $stocksModel;
    protected $categoriesModel;
    protected $statusModel;
    protected $productModel;
    protected $session;
    protected $db;
    protected $saleModel ;
    protected $adminModel  ;
    protected $paymentModel  ;
    protected $tagModel ;
    protected $saleItemModel ;
    protected $promoModel;
    protected $locationModel ;

    public function __construct(){
        $this->session = \Config\Services::session();
        $this->buysModel = new \App\Models\Buy();
        $this->statusModel = new \App\Models\Status();
        $this->buyItemsModel = new \App\Models\BuyItem();
        $this->paymentTermsModel = new \App\Models\PaymentTerm();
        $this->categoriesModel = new \App\Models\Category();
        // $this->suppliers = new \App\Models\Supplier();
        $this->contactModel = new \App\Models\Contact();
        $this->warehouseModel = new \App\Models\Warehouse();
        $this->stocksModel = new \App\Models\Stock();
        $this->supplierModel = new \App\Models\Supplier();
        $this->productModel = new \App\Models\Product();
        $this->saleModel = new \App\Models\Sale();
        $this->db = \Config\Database::connect();
        $this->adminModel =  new \App\Models\Administrator();
        $this->paymentModel = new \App\Models\PaymentTerm();
        $this->tagModel = new \App\Models\Tag();
        $this->saleItemModel = new \App\Models\SaleItem();
        $this->promoModel = new \App\Models\Promo();
        $this->locationModel = new \App\Models\Location();
    }

    public function product_buys()
    {
        $good_buys = $this->buysModel
            ->join('contacts', 'contacts.id = buys.supplier_id', "left")
            ->join('warehouses', 'warehouses.id = buys.warehouse_id', "left")
            ->select(['buys.number', 'buys.supplier_id', 'buys.payment_term_id', 'contacts.name as "contact_name"', 'warehouses.name as "warehouse_name"', 'buys.date', 'buys.discount', 'buys.tax', 'buys.notes', 'buys.id'])
            ->orderBy('buys.date', 'desc')
            ->get()
            ->getResultObject();

        $buy_terms = $this->paymentTermsModel->where(['trash' => 0])->findAll();
        $this->categoriesModel->findAll();
        $suppliers = $this->contactModel
            ->where("type", 1)
            ->where("trash", 0)
            ->orderBy("name", "asc")
            ->findAll();

        $warehouses = $this->warehouseModel
            ->where("trash", 0)
            ->orderBy("name", "asc")
            ->findAll();

        $data = [
            'good_buys' => $good_buys,
            'buy_terms' => $buy_terms,
            'suppliers' => $suppliers,
            'warehouses' => $warehouses,
        ];
        // dd($data);
        return view('accounting/accounting', $data);
    }

    public function manage_product_buys($goodBuysID)
    {
        $good_buys_data = $this->buysModel->where(['id' => $goodBuysID])->first();
        if ($good_buys_data != null) {
            $suppliers = $this->contactModel
            ->where("type",1)
            ->where("trash",0)
            ->orderBy("name","asc")
            ->findAll();
            $warehouses = $this->warehouseModel
            ->where("trash",0)
            ->orderBy("name","asc")
            ->findAll();
            $goods = $this->productModel->where(['trash' => 0])->orderBy('name','asc')->findAll();
            
            $good_buys = $this->buysModel
            ->select([
            'buys.id',
            'buys.admin_id',
            'buys.supplier_id',
            'buys.payment_term_id',
            'buys.warehouse_id',
            'buys.date',
            'buys.tax',
            'buys.discount',
            'buys.notes',
            'buys.file',
            ])
            ->join('contacts', 'contacts.id = buys.supplier_id')
            ->join('warehouses', 'warehouses.id = buys.warehouse_id')
            ->where(['buys.id' => $goodBuysID])
            ->select(['buys.number', 'buys.supplier_id', 'buys.warehouse_id', 'buys.payment_term_id', 'contacts.name as "contact_name"', 'warehouses.name as "warehouse_name"', 'buys.date', 'buys.discount', 'buys.tax', 'buys.notes', 'buys.id'])
            ->first();
                
            $good_buy_items = $this->buyItemsModel
                ->join('products', 'products.id = buy_items.product_id')
                ->where(['buy_items.buy_id' => $goodBuysID])
                ->select(['products.name', 'buy_items.price', 'buy_items.quantity', 'products.id as product_id', 'buy_items.id'])
                ->findAll();
                
            $buy_term = $this->paymentTermsModel->where('trash', 0)->findAll();
            
            $sumBuyTable = 0;
            foreach ($good_buy_items as $good_buy_item) {
                $sumBuyTable = $sumBuyTable + ($good_buy_item->quantity * $good_buy_item->price);
            }
            // dd($good_buys);
            // $countOfprice = array_sum($this->goodBuyItems->where(['buy_id' => $goodBuysID])->findColumn('price'));
            
            $tax = ((int)$good_buys->tax / 100 *  $sumBuyTable);
            $discount = ((int)$good_buys->discount / 100 *  $sumBuyTable);
            $data = [
                'good_buys' => $good_buys,
                'buy_items' => $good_buy_items,
                'suppliers' => $suppliers,
                'warehouses' => $warehouses,
                'buy_terms' => $buy_term,
                'products' => $goods,
                'sumBuyTable' => $sumBuyTable,
                'tax' => $tax,
                'discount' => $discount,
                'count_price' => $sumBuyTable,
                "db"        => $this->db,
            ];
            return view('accounting/accounting_buys_manage', $data);
        } else {
            $this->session->setFlashdata('message_type', 'warning');
            $this->session->setFlashdata('message_content', 'Data tidak ditemukan');
            return redirect()->to(base_url('/products/buys'));
        }
    }

    public function sales()
    {
        $sales = $this->saleModel
            ->where("admin_id", $this->session->login_id)
            ->where("contact_id !=", NULL)
            ->where("payment_id !=", NULL)
            ->where('trash', 0)
            ->orderBy("transaction_date", "desc")
            ->orderBy("id", "desc")
            ->findAll();


        $data = ([
            "sales" => $sales,
            "db"    => $this->db,
        ]);

        return view("accounting/accounting_sales", $data);
    }

    public function getSalesDataPerAllowedWarehouse()
    {
        $allow_warehouses = !empty(cek_session($this->session->get('login_id'))['allow_warehouses']) ? cek_session($this->session->get('login_id'))['allow_warehouses'] : '"1","2","3","4","5","6","7","8","9","10"';

        $builder = $this->db->table('sales')
            ->select('sales.id, number, transaction_date, administrators.name as admin_name, contacts.name as contact_name, contacts.phone as contact_phone,status, tags')
            ->join('administrators', 'sales.admin_id = administrators.id')
            ->join('contacts', 'sales.contact_id = contacts.id')
            ->where("sales.id in(
            select sale_id from sale_items as AA
            inner join product_stocks as BB on AA.id=BB.sale_item_id 
            where BB.warehouse_id in($allow_warehouses)
        )")
            ->orderBy('sales.id', 'desc');

        return DataTable::of($builder)
            ->setSearchableColumns(["sales.number", "sales.transaction_date", "contacts.name", "administrators.name"])
            ->toJson(true);
    }

    public function sales_manage($id)
    {
        $sale = $this->saleModel->where("id", $id)->first();

        if ($sale == NULL) {
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', 'Data tidak ditemukan');

            return redirect()->to(base_url('dashboard'));
        }

        if ($sale->is_saved == NULL) {
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', 'Penjualan Belum Disimpan');
        }

        $contacts = $this->contactModel
            ->where('contacts.name !=', "")
            ->where("type", 2)
            ->where("trash", 0)
            ->orderBy("name", "asc")
            ->findAll();

        $contact = $this->contactModel
            ->where("id", $sale->contact_id)->first();

        $admin = $this->adminModel
            ->where("id", $sale->admin_id)->first();

        $warehouse = $this->warehouseModel
            ->where("id", $sale->warehouse_id)
            ->first();

        $payments = $this->paymentModel
            ->where("trash", 0)
            ->orderBy("name", "asc")
            ->findAll();

        $tags = $this->tagModel
            ->orderBy("name", "asc")
            ->findAll();

        $products = $this->productModel
            ->where("trash", 0)
            ->orderBy("name", "asc")
            ->findAll();

        $items = $this->saleItemModel
            ->select("sale_items.*,B.quantity as QtyKeluar")
            ->join("delivery_items as B", "sale_items.id=B.sale_item_id", "left")
            ->where("sale_id", $id)
            ->findAll();

        $promos = $this->promoModel
            ->where("date_start <=", date("Y-m-d"))
            ->where("date_end >=", date("Y-m-d"))
            ->findAll();

        $contact = $this->contactModel
            ->where("contacts.name !=", "")
            ->where("id", $sale->contact_id)
            ->first();

        $warehouses = $this->warehouseModel
            ->where("trash", 0)
            ->orderBy("name", "asc")
            ->findAll();

        $payment = $this->paymentModel
            ->where("id", $sale->payment_id)
            ->first();

        $locations = $this->locationModel
            ->where("trash", 0)
            ->findAll();

        $goods = $this->saleItemModel
            ->select(["products.name as product_name", "products.id"])
            ->join('products', 'sale_items.product_id = products.id', 'left')
            ->where('sale_id', $id)
            ->orderBy('products.name', 'asc')
            ->findAll();

        $data = ([
            "db"    => $this->db,
            "contacts"  => $contacts,
            "contact"  => $contact,
            "goods"  => $goods,
            "admin"  => $admin,
            "payments" => $payments,
            "tags" => $tags,
            "products" => $products,
            "sale"  => $sale,
            "items" => $items,
            "promos" => $promos,
            "thisContact"   => $contact,
            "payment" => $payment,
            "locations" => $locations,
            "warehouses"          => $warehouses,
        ]);

        return view("accounting/accounting_sales_manage", $data);

        // if ($sale->status < 4) {
        //     return view("sales/sales_manage", $data);
        // } else {
        //     return view("sales/sales_manage_fix", $data);
        // }
    }
}

