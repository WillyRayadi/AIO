<?php

namespace App\Controllers;
helper('tools_helper');

class Audit extends BaseController
{ 
    protected $db; 
    protected $session; 
    protected $validation;  
    protected $adminModel;  
 
    private $buysModel;
    private $buyItemsModel;
    private $productCategoriesModel; 
    private $deliveryModel;
    private $productModel;
    private $productStocksModel;
    private $productRepairModel;
    private $productLocationModel;
    private $productStockModel;
    private $codeModel;
    private $customerModel;
    private $warehouseModel;
    private $promoModel;
    private $contactModel;
    private $saleModel;
    private $saleItemModel;
    private $tagModel;
    private $paymentModel;
    private $vehicleModel;
    private $addressModel;
    private $locationModel;
    private $alasanModel;
    private $warehouseTransferModel;
    private $warehouseTransfersItemsModel;
    private $paymentTermsModel;
    private $categoriesModel;


    public function __construct(){
        $this->session = \Config\Services::session(); 
        $this->db = \Config\Database::connect();
        $this->validation =  \Config\Services::validation(); 
        $this->adminModel = new \App\Models\Administrator(); 
        $this->buysModel = new \App\Models\Buy();
        $this->buyItemsModel = new \App\Models\BuyItem();
        $this->productCategoriesModel = new \App\Models\Category();
        $this->deliveryModel = new \App\Models\Delivery();
        $this->productModel = new \App\Models\Product();
        $this->productPriceModel = new \App\Models\ProductPrice();
        $this->productStocksModel = new \App\Models\Stock();
        $this->productRepairModel = new \App\Models\ProductRepair();
        $this->productLocationModel = new \App\Models\ProductLocation();
        $this->productStockModel = new \App\Models\ProductStock();
        $this->codeModel = new \App\Models\Code();
        $this->customerModel = new \App\Models\Customer();
        $this->warehouseModel = new \App\Models\Warehouse();
        $this->promoModel = new \App\Models\Promo();
        $this->contactModel = new \App\Models\Contact();
        $this->saleModel = new \App\Models\Sale();
        $this->saleItemModel = new \App\Models\SaleItem();
        $this->tagModel = new \App\Models\Tag();
        $this->paymentModel = new \App\Models\PaymentTerm();
        $this->vehicleModel = new \App\Models\Vehicle();
        $this->addressModel = new \App\Models\Address();
        $this->locationModel = new \App\Models\Location();
        $this->alasanModel = new \App\Models\Alasan();
        $this->warehouseTransfer = new \App\Models\WarehouseTransfer();
        $this->paymentTermsModel = new \App\Models\PaymentTerm();
        $this->categoriesModel = new \App\Models\Category();
        $this->warehouseTransfersItemsModel = new \App\Models\WarehouseTransfersItems();

        if($this->session->login_id == null){            
            $this->session->setFlashdata('msg', 'Maaf, Silahkan login terlebih dahulu!');
            header("location:".base_url('/'));
            exit();
        }else{
            if(config("Login")->loginRole != 8){
                header("location:".base_url('/dashboard'));
                exit();
            }
        }
    }
    
    public function report_sales(){
        return view('audit/report_sales');
    }

    public function report_produk(){
        return view('audit/report_produk');
    }

    public function product_buys(){
        $good_buys = $this->buysModel
        ->join('contacts', 'contacts.id = buys.supplier_id',"left")
        ->join('warehouses', 'warehouses.id = buys.warehouse_id',"left")
        ->select(['buys.number', 'buys.supplier_id', 'buys.payment_term_id', 'contacts.name as "contact_name"', 'warehouses.name as "warehouse_name"', 'buys.date', 'buys.discount', 'buys.tax', 'buys.notes', 'buys.id'])
        ->orderBy('buys.date', 'desc')
        ->get()
        ->getResultObject();

        $buy_terms = $this->paymentTermsModel->where(['trash' => 0])->findAll();
        $this->categoriesModel->findAll();

        $suppliers = $this->contactModel
        ->where("type",1)
        ->where("trash",0)
        ->orderBy("name","asc")
        ->findAll();

        $warehouses = $this->warehouseModel
        ->where("trash",0)
        ->orderBy("name","asc")
        ->findAll();

        $data = [
            'good_buys' => $good_buys,
            'buy_terms' => $buy_terms,
            'suppliers' => $suppliers,
            'warehouses' => $warehouses,
        ];
        
        // dd($data);
        return view('audit/buys', $data);
    }

    public function manage_product_buys($goodBuysID){ 
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
            'db'        => $this->db,
        ];

        return view('audit/buys_manage', $data);

    } else {
        $this->session->setFlashdata('message_type', 'warning');
        $this->session->setFlashdata('message_content', 'Data tidak ditemukan');
        return redirect()->to(base_url('audit_products_buys')); 
    }
    
    }

 

    public function sales_warehouse(){
        $allow_warehouses = !empty(cek_session($this->session->get('login_id'))['allow_warehouses']) ? cek_session($this->session->get('login_id'))['allow_warehouses'] : '"1","2","3","4","5","6","7","8","9","10"';
        
        $sales = $this->db->table('sale_items as a');
        $sales->select([
            'b.id',
            'b.status',
            'b.transaction_date',
            'e.name as admin_name', 
            'c.name as contact_name',   
            'b.number as sale_number',
        ]);
        $sales->join('sales as b', 'a.sale_id = b.id','left');
        $sales->join('contacts as c', 'b.contact_id = c.id','left');
        $sales->join('product_stocks as d', 'a.id = d.sale_item_id','left');
        $sales->join('administrators as e', 'b.admin_id = e.id','left');
        $sales->where('b.contact_id !=', NULL);
        $sales->where('b.payment_id !=', NULL);
        $sales->where("status >=",2);
        $sales->where("status !=",3);
        $sales->where("b.trash", 0);
        $sales->whereNotIn('d.warehouse_id', [$allow_warehouses]);
        $sales->orderBy('b.transaction_date','desc');
        $sales->groupBy('b.id');
        $sales = $sales->get();
        $sales = $sales->getResultObject();

        $data = ([
            'sales' => $sales,
            'db'  => $this->db,
        ]);
 
        return view("audit/sales_warehouse",$data); 
    } 

    public function sales_manage_warehouse($id){
        $sale = $this->saleModel->where("id",$id)->first(); 
        $deliveries = $this->deliveryModel->where('sale_id',$id)->get()->getFirstRow();

        if($deliveries == NULL)
 
        if($sale == NULL){ 
            $this->session->setFlashdata('message_type', 'error'); 
            $this->session->setFlashdata('message_content', 'Data tidak ditemukan'); 
            return redirect()->to(base_url('dashboard')); 
        } 
 
        if($sale->contact_id == NULL){
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', 'Data tidak ditemukan'); 
            return redirect()->to(base_url('dashboard')); 
        } 

        if($sale->payment_id == NULL){
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', 'Data tidak ditemukan'); 
            return redirect()->to(base_url('dashboard'));
        }

        $contact = $this->contactModel
        ->where("id",$sale->contact_id)
        ->first();

        $warehouse = $this->warehouseModel
        ->where("id",$sale->warehouse_id)
        ->first();

        $payment = $this->paymentModel
        ->where("id",$sale->payment_id)
        ->first();

        $vehicles = $this->vehicleModel
        ->where("trash",0)
        ->orderBy("brand","asc")
        ->findAll();
        
        $items = $this->saleItemModel
        ->where("sale_id",$id)
        ->findAll();

        $admin = $this->adminModel
        ->where("id",$sale->admin_id)
        ->first();

        $deliveries = $this->deliveryModel
        ->where("sale_id",$id)
        ->orderBy("sent_date","desc")
        ->orderBy("id","desc")
        ->findAll();

        $deliver = $this->deliveryModel
        ->where("sale_id",$id)
        ->orderBy("sent_date",'desc')
        ->orderBy('id','desc')->findAll();
        
        $saleItem = $this->saleItemModel
        ->orderBy('id','desc')
        ->first();

        $stocks = $this->productStockModel
        ->selectSum('quantity')
        ->where('product_id',$saleItem->product_id)
        ->first();

        $data = ([
            "db"    => $this->db,
            "contact"  => $contact,
            "admin"  => $admin,
            "warehouse"=> $warehouse,
            "payment"=> $payment,
            "sale"  => $sale,
            "items" => $items,
            "deliver" => $deliver,
            "vehicles" => $vehicles,
            "deliveries" => $deliveries,
            "saleItem" => $saleItem,
            "stocks" => $stocks,
        ]);

        return view("audit/sales_manage_warehouse",$data);
    }

    public function products_transfers(){
        $data_transfers = $this->db->table('warehouse_transfers')->orderBy('warehouse_transfers.id','desc')->get()->getResultObject();
        $warehouses = $this->warehouseModel->where("trash",0)->orderBy("warehouses.name","asc")->findAll();

        $admins = $this->adminModel
        ->where("role >=",2)
        ->where("role <=",3)
        ->where("active !=",0)
        ->orderBy("administrators.name","asc")
        ->findAll();

        $data = ([
            'db' => $this->db,
            'warehouses'  => $warehouses,
            'admins'   => $admins,
            'data_transfers' => $data_transfers,
        ]);


        return view('audit/products_transfers',$data);
    }

    public function products_transfers_manage($warehouse_transfers_id){
        $data_transfers = $this->db->table('warehouse_transfers_items')->get()->getFirstRow();
        $admins = $this->adminModel
        ->where("role >=",2)
        ->where("role <=",3)
        ->where("active !=",0)
        ->orderBy("administrators.name","asc")
        ->findAll();

        if($data_transfers != NULL) {
            $goods = $this->productModel->where(['trash' => 0])->orderBy('name','asc')->findAll();
            $warehouses = $this->warehouseModel->where('trash',0)->orderBy('warehouses.name','desc')->findAll();

            $good_transfers = $this->db->table('warehouse_transfers')
            ->join('administrators','warehouse_transfers.admin_id = administrators.id','left')
            ->select([
                'warehouse_transfers.id as id',
                'warehouse_transfers.admin_id',
                'warehouse_transfers.date as date',
                'administrators.name as admin_name',
                'warehouse_transfers.number as number',
                'warehouse_transfers.details as details',
                'warehouse_transfers.warehouse_to_id as warehouse_to_id',
                'warehouse_transfers.warehouse_from_id as warehouse_from_id',
            ])
            ->where('warehouse_transfers.id',$warehouse_transfers_id)
            ->get()->getFirstRow();

            $good_transfers_items = $this->warehouseTransfersItemsModel
            ->join('products','warehouse_transfers_items.product_id = products.id','left')
            ->select([
                'warehouse_transfers_items.id',
                'products.name as product_name',
                'warehouse_transfers_items.quantity',
                'warehouse_transfers_items.warehouse_transfers_id',
            ])
            ->where('warehouse_transfers_id',$warehouse_transfers_id)
            ->get()->getResultObject();

            $data = ([
                'products' => $goods,
                'db'    => $this->db,
                'admins'   => $admins,
                'warehouses'    => $warehouses,
                'good_transfers' => $good_transfers,
                'data_transfers' => $data_transfers,
                'good_transfers_items' => $good_transfers_items,
            ]);

            return view('audit/products_transfers_manage',$data);

        } else {
            $this->session->setFlashdata('message_type','warning');
            $this->session->setFlashdata('message_content','Data Tidak Ditemukan');
            return redirect()->to(base_url('audit/products_transfers'));
        }  
    }

  	public function delivery_orders(){
        $items = $this->saleItemModel
        ->findAll();

         $data = ([
           "items" => $items,
            "db"=> $this->db,
        ]);

        return view('audit/delivery_orders', $data);
    }

    public function products_locations(){
        $products = $this->productModel->where("trash",0)->orderBy("name","asc")->findAll();
        $warehouses = $this->warehouseModel
        ->where("trash", 0)
        ->orderBy("name", "asc")
        ->findAll();
        
        $categories = $this->productCategoriesModel
        ->where("trash", 0)
        ->orderBy("name", "asc")
        ->findAll();

        $codes = $this->codeModel
        ->where("trash", 0)
        ->orderBy("name", "asc")
        ->findAll();
        $prices = $this->productPriceModel
        ->orderBy("code", "asc")
        ->findAll();
       
        $data = ([
            "products"  => $products,
            "warehouses"          => $warehouses,
            "categories"          => $categories,
            "codes"          => $codes,
            "prices"          => $prices,
            "db"        => $this->db,
        ]);

        return view("audit/product_locations",$data);
    }

    public function products_all(){
        $goods = $this->productModel
            ->where("trash", 0)
            ->orderBy("name", "asc")
            ->get()
            ->getResultObject();
        $warehouses = $this->warehouseModel
            ->where("trash", 0)
            ->orderBy("name", "asc")
            ->findAll();
        $categories = $this->productCategoriesModel
            ->where("trash", 0)
            ->orderBy("name", "asc")
            ->findAll();

        $codes = $this->codeModel
            ->where("trash", 0)
            ->orderBy("name", "asc")
            ->findAll();
        
        $prices = $this->productPriceModel
            ->orderBy("code", "asc")
            ->findAll();

        $data = ([
            "db"             => $this->db,
            "products"       => $goods,
            "categories"       => $categories,
            "warehouses"       => $warehouses,
            "prices"       => $prices,
            "codes"       => $codes,
        ]);

        return view('audit/products_all', $data);
    }


    public function products(){
        $products = $this->productModel
        ->where("trash", 0)
        ->orderBy("name", "asc")
        ->get()
        ->getResultObject();        

        $data = ([
            "db"                => $this->db,
            "products"       => $products,
        ]);

        return view('audit/products', $data);
    }

    public function products_manage($id){
        $product = $this->productModel->where("id",$id)->where("trash",0)->first(); 
        $category = $this->productCategoriesModel->where("id",$product->category_id)->first();
        $code = $this->codeModel->where("id",$product->code_id)->first();

        // d($category);

        $categories = $this->productCategoriesModel
        ->where("trash", 0)
        ->orderBy("name", "asc")
        ->findAll();

        $codes = $this->codeModel
        ->where("trash", 0)
        ->orderBy("name", "asc")
        ->findAll();

        $prices = $this->productPriceModel
        ->orderBy("code", "asc")
        ->findAll();
        
        $thisFormula = $this->productPriceModel
        ->where("id",$product->price_id)
        ->first();

        $data = ([
            "product"   => $product,
            "thisCategory"   => $category,
            "thisCode"   => $code,
            "thisFormula"   => $thisFormula,
            "categories"   => $categories,
            "prices"   => $prices,
            "codes"   => $codes,
            "db"        => $this->db,
        ]);

        return view("audit/product_manage",$data);
    }

    public function price_approval(){ 
        $prices = $this->db->table("product_prices"); 
        $prices->select("product_prices.level as 'price_level'"); 
        $prices->select("product_prices.percentage as 'price_percentage'"); 
        $prices->select("products.id as 'product_id'");  
        $prices->select("products.name as 'product_name"); 
        $prices->select("products.price as 'product_price");
        $prices->select("products.sku_number as 'product_sku_number'"); 
        $prices->select("categories.name as 'code_name'");
        $prices->join("products","products_prices.product_id=producs.id","left");
        $prices->join("categories','products.categorY_id=categories.id","left");
        $prices->join("codes","products.code_id=codes.id","left"); 
        $prices->orderBy("product_prices.level","desc"); 
        $prices->orderBy("product_prices.date_created","desc"); 
        $prices->orderBy("product_prices.id","desc"); 
        $prices = $prices->get(); 
        $prices = $prices->getResultObject();  
        
        $data = ([ 
            "prices" => $prices,
        ]); 

        return view("audit/price_approval",$data); 
    } 
    
    public function sales(){ 
        $allow_warehouses = !empty(cek_session($this->session->get('login_id'))['allow_warehouses']) ? cek_session($this->session->get('login_id'))['allow_warehouses'] : '"1","2","3","4","5","6","7","8","9","10"';
        
        $sales = $this->db->table('sale_items as a'); 
        $sales->select([
            'b.id',
            'b.status',
            'b.transaction_date',
            'e.name as admin_name',
            'c.name as contact_name',   
            'b.number as sale_number',
        ]);
        $sales->join('sales as b', 'a.sale_id = b.id','left');
        $sales->join('contacts as c', 'b.contact_id = c.id','left');
        $sales->join('product_stocks as d', 'a.id = d.sale_item_id','left');
        $sales->join('administrators as e', 'b.admin_id = e.id','left');
        $sales->where('b.contact_id !=', NULL);
        $sales->where('b.payment_id !=', NULL);
        $sales->where('b.trash', 0);
        $sales->whereNotIn('d.warehouse_id', [$allow_warehouses]);
        $sales->orderBy('b.transaction_date','desc');
        $sales->groupBy('b.id');
        $sales = $sales->get();
        $sales = $sales->getResultObject();

        $data = ([
            'sales' => $sales,
            'db'  => $this->db,
        ]);

        return view("audit/sales",$data);
    }
 
    public function sales_manage($id){
        $sale = $this->saleModel->where("id",$id)->first(); 
    
        if($sale == NULL){ 
            $this->session->setFlashdata('message_type', 'error'); 
            $this->session->setFlashdata('message_content', 'Data tidak ditemukan'); 
            return redirect()->to(base_url('dashboard')); 
        } 

        $locations = $this->locationModel
        ->where("trash",0)
        ->orderBy("name","asc")
        ->findAll();

        $contacts = $this->contactModel
        ->where("type",2)
        ->where("trash",0)
        ->orderBy("name","asc")
        ->findAll();
        
        $contact = $this->contactModel
        ->orderBy('contacts.name', 'asc')
        ->where("id",$sale->contact_id)->first();

        $admin = $this->adminModel
        ->where("id",$sale->admin_id)->first();

        $warehouse = $this->warehouseModel
        ->where("id",$sale->warehouse_id)
        ->first();

        $payments = $this->paymentModel
        ->where("trash",0)
        ->orderBy("name","asc")
        ->findAll();

        $tags = $this->tagModel
        ->orderBy("name","asc")
        ->findAll();
        
        $products = $this->productModel
        ->where("trash", 0)
        ->orderBy("name", "asc")
        ->findAll();
        
        $items = $this->saleItemModel
        ->where("sale_id",$id)
        ->findAll();

        $promos = $this->promoModel
        ->where("date_start <=",date("Y-m-d"))
        ->where("date_end >=",date("Y-m-d"))
        ->findAll();

        $contact = $this->contactModel
        ->where("id",$sale->contact_id)
        ->first();

        $warehouses = $this->warehouseModel
        ->where("trash",0)
        ->orderBy("name","asc")
        ->findAll();

        $payment = $this->paymentModel
        ->where("id",$sale->payment_id)
        ->first();

        $data = ([
            "db"    => $this->db,
            "contacts"  => $contacts,
            "contact"  => $contact,
            "locations" => $locations,
            "admin"  => $admin,
            "warehouse"=> $warehouse,
            "payments"=> $payments,
            "tags"=> $tags,
            "products"=> $products,
            "sale"  => $sale,
            "items" => $items,
            "promos" => $promos,
            "thisContact"   => $contact,
            "payment" => $payment,
            "warehouses"          => $warehouses,
        ]);

        if($sale->status >= 5){
            return view("audit/sales_manage_fix",$data);
        }else{
            if($sale->admin_id == $this->session->login_id){
                return view("audit/sales_own_manage",$data);            
            }else{
                if($sale->contact_id == NULL){
                    $this->session->setFlashdata('message_type', 'error');
                    $this->session->setFlashdata('message_content', 'Data tidak ditemukan');
                    
                    return redirect()->to(base_url('dashboard'));
                }
                if($sale->payment_id == NULL){
                    $this->session->setFlashdata('message_type', 'error');
                    $this->session->setFlashdata('message_content', 'Data tidak ditemukan');
                    
                    return redirect()->to(base_url('dashboard'));
                }
                return view("audit/sales_manage",$data);
            }
        }
    } 
 }