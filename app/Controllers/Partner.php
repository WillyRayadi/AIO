<?php

namespace App\Controllers;
helper('tools_helper');

class Partner extends BaseController
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
            if(config("Login")->loginRole != 11){
                header("location:".base_url('/dashboard'));
                exit();
            }
        }
    }
    
    public function sales_data(){
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
        $sales->whereNotIn('d.warehouse_id', [$allow_warehouses]);
        $sales->orderBy('b.transaction_date','desc');
        $sales->groupBy('b.id');
        $sales = $sales->get();
        $sales = $sales->getResultObject();

        $data = ([
            'sales' => $sales,
            'db'  => $this->db,
        ]);
        
        return view('partner/sales_data_manage', $data);
    }
    
    public function sales_warehouses_data(){
        $allow_warehouses = !empty(cek_session ($this->session->get('login_id'))['allow_warehouses']) ? cek_session($this->session->get('login_id'))['allow_warehouses'] : '"1","2","3","4","5","6","7","8","9","10"';
        
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
        $sales->join('administrators as e', 'b.admin_id = e.id','left');
        $sales->join('product_stocks as d', 'a.id = d.sale_item_id','left');
        $sales->where('b.contact_id !=', NULL);
        $sales->where('b.payment_id !=', NULL);
        $sales->where("status >=",2);
        $sales->where("status !=",3);
        $sales->whereNotIn('d.warehouse_id', [$allow_warehouses]);
        $sales->orderBy('b.transaction_date','desc');
        $sales->groupBy('b.id');
        $sales = $sales->get();
        $sales = $sales->getResultObject();

        $data = ([
            'sales' => $sales,
            'db'  => $this->db,
        ]);
        
        return view('partner/sales_warehouses', $data);
    }
    
    public function sales_warehouse_data_manage($id){
        $sale = $this->saleModel->where('sales.id', $id)->get()->getFirstRow();
        $deliveries = $this->deliveryModel->where('sale_id', $id)->get()->getFirstRow();
        
        if($deliveries == NULL){
            $this->session->setFlashData('message_type', 'error');
            $this->session->setFlashData('message_content', 'Data tidak ditemukan');
            
            return redirect()->to(base_url('dashboard'));
        }
        
        if($sale == NULL){
            $this->session->setFlashData('message_type', 'error');
            $this->session->setFlashData('message_content', 'Data tidak ditemukan');
            
            return redirect()->to(base_url('dashboard'));
        }
        
        if($sale->contact_id == NULL){
            $this->session->setFlashData('message_type', 'error');
            $this->session->setFlashData('message_content', 'Data tidak ditemukan');
            
            return redirect()->to(base_url('dashboard'));
        }
        
        if($sale->payment_id == NULL){
            $this->session->setFlashData('message_type', 'error');
            $this->session->setFlashData('message_content', 'Data tidak ditemukan');
            
            return redirect()->to(base_url('dashboard'));
        }
        
        $contact = $this->db->table('contacts')
        ->where('id', $sale->contact_id)
        ->get()->getFirstRow();
        
        $warehouse = $this->db->table('warehouses')
        ->where('id', $sale->warehouse_id)
        ->get()->getFirstRow();
        
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
            'db'  => $this->db,
            'sale'     => $sale,
            'admin'    => $admin,
            'items'    => $items,
            'stocks'   => $stocks,
            'contact'  => $contact,
            'payment'  => $payment,
            'deliver'  => $deliver,
            'vehicles' => $vehicles,
            'warehouse'=> $warehouse,
            'deliveries' => $deliveries,
            'saleItem' => $saleItem,
        ]);
        
        return view('partner/sale_warehouse_data', $data);
    }
    
    public function buys() {
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
        
        return view('partner/product_buys', $data);
    }
    
 }