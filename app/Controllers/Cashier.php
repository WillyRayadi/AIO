<?php

namespace App\Controllers;
helper('tools_helper');

class Cashier extends BaseController
{ 
    protected $db; 
    protected $session; 
    protected $validation;  
    protected $adminModel; 
    
    private $productModel;
    private $contactModel;

    private $userPointModel;
    private $paymentModel;
    private $userRedeemModel;
    private $redeemItemModel;
    
    private $saleModel;
    private $saleItemModel;
    private $warehouseModel;
    
    private $deliveryModel;
    private $vehicleModel;
    private $productStocksModel;

    public function __construct(){
        $this->session = \Config\Services::session(); 
        $this->db = \Config\Database::connect();
        $this->validation =  \Config\Services::validation(); 

        $this->productModel = new \App\Models\Product();
        $this->contactModel = new \App\Models\Contact();
        $this->paymentTermsModel = new \App\Models\PaymentTerm();
        $this->userPointModel = new \App\Models\UserPoint();
        $this->userRedeemModel = new \App\Models\userRedeem();
        $this->redeemItemModel = new \App\Models\RedeemItem();
        
        $this->saleModel = new \App\Models\Sale();
        $this->saleItemModel = new \App\Models\SaleItem();
        $this->warehouseModel = new \App\Models\Warehouse();
        
        $this->deliveryModel = new \App\Models\Delivery();
        $this->vehicleModel = new \App\Models\Vehicle();
        
        $this->productStockModel = new \App\Models\ProductStock();
        
        if($this->session->login_id == null){            
            $this->session->setFlashdata('msg', 'Maaf, Silahkan login terlebih dahulu!');
            header("location:".base_url('/'));
            exit();
        }else{
            if(config("Login")->loginRole != 9){
                header("location:".base_url('/dashboard'));
                exit();
            }
        }
    }
    
    public function data_delivery(){
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
 
        return view("cashier/sales_warehouse",$data);
    }
    
    public function delivery_manage_warehouse($id){
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
        
        $admin = $this->db->table('administrators')
        ->where('administrators.id', $sale->admin_id)
        ->get()->getFirstRow();

        $contact = $this->contactModel
        ->where("id",$sale->contact_id)
        ->first();

        $warehouse = $this->warehouseModel
        ->where("id",$sale->warehouse_id)
        ->first();

        $vehicles = $this->vehicleModel
        ->where("trash",0)
        ->orderBy("brand","asc")
        ->findAll();
        
        $items = $this->saleItemModel
        ->where("sale_id",$id)
        ->findAll();

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
        
        $payment = $this->db->table('payment_terms')
        ->where('id', $sale->payment_id)
        ->get()->getFirstRow();

        $data = ([
            "db"    => $this->db,
            'admin'    => $admin,
            "contact"  => $contact,
            "warehouse"=> $warehouse,
            "sale"  => $sale,
            "items" => $items,
            "deliver" => $deliver,
            "vehicles" => $vehicles,
            "deliveries" => $deliveries,
            "saleItem" => $saleItem,
            "stocks" => $stocks,
            "payment"   => $payment,
        ]);

        return view("cashier/sales_warehouse_manage",$data);
    }
    
    public function sales(){
        $saleData = $this->db->table('sales as a')
        ->select([
            'a.id',
            'a.status',
            'a.transaction_date',
            'a.number as sale_number',
            'c.name as contact_name',
            'b.name as admin_name',
        ])
        ->join('administrators as b', 'a.admin_id = b.id', 'left')
        ->join('contacts as c', 'a.contact_id = c.id', 'left')
        ->where('a.contact_id !=', NULL)
        ->where('a.payment_id !=', NULL)
        ->where('a.trash', 0)
        ->orderBy('a.transaction_date','desc')
        ->get()->getResultObject();
        
        $data = ([
            'db'    => $this->db,
            'saleData' => $saleData,
        ]);
        
        return view('cashier/sales', $data);
    }
    
    public function sales_add()
    {
        $maxId = $this->db->table("sales");
        $maxId->selectMax("id");
        $maxId = $maxId->get();
        $maxId = $maxId->getFirstRow();
        $maxId = $maxId->id;

        $thisID = $maxId + 1;

        $transaction_number = "SO/" . date("y") . "/" . date("m") . "/" . $thisID;

        // $firstWarehouse = $this->warehouseModel->where("trash",0)->orderBy("name","asc")->first();

        $this->saleModel
        ->insert([
            "id"    => $thisID,
            "number"    => $transaction_number,
            "admin_id"    => $this->session->login_id,
            "contact_id"    => NULL,
            "location_id"   => NULL,
            // "warehouse_id"=> $firstWarehouse->id,
            "invoice_address" => NULL,
            "sales_notes" => NULL,
            "time_create"     => date("Y-m-d H:i:s"),
            "transaction_date"  => date("Y-m-d"),
            "expired_date"  => date("Y-m-d", strtotime("+1 days")),
            "payment_id"    => NULL,
            "customer_reference_code" => "-",
            "tags"  => NULL,
            "status"    => 1,
            'is_saved' => 0
        ]);

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Pesanan penjualan berhasil dibuat');

        if (config("Login")->loginRole == 9) {
            return redirect()->to(base_url('cashier/sales/' . $thisID . '/manage'));
        }
    }
    
    public function sales_manage($id){
        $sale = $this->db->table('sales as a')
        ->select([
            'sales.id',
            'sales.transaction_date',
            'sales.number as sale_number',
            'contacts.name as contact_name',
            'administrators.name as admin_name',
        ])
        ->join('contacts as b', 'a.contact_id = b.id', 'left')
        ->join('administrators as c', 'a.admin_id = c.id', 'left')
        ->where('a.id', $id)->get()->getFirstRow();
        
        $item = $this->db->table('sale_items as a')
        ->select([
            'a.id',
            'a.product_id',
            'b.name as product_name',
        ])
        ->join('products as b','a.product_id = b.id', 'left')
        ->where('a.sale_id', $id)->get()->getFirstRow();
        
        if($this->session->login_id){
            return view('cashier/sale_manage', $data);
        }
    }
    
    public function user_point(){
        $user = $this->userPointModel
        ->select([
            'user_point.id',
            'user_point.contact_id',
            'sum(point_in) as points',
            'user_point.date as point_date',
            'contacts.name as contact_name',
        ])
        ->join('contacts','user_point.contact_id = contacts.id','left')
        ->where('contacts.is_member !=', NULL)
        ->groupBy('contacts.id')->get()->getResultObject();
        
        $data = ([
            'user'  => $user,
            'db'    => $this->db,
        ]);
        
        return view('modules/user_point',$data);
    }

    public function products(){
        $items = $this->db->table('products');
        $items->select([
            'products.sku_number',
            'products.name as product_name',
            'products.unit as product_unit',
        ]);
        $items->where('products.trash', 0);
        $items->orderBy('products.name', 'asc');
        $items = $items->get();
        $items = $items->getFirstRow();

        $data = ([
            'db' => $this->db,
            'items' => $items,
        ]);

        return view('cashier/products', $data);
    }
    
    public function user_redeems(){
        $user = $this->userPointModel
        ->select([
            'user_point.contact_id',
            'sum(point_in) as points',
            'user_point.id',
            'user_point.point_in',
            'contacts.name as contact_name',
            'user_point.date as point_date',
        ])
        ->join('contacts', 'user_point.contact_id = contacts.id','left')
        ->where('contacts.is_member !=', NULL)
        ->groupBy('contacts.id')->get()->getResultObject();
            
        $value = $this->db->table('user_redeem');
        $value->select([
            'user_redeem.id',
            'user_redeem.dates',
            'user_redeem.number',
            'contacts.name as contact_name',
            'administrators.name as admin_name',
        ]);
        $value->join('contacts', 'user_redeem.contact_id = contacts.id','left');
        $value->join('administrators', 'user_redeem.admin_id = administrators.id','left');
        $value->orderBy('user_redeem.dates','desc');
        $value = $value->get();
        $value = $value->getResultObject();
            
        $data = ([
            'user'  => $user,
            'db'    => $this->db,
            'value' => $value,
        ]);
        
        return view('cashier/redeem_points', $data);
    }
    
    public function redeem_item_manage($id){
        
        $datas = $this->db->table('user_redeem');
        $datas->select([
            'user_redeem.id',
            'contacts.address',
            'user_redeem.dates',
            'user_redeem.number',
            'user_redeem.contact_id',
            'user_redeem.user_point_id',
            'contacts.name as contact_name',
            'administrators.name as admin_name',
        ]); 
        $datas->join('contacts','user_redeem.contact_id = contacts.id','left');
        $datas->join('administrators','user_redeem.admin_id = administrators.id','left');
        $datas->orderBy('user_redeem.id','desc');
        $datas->where('user_redeem.id', $id);
        $datas = $datas->get();
        $datas = $datas->getFirstRow();
        
        echo $datas->number;
    }

    public function add_member_redeem(){
        $user_redeem = $this->db->table('user_redeem');
        $user_redeem->selectMax('id');
        $user_redeem = $user_redeem->get();
        $user_redeem = $user_redeem->getFirstRow();    
        $user_redeem = $user_redeem->id;
        
        $id = $user_redeem + 1;
            
        $number_redeem = "RDM".date("dmy").$id;
        $dates = $this->request->getPost('dates');

        $customers = $this->request->getPost('customers');

        $this->userRedeemModel
        ->insert([
            'dates'     => $dates,
            'number'    => $number_redeem,
            'admin_id'  => $this->session->login_id,
            'contact_id'    => $customers,
        ]);

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Berhasil Menambahkan Data!');

        return redirect()->to(base_url('user/redeem/'. $id));
    }   

    public function contacts(){
        $contacts = $this->db->table('contacts');
        $contacts->select([
            'contacts.id',
            'contacts.name',
            'contacts.type',
            'contacts.email',
            'contacts.phone',
            'contacts.address',
        ]);
        $contacts->where('contacts.name !=','');
        $contacts->where('contacts.trash', 0);
        $contacts->orderBy('name','asc');
        $contacts = $contacts->get();
        $contacts = $contacts->getResultObject();

        $data = ([
            'db'    => $this->db,
            'contacts'  => $contacts,
        ]);

        return view('cashier/cashier_contacts', $data);
    }

}