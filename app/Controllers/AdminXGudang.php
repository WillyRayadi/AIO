<?php

namespace App\Controllers;

class AdminXGudang extends BaseController
{
    protected $db;
    protected $session;
    protected $adminModel;
    protected $validation;

    private $productCategoriesModel;
    private $productModel;
    private $productPriceModel;
    private $productPriceFormulaModel;
    private $productPriceVariableModel;
    private $productStocksModel;
    private $productRepairModel;
    private $productReturnModel;
    private $productDisplayModel;
    private $productLocationModel;
    private $productStockModel;
    private $codeModel;
    private $customerModel;
    private $warehouseModel;
    private $promoModel;
    private $promoTypeModel;
    private $contactModel;
    private $buyModel;
    private $buyItemModel;
    private $saleModel;
    private $saleItemModel;
    private $saleReturModel;
    private $saleReturnItemModel;
    private $tagModel;
    private $paymentModel;
    private $vehicleModel;
    private $warehouseTransferModel;
    private $warehouseTransfersItemsModel;

    public function __construct(){
        $this->session = \Config\Services::session();

        $this->db = \Config\Database::connect();
        $this->validation =  \Config\Services::validation();
        
        $this->adminModel = new \App\Models\Administrator();

        $this->productCategoriesModel = new \App\Models\Category();
        $this->productModel = new \App\Models\Product();
        $this->productPriceModel = new \App\Models\ProductPrice();
        $this->productPriceFormulaModel = new \App\Models\ProductPriceFormula();
        $this->productPriceVariableModel = new \App\Models\ProductPriceVariable();
        $this->productStocksModel = new \App\Models\Stock();
        $this->productRepairModel = new \App\Models\ProductRepair();
        $this->productReturnModel = new \App\Models\ProductReturn();
        $this->productDisplayModel = new \App\Models\ProductDisplay();
        $this->productLocationModel = new \App\Models\ProductLocation();
        $this->productStockModel = new \App\Models\ProductStock();
        $this->codeModel = new \App\Models\Code();
        $this->customerModel = new \App\Models\Customer();
        $this->warehouseModel = new \App\Models\Warehouse();
        $this->promoModel = new \App\Models\Promo();
        $this->promoTypeModel = new \App\Models\PromoType();
        $this->contactModel = new \App\Models\Contact();
        $this->buyModel = new \App\Models\Buy();
        $this->buyItemModel = new \App\Models\BuyItem();
        $this->saleModel = new \App\Models\Sale();
        $this->saleItemModel = new \App\Models\SaleItem();
        $this->saleReturModel = new \App\Models\saleRetur();
        $this->saleReturnItemModel = new \App\Models\saleReturnItem();
        $this->tagModel = new \App\Models\Tag();
        $this->paymentModel = new \App\Models\PaymentTerm();
        $this->vehicleModel = new \App\Models\Vehicle();
        $this->warehouseTransferModel = new \App\Models\WarehouseTransfer();
        $this->warehouseTransfersItemsModel = new \App\Models\WarehouseTransfersItems();

        if($this->session->login_id == null){            
            $this->session->setFlashdata('msg', 'Maaf, Silahkan login terlebih dahulu!');
            header("location:".base_url('/'));
            exit();
        }else{
            if(config("Login")->loginRole != 1){
                if(config("Login")->loginRole != 2){
                if(config("Login")->loginRole != 3){
                if(config("Login")->loginRole != 6){
                    if(config("Login")->loginRole != 7){
                        header("location:".base_url('/dashboard'));
                        exit();
                    }
                }
              }
            }
          }
        }
      }
      
    public function product_transfer(){
        $data_transfers = $this->warehouseTransferModel->orderBy('warehouse_transfers.id','desc')->findAll();
        $warehouses = $this->warehouseModel->where("trash",0)->orderBy("warehouses.name","asc")->findAll();
        
        $admins = $this->adminModel
        ->where("active !=",0)
        ->orderBy("administrators.name","asc")
        ->findAll();

        $data = ([
            'db' => $this->db,
            'admins'   => $admins,
            'warehouses'  => $warehouses,
            'data_transfers' => $data_transfers,
        ]);

        return view('modules/products_transfers', $data);
    }

    public function product_repairs(){
        $products = $this->productModel->where("trash",0)->orderBy("name","asc")->findAll();
        $customers = $this->contactModel
        ->where("type",2)
        ->where("trash",0)
        ->orderBy("name","asc")
        ->findAll();

        $warehouses = $this->warehouseModel->where("trash",0)->orderBy("name","asc")->findAll();

        $repairs = $this->db->table("product_repairs");
        $repairs->select("product_repairs.id as 'repair_id'");
        $repairs->select("product_repairs.date as 'repair_date'");
        $repairs->select("product_repairs.details as 'repair_details'");
        $repairs->select("product_repairs.quantity as 'repair_qty'");
        $repairs->select("products.name as 'product_name'");
        $repairs->select("products.unit as 'product_unit'");
        $repairs->select("contacts.name as 'contact_name'");
        $repairs->select("contacts.phone as 'contact_phone'");
        $repairs->select("contacts.address as 'contact_address'");
        $repairs->select("warehouses.name as 'warehouse_name'");
        $repairs->join("products","product_repairs.product_id=products.id","left");
        $repairs->join("contacts","product_repairs.contact_id=contacts.id","left");
        $repairs->join("warehouses","product_repairs.warehouse_id=warehouses.id","left");
        $repairs->orderBy("product_repairs.date","desc");
        $repairs->orderBy("product_repairs.id","desc");

        $repairs = $repairs->get();
        $repairs = $repairs->getResultObject();

        $data = ([
            "products" => $products,
            "warehouses" => $warehouses,
            "customers" => $customers,
            "repairs"=>$repairs,
        ]);

        return view("modules/product_repairs",$data);
    }
    
    public function product_repairs_add(){
        $customer = $this->request->getPost('customer');
        $product = $this->request->getPost('product');
        $warehouse = $this->request->getPost('warehouse');
        $date = $this->request->getPost('date');
        $qty = $this->request->getPost('qty');
        $details = $this->request->getPost('details');

        $this->productRepairModel->insert([
            "product_id"    => $product,
            "contact_id" => $customer,
            "warehouse_id" => $warehouse,
            "date" => $date,
            "quantity" => $qty,
            "details" => $details
        ]);
        $idRepairItem = $this->productRepairModel->getInsertID();
        $qty_stock = 0 - $qty;
        $this->productStockModel->insert([
            "product_id"    => $product,
            "warehouse_id" => $warehouse,
            "product_repair_id" => $idRepairItem,
            "date"  => date("Y-m-d"),
            "quantity"  => $qty_stock,
        ]);

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data perbaikan (service) produk berhasil ditambah');

        return redirect()->to(base_url('products/repairs'));
    }
    
    public function product_repairs_delete($id){
        $this->productRepairModel->delete($id);

        $this->productStockModel->where("product_repair_id",$id)->delete();
        
        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data perbaikan (service) produk berhasil dihapus');

        return redirect()->to(base_url('products/repairs'));
    }
    
    public function product_repairs_ajax_edit(){
        $id = $this->request->getPost("id");
        $repair = $this->productRepairModel->where("id",$id)->first();
        echo json_encode($repair);
    }
    public function product_repairs_save(){
        $id = $this->request->getPost("id");
        $customer = $this->request->getPost('customer');
        $product = $this->request->getPost('product');
        $warehouse = $this->request->getPost('warehouse');
        $date = $this->request->getPost('date');
        $qty = $this->request->getPost('qty');
        $details = $this->request->getPost('details');

        $this->productRepairModel->where("id",$id)->set([
            "product_id"    => $product,
            "contact_id" => $customer,
            "warehouse_id" => $warehouse,
            "date" => $date,
            "quantity" => $qty,
            "details" => $details
        ])->update();

        $qty_stock = 0 - $qty;
        $this->productStockModel->where("product_repair_id",$id)->set([
            "product_id"    => $product,
            "warehouse_id" => $warehouse,
            "quantity"  => $qty_stock,
        ])->update();

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data perbaikan (service) produk berhasil disimpan');

        return redirect()->to(base_url('products/repairs'));
    }

    public function product_displays(){
        $products = $this->productModel->where("trash",0)->orderBy("name","asc")->findAll();        
        $warehouses = $this->warehouseModel->where("trash",0)->orderBy("name","asc")->findAll();

        $displays = $this->db->table("product_displays");
        $displays->select("product_displays.id as 'display_id'");
        $displays->select("product_displays.date as 'display_date'");
        $displays->select("product_displays.quantity as 'display_qty'");
        $displays->select("products.name as 'product_name'");
        $displays->select("products.unit as 'product_unit'");
        $displays->select("warehouses.name as 'warehouse_name'");
        $displays->join("products","product_displays.product_id=products.id","left");
        $displays->join("warehouses","product_displays.warehouse_id=warehouses.id","left");
        $displays->orderBy("product_displays.date","desc");
        $displays->orderBy("product_displays.id","desc");

        $displays = $displays->get();
        $displays = $displays->getResultObject();

        $data = ([
            "products" => $products,
            "warehouses" => $warehouses,
            "displays"=>$displays,
        ]);
        
        if($this->session->login_id == 83 || $this->session->login_id == 9 || $this->session->login_id == 12){
            return view("modules/product_displays",$data);
        }else{
            return redirect()->to(base_url("dashboard"));
        }

        
    }
    public function product_displays_add(){
        
        if($this->session->login_id == 83 || $this->session->login_id == 9 || $this->session->login_id == 12){
      
            $product = $this->request->getPost('product');
            $warehouse = $this->request->getPost('warehouse');
            $date = $this->request->getPost('date');
            $qty = $this->request->getPost('qty');
            $details = $this->request->getPost('details');
    
            $this->productDisplayModel->insert([
                "product_id"    => $product,
                "warehouse_id" => $warehouse,
                "date" => $date,
                "quantity" => $qty,
                "details" => $details
            ]);
            $idDisplayItem = $this->productDisplayModel->getInsertID();
            $qty_stock = 0 - $qty;
            $this->productStockModel->insert([
                "product_id"    => $product,
                "warehouse_id" => $warehouse,
                "product_display_id" => $idDisplayItem,
                "date"  => date("Y-m-d"),
                "quantity"  => $qty_stock,
            ]);
    
            $this->session->setFlashdata('message_type', 'success');
            $this->session->setFlashdata('message_content', 'Data display produk berhasil ditambah');
    
            return redirect()->to(base_url('products/stokOpname'));
        
        }else{
            return redirect()->to(base_url("dashboard"));
        }
    }
    public function product_displays_delete($id){
        
        if($this->session->login_id == 83 || $this->session->login_id == 9 || $this->session->login_id == 12){
        
            $this->productDisplayModel->delete($id);
    
            $this->productStockModel->where("product_display_id",$id)->delete();
            
            $this->session->setFlashdata('message_type', 'success');
            $this->session->setFlashdata('message_content', 'Data display produk berhasil dihapus');
    
            return redirect()->to(base_url('products/stokOpname'));
            
        }else{
            return redirect()->to(base_url("dashboard"));
        }
    }
    public function product_displays_ajax_edit(){
        $id = $this->request->getPost("id");
        $display = $this->productDisplayModel->where("id",$id)->first();
        echo json_encode($display);
    }
    public function product_displays_save(){
        
        if($this->session->login_id == 83 || $this->session->login_id == 9 || $this->session->login_id == 12){
            
            $id = $this->request->getPost("id");
            $product = $this->request->getPost('product');
            $warehouse = $this->request->getPost('warehouse');
            $date = $this->request->getPost('date');
            $qty = $this->request->getPost('qty');
            $details = $this->request->getPost('details');
    
            $this->productDisplayModel->where("id",$id)->set([
                "product_id"    => $product,
                "warehouse_id" => $warehouse,
                "date" => $date,
                "quantity" => $qty,
                "details" => $details
            ])->update();
    
            $qty_stock = 0 - $qty;
            $this->productStockModel->where("product_display_id",$id)->set([
                "product_id"    => $product,
                "warehouse_id" => $warehouse,
                "quantity"  => $qty_stock,
            ])->update();
    
            $this->session->setFlashdata('message_type', 'success');
            $this->session->setFlashdata('message_content', 'Data display produk berhasil disimpan');
    
            return redirect()->to(base_url('products/stokOpname'));
            
        }else{
            return redirect()->to(base_url("dashboard"));
        }
    }

    public function product_stocks(){
        $stocks = $this->db->table("product_stocks");
        $stocks->select("product_stocks.id as 'stock_id'");
        $stocks->select("product_stocks.qty_recorded as 'stock_qty_recorded'");
        $stocks->select("product_stocks.qty_real as 'stock_qty_real'");
        $stocks->select("product_stocks.quantity as 'stock_qty'");
        $stocks->select("product_stocks.date as 'stock_date'");
        $stocks->select("product_stocks.details as 'stock_details'");
        $stocks->select("products.name as 'product_name'");
        $stocks->select("products.unit as 'product_unit'");
        $stocks->select("warehouses.name as 'warehouse_name'");
        $stocks->join("products","product_stocks.product_id=products.id","left");
        $stocks->join("warehouses","product_stocks.warehouse_id=warehouses.id","left");
        $stocks->orderBy("product_stocks.date","desc");
        $stocks->orderBy("product_stocks.id","desc");
        $stocks->where("sale_item_id",NULL);
        $stocks->where("buy_item_id",NULL);

        $stocks = $stocks->get();
        $stocks = $stocks->getResultObject();

        $data = ([
            "stocks" => $stocks,
        ]);

        return view("modules/product_stocks",$data);
    }
    public function product_stocks_add(){
        $products = $this->productModel->where("trash",0)->orderBy("name","asc")->findAll();
        $warehouses = $this->warehouseModel->where("trash",0)->orderBy("name","asc")->findAll();

        $data = ([
            "products"   => $products,
            "warehouses" => $warehouses,
        ]);

        return view("modules/product_stocks_add",$data);
    }
    public function product_stocks_add_ajax_qty_recorded(){
        $product = $this->request->getPost('product');
        $warehouse = $this->request->getPost('warehouse');

        $stocks = $this->db->table("product_stocks");
        $stocks->selectSum("quantity");
        $stocks->where("product_id",$product);
        $stocks->where("warehouse_id",$warehouse);

        $stocks = $stocks->get();
        $stocks = $stocks->getFirstRow();

        if($stocks->quantity <= 0){
            echo "0";
        }else{
            echo $stocks->quantity;
        }
    }
    
    public function products_buys_items_ajax(){
        $buys = $this->request->getPost('buys');
        $product = $this->request->getPost('product');
        
        $items = $this->db->table('buy_items');
        $items->select('quantity');
        $items->where('buy_items.buy_id', $buys);
        $items->where('buy_items.product_id',$product);
        $items = $items->get();
        $items = $items->getFirstRow();
        
        if($items->quantity <= 0){
            echo "0";
        }else{
            echo $items->quantity;
        }
    }
    
    public function product_stocks_insert(){
        $warehouse = $this->request->getPost('warehouse');
        $product = $this->request->getPost('product');
        $qty_recorded = $this->request->getPost('qty_recorded');
        $qty_real = $this->request->getPost('qty_real');
        $qty_custom = $this->request->getPost('qty_custom');
        $date = $this->request->getPost('date');
        $details = $this->request->getPost('details');

        $this->productStockModel->insert([
            "warehouse_id"    => $warehouse,
            "product_id"    => $product,
            "qty_recorded"          => $qty_recorded,
            "qty_real"          => $qty_real,
            "quantity"          => $qty_custom,
            "details"          => $details,
            "date"          => $date,
        ]);

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data penyesuaian persediaan produk berhasil ditambah');

        return redirect()->to(base_url('products/stocks'));
    }
    public function product_stocks_delete($id){
        $this->productStockModel->delete($id);

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data penyesuaian persediaan produk berhasil dihapus');

        return redirect()->to(base_url('products/stocks'));
    }

    public function product_locations(){
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
            "db"=> $this->db,
        ]);

        return view("modules/product_locations",$data);
    }
    
    public function product_location_manage($id){
        $product = $this->productModel->where("id",$id)->where("trash",0)->first();

        if($product == NULL){
            return redirect()->to(base_url('dashboard'));
        }

        $code = $this->codeModel->where("id",$product->code_id)->first();
        $category = $this->productCategoriesModel->where("id",$product->category_id)->first();

        $warehouses = $this->warehouseModel
            ->where("trash", 0)
            ->orderBy("name", "asc")
            ->findAll();

        $stocks = $this->db->table("product_stocks");
        $stocks->selectSum("quantity");
        $stocks->where("product_id",$id);
    
        $stocks = $stocks->get();
        $stocks = $stocks->getFirstRow();
    
        if($stocks->quantity <= 0){
            $thisStock = 0;
        }else{
            $thisStock =  $stocks->quantity;
        }

        $data = ([
            "product"   => $product,
            "stock"   => $thisStock,
            "code"          => $code,
            "category" =>   $category,
            "warehouses" => $warehouses,
            "db"          => $this->db,
        ]);

        return view("modules/product_location_manage",$data);
    }
    public function product_location_save(){
        $product = $this->request->getPost('product');
        $warehouse = $this->request->getPost('warehouse');
        $qty = $this->request->getPost('qty');

        $stocks = $this->db->table("product_stocks");
        $stocks->selectSum("quantity");
        $stocks->where("product_id",$product);
    
        $stocks = $stocks->get();
        $stocks = $stocks->getFirstRow();
    
        if($stocks->quantity <= 0){
            $thisStock = 0;
        }else{
            $thisStock =  $stocks->quantity;
        }

        $countQty = count($qty);

        $sumQty = 0;
        for($q = 0; $q <= $countQty-1; $q++){
            $sumQty += $qty[$q];
        }

        if($sumQty > $thisStock){
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', 'Data gagal disimpan, melebihi persediaan aktif');

            return redirect()->to(base_url('product/'.$product.'/location/manage'));
        }

        $countWarehouses = count($warehouse);
        
        for($w = 0; $w <= $countWarehouses-1; $w++){
            $existWarehouse = $this->productLocationModel
            ->where("product_id",$product)
            ->where("warehouse_id",$warehouse[$w])->first();
            
            if($existWarehouse != NULL){
                $this->productLocationModel
                ->where("product_id",$product)
                ->where("warehouse_id",$warehouse[$w])
                ->set(["quantity"=>$qty[$w]])->update();
            }else{
                $this->productLocationModel
                ->insert([
                    "warehouse_id"=>$warehouse[$w],
                    "product_id"   => $product,
                    "quantity"          => $qty[$w],
                ]);
            }
        }

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data lokasi produk berhasil disimpan');

        return redirect()->to(base_url('product/'.$product.'/location/manage'));
    }

    public function product_returns(){
        $stocks = $this->saleReturModel
        ->select([
            'return_sales.id',
            'sales.contact_id',
            'sales.id as sale_id',
            'return_sales.alasan',
            'sales.number as sale_number',
            'contacts.name as contact_name',
            'return_sales.date as retur_date',
            'return_sales.number as retur_number',
            'return_sales.admin_id as retur_admin',         
        ])
        ->join('sales','return_sales.sale_id = sales.id', 'left')
        ->join('contacts', 'sales.contact_id = contacts.id', 'left')
        ->orderBy('return_sales.id','desc')
        ->get()->getResultObject();

        $data = ([ 
            "db" => $this->db,
            "stocks" => $stocks,
        ]); 

        return view("modules/product_returns",$data);
    }
    
    public function product_return_manage($id){
        $data_retur = $this->saleReturModel->where(['return_sales.id' => $id])->first();
        
        if($data_retur != NULL) {
            $goods = $this->productModel->where('trash',0)->orderBy('products.name','asc')->findAll();
            $warehouses = $this->warehouseModel->where('trash', 0)->orderBy('warehouses.name','asc')->findAll();
            
            $good_retur = $this->saleReturModel
            ->select([
                'return_sales.id',
                'sales.contact_id','alasan',
                'sales.number as sales_number',
                'return_sales.date as retur_date',
                'administrators.name as admin_name',
                'return_sales.number as retur_number',
            ])
            ->join('sales', 'return_sales.sale_id = sales.id', 'left')
            ->join('administrators', 'return_sales.admin_id = administrators.id', 'left')
            ->where('return_sales.id', $id)->get()->getFirstRow();
            
            $sales = $this->saleModel->orderBy('sales.id','desc')->get()->getFirstRow();
            
            $items = $this->saleItemModel
            ->select([
                'sale_items.id',
                'sale_items.quantity',
                'sale_items.product_id',
                'products.name as product_name',    
            ])
            ->join('products', 'sale_items.product_id = products.id', 'left')
            ->where('sale_items.sale_id', $data_retur->sale_id)
            ->orderBy('sale_items.id', 'desc')->get()->getResultObject();
            
            $retur_item = $this->saleReturnItemModel
            ->select([
                'return_item.id',
                'return_item.quantity',
                'return_item.retur_id',
                'return_item.sale_item_id',
                'products.name as product_name',
                'warehouses.name as warehouse_name',
            ])
            ->join('products', 'return_item.product_id = products.id', 'left')
            ->join('warehouses', 'return_item.warehouse_id = warehouses.id','left')
            ->where('return_item.retur_id', $id)
            ->get()->getResultObject();
            
            $data = ([
                'db' => $this->db,
                'goods' => $goods,
                'warehouses' => $warehouses,
                'good_retur' => $good_retur,
                'sales' => $sales,
                'items' => $items,
                'retur_item' => $retur_item,
            ]);
            
            return view('modules/product_return_manage', $data);
            
        }else{
            $this->session->setFlashdata('message_type', 'success');
            $this->session->setFlashdata('message_content', 'Data tidak ditemukan');
            return redirect()->to(base_url('products/returns'));
        }
        
    }
    
    public function product_returns_ajax_sale_items(){
        $id = $this->request->getPost("id");

        $items = $this->db->table("sale_items");
        $items->select("sale_items.id as sale_item_id");
        $items->select("products.name as product_name");
        $items->join('products','sale_items.product_id = products.id','left');
        $items->where("sale_items.sale_id",$id);
        $items = $items->get();
        $items = $items->getResultObject();

        echo"<option value=''>--Pilih Item Yang Ingin Diretur--</option>";
        foreach($items as $item){
            echo"<option value='".$item->sale_item_id."'>".$item->product_name."</option>";
        }
    }
    
    public function product_returns_ajax_buy_items(){
        $id = $this->request->getPost("id");

        $items = $this->db->table("buy_items");
        $items->select("buy_items.id as buy_item_id");
        $items->select("products.name as product_name");
        $items->join("products","buy_items.product_id=products.id","left");
        $items->where("buy_items.buy_id",$id);
        $items = $items->get();
        $items = $items->getResultObject();

        echo"<option value=''>--Pilih Item Untuk Mendapatkan Kuantitas--</option>";
        foreach($items as $item){
            echo"<option value='".$item->buy_item_id."'>".$item->product_name."</option>";
        }
    }
    public function product_returns_ajax_buy_item_qty(){
        $id = $this->request->getPost("id");
        $item = $this->buyItemModel->where("id",$id)->first();

        echo $item->quantity;
    }
    
    public function product_returns_ajax_sale_item_qty(){
        $id = $this->request->getPost("id");
        $item = $this->saleItemModel->where('id',$id)->first();

        echo $item->quantity;
    }
    
    public function product_returns_add(){
        // $sale = $this->request->getPost('sale');
        $buy = $this->request->getPost('buy');
        $item = $this->request->getPost('item');
        $warehouse = $this->request->getPost('warehouse');
        $date = $this->request->getPost('date');
        $quantity = $this->request->getPost('quantity');
        $details = $this->request->getPost('details');

        $thisItem = $this->buyItemModel->where("id",$item)->first();

        if($quantity > $thisItem->quantity){
            $this->session->setFlashdata('message_type', 'warning');
            $this->session->setFlashdata('message_content', 'Maaf, kuantitas melebihi data item');

            return redirect()->to(base_url('products/returns'));
        }

        $this->productReturnModel->insert([
            "buy_id"   => $buy,
            "buy_item_id"=>$item,
            "warehouse_id"=> $warehouse,
            "product_id" => $thisItem->product_id,
            "date" => $date,
            "quantity"          => $quantity,
            "details"          => $details,
        ]);

        $idReturnItem = $this->productReturnModel->getInsertID();
        $qty_stock = 0 - $quantity;
        $this->productStockModel->insert([
            "product_id"    => $thisItem->product_id,
            "warehouse_id" => $warehouse,
            "product_return_id" => $idReturnItem,
            "date"  => date("Y-m-d"),
            "quantity"  => $qty_stock,
        ]);

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data return produk berhasil ditambah');

        return redirect()->to(base_url('products/returns'));
    }
    public function product_returns_delete($id){
        $this->productReturnModel->delete($id);

        $this->productStockModel->where("product_return_id",$id)->delete();
        
        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data return produk berhasil dihapus');

        return redirect()->to(base_url('products/returns'));
    }
    public function product_returns_ajax_edit(){
        $id = $this->request->getPost("id");

        $return = $this->db->table("product_returns");
        $return->select("product_returns.id as return_id");
        $return->select("product_returns.date as return_date");
        $return->select("product_returns.details as return_details");
        $return->select("product_returns.quantity as return_quantity");
        $return->select("buys.number as buy_number");
        $return->select("buy_items.quantity as buy_item_quantity");
        $return->select("products.name as product_name");
        $return->select("products.unit as product_unit");
        $return->select("warehouses.name as warehouse_name");
        $return->join("buys","product_returns.buy_id=buys.id","left");
        $return->join("buy_items","product_returns.buy_item_id=buy_items.id","left");
        $return->join("products","product_returns.product_id=products.id","left");
        $return->join("warehouses","product_returns.warehouse_id=warehouses.id","left");
        $return->orderBy("product_returns.date","desc");
        $return->orderBy("product_returns.id","desc");
        $return->where("product_returns.id",$id);
        $return = $return->get();
        $return = $return->getFirstRow();

        // print_r($return);

        echo json_encode($return);
    }
    public function product_returns_save(){
        $id = $this->request->getPost('id');
        $date = $this->request->getPost('date');
        $quantity = $this->request->getPost('quantity');
        $details = $this->request->getPost('details');

        $this->productReturnModel
        ->where("id",$id)
        ->set([
            "date" => $date,
            "quantity"          => $quantity,
            "details"          => $details,
        ])->update();

        $qty_stock = 0 - $quantity;
        $this->productStockModel
        ->where("product_return_id",$id)
        ->set([
            "date" => $date,
            "quantity"  => $qty_stock,
        ])->update();

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data return produk berhasil disimpan');

        return redirect()->to(base_url('products/returns'));
    }

    public function products_available()
    {
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
            "db"                => $this->db,
            "products"       => $goods,
            "categories"       => $categories,
            "warehouses"       => $warehouses,
            "prices"       => $prices,
            "codes"       => $codes,
        ]);

        return view('modules/products_available', $data);
    }
    
    public function products_warehouse()
    {
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
            "db"                => $this->db,
            "products"       => $goods,
            "categories"       => $categories,
            "warehouses"       => $warehouses,
            "prices"       => $prices,
            "codes"       => $codes,
        ]);

        return view('modules/products_warehouse', $data);
    }

    public function products_transfers(){
        $data_transfers = $this->warehouseTransferModel->orderBy('warehouse_transfers.id','desc')->findAll();
        $warehouses = $this->warehouseModel->where("trash",0)->orderBy("warehouses.name","asc")->findAll();
        
        $admins = $this->adminModel
        ->where("active !=",0)
        ->orderBy("administrators.name","asc")
        ->findAll();

        $data = ([
            'db' => $this->db,
            'admins'   => $admins,
            'warehouses'  => $warehouses,
            'data_transfers' => $data_transfers,
        ]);

        return view('modules/products_transfers', $data);
    }

    public function products_transfers_insert_data_awal(){
        $data_transfers_awal = $this->db->table('warehouse_transfers');
        $data_transfers_awal->selectMax('id');
        $data_transfers_awal = $data_transfers_awal->get();
        $data_transfers_awal = $data_transfers_awal->getFirstRow();

        $data_transfers_awal = $data_transfers_awal->id;

        $no_doc = $data_transfers_awal + 1;

        $number_document = "TF/".date("y")."/".date("m")."/".$no_doc;

        $date = $this->request->getPost('date');
        $number = $this->request->getPost('number');
        $details = $this->request->getPost('details');
        $admin_id = $this->request->getPost('admin_id');
        $to_warehouse = $this->request->getPost('to_warehouse');
        $from_warehouse = $this->request->getPost('from_warehouse');

        $this->warehouseTransferModel->insert([
            "date"  => $date,
            "number"   => $number_document,
            "details"  => $details,
            "admin_id" => $admin_id,
            "warehouse_to_id" => $to_warehouse,
            "warehouse_from_id" => $from_warehouse,
        ]);

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data transfer barang berhasil ditambah');

        return redirect()->to(base_url('products/transfers'));
    }

    public function product_transfers_manage($warehouse_transfers_id){
        $data_transfers = $this->warehouseTransferModel->get()->getFirstRow();

        $users = $this->adminModel->select(["id", "role"])->where("id", $this->session->login_id)->first();
        
        if ($data_transfers != NULL) {
            $goods = $this->productModel->where(['trash' => 0])->orderBy('name','asc')->findAll();
            $warehouses = $this->warehouseModel->where('trash',0)->orderBy('warehouses.name','desc')->findAll();

            $good_transfers = $this->warehouseTransferModel
            ->join('administrators','warehouse_transfers.admin_id = administrators.id','left')
            ->select([
                'warehouse_transfers.id as id',
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
                'warehouses'    => $warehouses,
                'users' => $users,
                'good_transfers' => $good_transfers,
                'data_transfers' => $data_transfers,
                'good_transfers_items' => $good_transfers_items,
            ]);

            return view('modules/product_transfers_manage',$data);

        } else {
            $this->session->setFlashdata('message_type','warning');
            $this->session->setFlashdata('message_content','Data Tidak Ditemukan');
            return redirect()->to(base_url('product/transfers'));
    
        }
        
    }

    public function products_transfers_items(){
    $date = $this->request->getPost('date');
    $details = $this->request->getPost('details');
    $quantity = $this->request->getPost('quantity');
    $product_id = $this->request->getPost('product_id');
    $to_warehouse = $this->request->getPost('to_warehouse');
    $from_warehouse = $this->request->getPost('from_warehouse');
    $warehouse_transfers_id = $this->request->getPost('warehouse_transfers_id');

    $goodTransfers = $this->warehouseTransferModel->where(['id' => $warehouse_transfers_id])->first();
    $goodData = $this->productModel->where(['id' => $product_id])->first();

    $this->warehouseTransfersItemsModel
    ->insert([
        'quantity' => $quantity,
        'product_id' => $product_id,
        'warehouse_transfers_id' => $warehouse_transfers_id,
    ]);

    $idGoodItem = $this->warehouseTransfersItemsModel->getInsertID();
    $this->productStockModel
    ->insert([
        'date' => $date,
        'details' => $details,
        'product_id' => $product_id,
        'quantity' => (0 - $quantity),
        'warehouse_id' => $from_warehouse,
        'warehouse_transfer_id' => $idGoodItem, 
    ]);

    $this->productStockModel
    ->insert([
        'date' => $date,
        'details' => $details,
        'quantity' => $quantity,
        'product_id' => $product_id,
        'warehouse_id' => $to_warehouse,
        'warehouse_transfer_id' => $idGoodItem,
    ]);

    $stockGood = $this->productModel->where(['id' => $product_id])->first(); 
        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data <b>' . $stockGood->name . '</b> berhasil ditambahkan');
    return redirect()->to(base_url('products/transfers/manage') . '/' . $warehouse_transfers_id);
    } 

    public function product_transfers_delete($id)
    {
        $items = $this->warehouseTransfersItemsModel->where('warehouse_transfers_id',$id)->first();
        
        $this->warehouseTransferModel->delete($id);
        $this->warehouseTransfersItemsModel->where('warehouse_transfers_id',$id)->delete();
        $this->productStockModel->where("warehouse_transfer_id", $items->id)->delete();
        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data transfer barang berhasil dihapus');

        return redirect()->to(base_url('products/transfers'));
    }

    public function product_transfers_delete_items($id, $warehouse_items){
        $goodTransfersItems = $this->warehouseTransfersItemsModel->find($warehouse_items);
  
        if ($goodTransfersItems) {
            $this->warehouseTransfersItemsModel->delete($warehouse_items);
            $this->session->setFlashdata('message_type', 'success');
            $this->session->setFlashdata('message_content', 'Data berhasil dihapus'); 
            $this->productStockModel->where("warehouse_transfer_id",$warehouse_items)->delete(); 
            return redirect()->to(base_url('products/transfers/manage/' . $id));

        } else {
            $this->session->setFlashdata('message_type', 'danger');
            $this->session->setFlashdata('message_content', 'Data gagal dihapus');
            return redirect()->to(base_url('products/transfers/manage/' . $id));
        }

    }  



  public function sales(){
        $sales = $this->saleModel
        ->where("contact_id !=",NULL)
        ->where("payment_id !=",NULL)
        ->orderBy("id","desc")
        ->orderBy("transaction_date","desc")
        ->findAll();

        $data = ([
            "sales" => $sales,
            "db"    => $this->db,
        ]);

        return view("modules/sales",$data);
    }
    public function sales_manage($id){
        $sale = $this->saleModel->where("id",$id)->first();

        if($sale == NULL){
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', 'Data tidak ditemukan');

            return redirect()->to(base_url('dashboard'));
        }

        $contact = $this->contactModel
        ->where("id",$sale->contact_id)
        ->first();

        $admin = $this->adminModel
        ->where("id",$sale->admin_id)
        ->first();

        $warehouse = $this->warehouseModel
        ->where("id",$sale->warehouse_id)
        ->first();

        $payment = $this->paymentModel
        ->where("id",$sale->payment_id)
        ->first();
        
        $items = $this->saleItemModel
        ->where("sale_id",$id)
        ->findAll();

        $data = ([
            "db"    => $this->db,
            "contact"  => $contact,
            "admin"  => $admin,
            "warehouse"=> $warehouse,
            "payment"=> $payment,
            "sale"  => $sale,
            "items" => $items,
        ]);

        return view("modules/sales_manage",$data);
    }
    public function sales_drive_letter_print($id){
        $sale = $this->saleModel->where("id",$id)->first();

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

        $vehicle = $this->vehicleModel
        ->where("id",$sale->vehicle_id)
        ->first();
        
        
        $items = $this->saleItemModel
        ->where("sale_id",$id)
        ->findAll();

        $data = ([
            "db"    => $this->db,
            "contact"  => $contact,
            "warehouse"=> $warehouse,
            "payment"=> $payment,
            "sale"  => $sale,
            "vehicle"  => $vehicle,
            "items" => $items,
        ]);

        return view("warehouse/print_sale_drive_letter",$data);
    }
}