<?php

namespace App\Controllers;

class BuyItems extends Admin
{
    private $buysModel;
    private $buyItemsModel;
    private $supplierModel;
    private $productModel;
    private $contactModel;
    private $warehouseModel;
    private $paymentTermsModel;
    private $stocksModel;
    private $productStockModel;
    protected $session;
    protected $db;
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->buysModel = new \App\Models\Buy();
        $this->db = \Config\Database::connect();
        $this->paymentTermsModel = new \App\Models\PaymentTerm();
        $this->productModel = new \App\Models\Product();
        $this->supplierModel = new \App\Models\Supplier();
        $this->contactModel = new \App\Models\Contact();
        $this->warehouseModel = new \App\Models\Warehouse();
        $this->buyItemsModel = new \App\Models\BuyItem();
        $this->paymentTermsModel = new \App\Models\PaymentTerm();
        $this->stocksModel = new \App\Models\Stock();
        $this->productStockModel = new \App\Models\ProductStock();
        if($this->session->login_id == null){            
            $this->session->setFlashdata('msg', 'Maaf, Silahkan login terlebih dahulu!');
            header("location:".base_url('/'));
            exit();
        }else{
            if(config("Login")->loginRole != 1){
                if(config("Login")->loginRole != 7){
                    header("location:".base_url('/dashboard'));
                    exit();
                }
            }
        }
        helper("form");
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
            return view('modules/buys_manage', $data);
        } else {
            $this->session->setFlashdata('message_type', 'warning');
            $this->session->setFlashdata('message_content', 'Data tidak ditemukan');
            return redirect()->to(base_url('/products/buys'));
        }
    }

    public function manage_product_buy_admin($goodBuysID){ 
        $product = $this->request->getPost('product');

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
                'buys.status',
            ])
            ->join('contacts', 'contacts.id = buys.supplier_id')
            ->join('warehouses', 'warehouses.id = buys.warehouse_id')
            ->where(['buys.id' => $goodBuysID])
            ->select(['buys.number', 'buys.supplier_id', 'buys.warehouse_id', 'buys.payment_term_id', 'contacts.name as "contact_name"','warehouses.name as "warehouse_name"', 'buys.date', 'buys.discount', 'buys.tax', 'buys.notes', 'buys.id'])
            ->first();

            $good_buy_items = $this->buyItemsModel
            ->join('products', 'products.id = buy_items.product_id')
            ->join('buys','buy_items.buy_id = buys.id','left')
            ->where(['buy_items.buy_id' => $goodBuysID])
            ->select(['products.name as product_name', 'buy_items.price', 'buys.status', 'buy_items.quantity', 'products.id as product_id', 'buy_items.id'])
            ->findAll();
            
            $buyNumber = $this->buysModel
            ->select([
                'buys.id',
                'buys.number',
                'buy_items.quantity',
            ])
            ->join('buy_items','buys.id = buy_items.buy_id','left')
            ->orderBy('buys.id','desc')
            ->get()->getResultObject();

            $buy_term = $this->paymentTermsModel->where('trash', 0)->findAll();
           
            $sumBuyTable = 0;
            foreach ($good_buy_items as $good_buy_item) {
                $sumBuyTable = $sumBuyTable + ($good_buy_item->quantity * $good_buy_item->price);
            }
 
            $tax = ((int)$good_buys->tax / 100 *  $sumBuyTable);
            $discount = ((int)$good_buys->discount / 100 *  $sumBuyTable);
            $data = [
                'buyNumber' => $buyNumber,
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
                'db'        => $this->db,
            ];

            return view('modules/buys_manage_admin', $data);

        } else {
                $this->session->setFlashdata('message_type', 'warning');
            $this->session->setFlashdata('message_content', 'Data tidak ditemukan');
            return redirect()->to(base_url('/products/buys')); 
        }
    }

    public function products_purchase_add()
    {
        $goodBuysID = $this->request->getPost('good_buys_id');
        $good = $this->request->getPost('good');
        $qty = $this->request->getPost('qty');
        $price = $this->request->getPost('price');
        // dd($good);

        $goodBuys = $this->buysModel->where(['id' => $goodBuysID])->first();
        $goodData = $this->productModel->where(['id' => $good])->first();
        $data = [
            'buy_id' => $goodBuysID,
            'product_id' => $good,
            'quantity' => $qty,
            'price' => $price,
        ];
        $this->buyItemsModel->insert($data);
        $idGoodItem = $this->buyItemsModel->getInsertID();
        $this->productStockModel->insert([
            "product_id"    => $good,
            "warehouse_id" => $goodBuys->warehouse_id,
            "buy_item_id" => $idGoodItem,
            "date"  => date("Y-m-d"),
            "quantity"  => $qty,
        ]);
        // $this->stocksModel->insert($dataGoodStocks);

        $stockGood = $this->productModel->where(['id' => $good])->first();

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data <b>' . $stockGood->name . '</b> berhasil ditambahkan');
        return redirect()->to(base_url('products/buys/manage') . '/' . $goodBuysID);
    }

    public function products_purchase_add_admin()
    {
        $goodBuysID = $this->request->getPost('good_buys_id');
        $good = $this->request->getPost('good');
        $qty = $this->request->getPost('qty');
        $price = $this->request->getPost('price'); 

        $goodBuys = $this->buysModel->where(['id' => $goodBuysID])->first();
        $goodData = $this->productModel->where(['id' => $good])->first();
       
        $data = [
            'buy_id' => $goodBuysID,
            'product_id' => $good,
            'quantity' => $qty,
            'price' => $price,
        ];

        $this->buyItemsModel->insert($data);
        $idGoodItem = $this->buyItemsModel->getInsertID();
        $this->productStockModel->insert([
            "product_id"    => $good,
            "warehouse_id" => $goodBuys->warehouse_id,
            "buy_item_id" => $idGoodItem,
            "date"  => date("Y-m-d"),
            "quantity"  => $qty,
        ]);
        // $this->stocksModel->insert($dataGoodStocks);

        $stockGood = $this->productModel->where(['id' => $good])->first();

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data <b>' . $stockGood->name . '</b> berhasil ditambahkan');
        return redirect()->to(base_url('products/buy/manage') . '/' . $goodBuysID);
    } 

    public function products_purchase_delete($goodBuysId, $goodBuyItemsId)
    {
        $goodBuyItems = $this->buyItemsModel->find($goodBuyItemsId);
        if ($goodBuyItems) {
            $this->buyItemsModel->delete($goodBuyItemsId);
            $this->stocksModel->where(['buy_id' => $goodBuysId, 'buy_item_id' => $goodBuyItemsId])->delete();
            $this->session->setFlashdata('message_type', 'success');
            $this->session->setFlashdata('message_content', 'Data berhasil dihapus');

            $this->productStockModel->where("buy_item_id",$goodBuyItemsId)->delete();

            return redirect()->to(base_url('products/buys/manage/' . $goodBuysId));
        } else {
            $this->session->setFlashdata('message_type', 'danger');
            $this->session->setFlashdata('message_content', 'Data gagal dihapus');
            return redirect()->to(base_url('products/buys/manage/' . $goodBuysId));
        }
    }



    public function products_purchase_update()
    {
        $goodBuysId = $this->request->getPost('good_buys_id');
        $goodBuyItemId = $this->request->getPost('good_buys_item_id');
        $qty = $this->request->getPost('qty');
        $price = $this->request->getPost('price');
        $data = [
            'quantity' => $qty,
            'price' => $price,
        ];
        $stockItem = $this->stocksModel->where(['buy_id' => $goodBuysId, 'buy_item_id' => $goodBuyItemId])->first();
        $dataGoodStocks = [
            'debit' => $qty,
        ];
        $this->productStockModel->where("buy_item_id",$goodBuyItemId)->set([
            "quantity"  => $qty,
        ])->update();
        $this->productStockModel->where("buy_item_id", $goodBuyItemId)->set(["quantity"=>$qty])->update();
        $goodBuyItem = $this->buyItemsModel->where(['id' => $goodBuyItemId])->first();
        $goods = $this->productModel->where(['id' => $goodBuyItem->product_id])->first();
        // d($goodBuyItemId);
        // dd();
        $this->buyItemsModel->update($goodBuyItemId,  $data);
        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data <b>' . $goods->name . '</b> berhasil diubah');
        return redirect()->to(base_url('/products/buys/manage') . '/' . $goodBuysId);
        // dd($_POST);
    }
}
