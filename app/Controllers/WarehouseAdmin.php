<?php

namespace App\Controllers;
helper('tools_helper');

class WarehouseAdmin extends BaseController
{
    protected $session;
    protected $validation;
    protected $db;

    protected $adminModel;

    private $productCategoriesModel;
    private $productModel;
    private $productPriceModel;
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
    private $deliveryModel;
    private $deliveryItemModel;

    public function __construct(){
        $this->session = \Config\Services::session();

        $this->db = \Config\Database::connect();
        $this->validation =  \Config\Services::validation();
        
        $this->adminModel = new \App\Models\Administrator();

        $this->productCategoriesModel = new \App\Models\Category();
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
        $this->deliveryModel = new \App\Models\Delivery();
        $this->deliveryItemModel = new \App\Models\DeliveryItem();

        if($this->session->login_id == null){            
            $this->session->setFlashdata('msg', 'Maaf, Silahkan login terlebih dahulu!');
            header("location:".base_url('/'));
            exit();
        }else{
            if(config("Login")->loginRole != 1){    
                if(config("Login")->loginRole != 6){
                    if(config("Login")->loginRole != 7){
                    header("location:".base_url('/dashboard'));
                    exit();
                }
              }
            }
        }
    }
    
    public function status_approve(){
        $sales = $this->saleModel
        ->select([
            'sales.id',
            'sales.status',
            'sales.admin_id',
            'sales.contact_id',
            'sales.number as sale_number',
            'locations.name as location_name',
            'sales.transaction_date as sale_transaction',
        ])
        ->join('locations','sales.location_id = locations.id','left')
        ->join('administrators','sales.admin_id = administrators.id','left')
        ->where("contact_id !=",NULL)
        ->where("payment_id !=",NULL)
        ->where('sales.status',2)
        ->orderBy("transaction_date","desc")
        ->orderBy("id","desc")->findAll();

        $data = ([
            "sales" => $sales,  
            "db"    => $this->db,
        ]);
        
        return view('warehouse/status_approve', $data);
    }

    public function status_dikirim_sebagian(){
        $sales = $this->saleModel
        ->select([
            'sales.id',
            'sales.status',
            'sales.admin_id',
            'sales.contact_id',
            'sales.number as sale_number',
            'locations.name as location_name',
            'sales.transaction_date as sale_transaction',
        ])
        ->join('locations','sales.location_id = locations.id','left')
        ->join('administrators','sales.admin_id = administrators.id','left')
        ->where("contact_id !=",NULL)
        ->where("payment_id !=",NULL)
        ->where('sales.status',4)
        ->orderBy("transaction_date","desc")
        ->orderBy("id","desc")->findAll();

        $data = ([
            "sales" => $sales,  
            "db"    => $this->db,
        ]);
        
        return view('warehouse/sales_dikirim_sebagian', $data);
    }

    public function status_dikirim(){
        $sales = $this->saleModel
        ->select([
            'sales.id',
            'sales.status',
            'sales.admin_id',
            'sales.contact_id',
            'sales.number as sale_number',
            'locations.name as location_name',
            'sales.transaction_date as sale_transaction',
        ])
        ->join('locations','sales.location_id = locations.id','left')
        ->join('administrators','sales.admin_id = administrators.id','left')
        ->where("contact_id !=",NULL)
        ->where("payment_id !=",NULL)
        ->where('sales.status', 5)
        ->orderBy("transaction_date","desc")
        ->orderBy("id","desc")->findAll();

        $data = ([
            "sales" => $sales,  
            "db"    => $this->db,
        ]);
        
        return view('warehouse/sales_dikirim', $data);
    }

    public function status_selesai(){
        $sales = $this->saleModel
        ->select([
            'sales.id',
            'sales.status',
            'sales.admin_id',
            'sales.contact_id',
            'sales.number as sale_number',
            'locations.name as location_name',
            'sales.transaction_date as sale_transaction',
        ])
        ->join('locations','sales.location_id = locations.id','left')
        ->join('administrators','sales.admin_id = administrators.id','left')
        ->where("contact_id !=",NULL)
        ->where("payment_id !=",NULL)
        ->where('sales.status', 6)
        ->orderBy("transaction_date","desc")
        ->orderBy("id","desc")->findAll();

        $data = ([
            "sales" => $sales,  
            "db"    => $this->db,
        ]);
        
        return view('warehouse/sales_selesai', $data);
    }
  
  	public function delivery_orders(){
     $items = $this->saleItemModel
     ->findAll();

     $data = ([
     "items" => $items,
     "db"=> $this->db,
  	 ]);
     return view('warehouse/delivery_orders', $data);
    }

    public function sales_warehouse(){
    $allow_warehouses = !empty(cek_session($this->session->get('login_id'))['allow_warehouses']) ? cek_session($this->session->get('login_id'))['allow_warehouses'] : '"1","2","3","4","5","7","8","9","10"';

    $sales = $this->saleModel
    ->where("sales.trash", 0)
    ->where("contact_id !=",NULL)
    ->where("payment_id !=",NULL)
    ->where("status >=",2)
    ->where("status !=",3)
    ->where("Id in(
        select sale_id from sale_items as AA
        inner join product_stocks as BB on AA.id=BB.sale_item_id 
        where BB.warehouse_id in($allow_warehouses)
    )")
    ->orderBy("transaction_date","desc")
    ->orderBy("id","desc")->findAll();
    
    $data = ([
        "sales" => $sales,  
        "db"    => $this->db,
        ]);

        return view("warehouse/sales",$data);
    }
  
    public function sales_manage_warehouse($id){
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
        
        $dateUser= $this->deliveryModel
        ->join('administrators', 'deliveries.admin_print_id = administrators.id', 'left')
        ->where('sale_id', $id)
        ->first();
        
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
            "vehicles" => $vehicles,
            "deliveries" => $deliveries,
            "saleItem" => $saleItem,
            "stocks" => $stocks,
            "dateUser"  => $dateUser,
        ]);

        return view("warehouse/sales_manage",$data);
    }
    public function sales_drive_save(){
        $id = $this->request->getPost('id');
        $vehicle = $this->request->getPost('vehicle');
        $driver = $this->request->getPost('driver');
        $sent_date = $this->request->getPost('sent_date');
        $warehouse_notes = $this->request->getPost('warehouse_notes');

        $this->saleModel->where("id", $id)
        ->set([
            "vehicle_id" => $vehicle,
            "driver_name" => $driver,
            "sent_date" => $sent_date,
            "warehouse_notes" => $warehouse_notes,
        ])->update();

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data Surat Jalan Berhasil Disimpan');

        return redirect()->to(base_url('warehouse/sales/'.$id.'/manage'));
    }
  
    public function sales_drive_letter_print_warehouse($id){
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

    public function sales_delete_shipping_receipt($id, $sale){

        $saleData = $this->deliveryModel
        ->where("deliveries.id",$id)
        ->where("deliveries.sale_id",$sale)
        ->first();

        if($saleData->shipping_receipt_file == NULL){
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', "Berkas pengiriman gagal dihapus");

            return redirect()->to(base_url('warehouse/sales/'.$sale.'/manage'));
        }

        unlink('./public/shipping_receipts/'.$saleData->shipping_receipt_file);

        $this->deliveryModel
        ->where("deliveries.id",$id)
        ->where("deliveries.sale_id",$sale)
        ->set(["shipping_receipt_file" => NULL])->update();

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', "Berkas pengiriman berhasil dihapus");

        return redirect()->to(base_url('warehouse/sales/'.$sale.'/manage'));
    }
  
    public function sales_upload_shipping_receipt(){
        $sale = $this->request->getPost('sale');
        $id = $this->request->getPost('id');

        $saleData = $this->deliveryModel
        ->where("deliveries.id",$id)
        ->where("deliveries.sale_id",$sale)->first();

        if($saleData->shipping_receipt_file != NULL){
            unlink('./public/shipping_receipts/'.$saleData->shipping_receipt_file);
        }

        $validationRule = [
            'file' => [
                'label' => 'File',
                'rules' => 'uploaded[file]'
                    . '|max_size[file,1000]'
            ],
        ];

        if (! $this->validate($validationRule)) {
            print_r($this->validator->getErrors());
            $errors = $this->validator->getErrors();
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', $errors['file']);

            return redirect()->to(base_url('warehouse/sales/'.$sale.'/manage'));
        }

        $filename = $_FILES['file']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $rename_file = "RECEIPT_SO".$sale."_".date("dmYHis").".".$ext;
        $uploaddir = './public/shipping_receipts/';
        $alamatfile = $uploaddir . $rename_file;

        move_uploaded_file($_FILES['file']['tmp_name'], $alamatfile);

        $this->deliveryModel
        ->where("deliveries.id",$id)->where("deliveries.sale_id",$sale)
        ->set(["shipping_receipt_file"=>$rename_file])->update();

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', "Berkas pengiriman berhasil di upload");

        return redirect()->to(base_url('warehouse/sales/'.$sale.'/manage'));
    }
  
  	public function sales(){ 
        $allow_warehouses = !empty(cek_session($this->session->get('login_id'))['allow_warehouses']) ? cek_session($this->session->get('login_id'))['allow_warehouses'] : '"1","2","3","5","6","7","8","9"';
        
        $sales = $this->saleModel
        ->where("sales.trash", 0)
        ->where("contact_id !=",NULL)
        ->where("payment_id !=",NULL)
        ->where("Id in(
            select sale_id from sale_items as AA
            inner join product_stocks as BB on AA.id=BB.sale_item_id 
            where BB.warehouse_id in($allow_warehouses)
        )")
        ->orderBy("transaction_date","desc")
        ->orderBy("id","desc")
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

        $deliveries = $this->deliveryModel
        ->where("sale_id",$id)
        ->orderBy("sent_date","desc")
        ->orderBy("id","desc")
        ->findAll();

        $data = ([
            "db"    => $this->db,
            "contact"  => $contact,
            "admin"  => $admin,
            "warehouse"=> $warehouse,
            "payment"=> $payment,
            "sale"  => $sale,
            "items" => $items,
            "deliveries" => $deliveries,
        ]);

        return view("modules/sales_manage",$data);
    }
  
    public function sales_invoice_print($id){
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
        
        
        $items = $this->saleItemModel
        ->where("sale_id",$id)
        ->findAll();

        $data = ([
            "db"    => $this->db,
            "contact"  => $contact,
            "warehouse"=> $warehouse,
            "payment"=> $payment,
            "sale"  => $sale,
            "items" => $items,
        ]);

        return view("modules/print_sale_invoice",$data);
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
  
    public function sales_set_status($id,$status){
        $saleData = $this->saleModel->where("id",$id)->first();
        if($status == 4){
            if($saleData->sent_date == NULL){
                $this->session->setFlashdata('message_type', 'warning');
                $this->session->setFlashdata('message_content', 'Data Surat Jalan Belum Lengkap');
            }
        }

        if($status == 5){
            if($saleData->shipping_receipt_file == NULL){
                $this->session->setFlashdata('message_type', 'warning');
                $this->session->setFlashdata('message_content', 'Berkas Surat Jalan Belum Diupload');
            }
        }

        $this->saleModel->where("id",$id)->set(["status"=>$status])->update();

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Status berhasil disimpan');

        if(config("Login")->loginRole == 7){
            return redirect()->to(base_url('owner/sales/'.$id.'/manage'));
        }else{
            return redirect()->to(base_url('sales/'.$id.'/manage'));
        }
    }
  
    public function deliveries_add(){
        $id = $this->request->getPost('id');
        $vehicle = $this->request->getPost('vehicle');
        $driver = $this->request->getPost('driver');
        $sent_date = $this->request->getPost('sent_date');
        $warehouse_notes = $this->request->getPost('warehouse_notes');

        $this->deliveryModel
        ->insert([
            "sale_id"=>$id,
            "vehicle_id" => $vehicle,
            "driver_name" => $driver,
            "sent_date" => $sent_date,
            "warehouse_notes" => $warehouse_notes,
        ]);

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data Pengiriman Berhasil Dibuat');

        return redirect()->to(base_url('warehouse/sales/'.$id.'/manage'));
    }
  
    public function deliveries_save(){
        $id = $this->request->getPost('id');
        $sale = $this->request->getPost('sale');
        $vehicle = $this->request->getPost('vehicle');
        $driver = $this->request->getPost('driver');
        $sent_date = $this->request->getPost('sent_date');
        $warehouse_notes = $this->request->getPost('warehouse_notes');

        $this->deliveryModel->where("id",$id)
        ->set([
            "vehicle_id" => $vehicle,
            "driver_name" => $driver,
            "sent_date" => $sent_date,
            "warehouse_notes" => $warehouse_notes,
        ])->update();

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data Pengiriman Berhasil Disimpan');

        return redirect()->to(base_url('warehouse/sales/'.$sale.'/manage'));
    }
  
    public function deliveries_delete($sale,$id){
        $this->deliveryModel->where("id",$id)->delete();
        $this->deliveryItemModel->where("delivery_id",$id)->delete(); 
        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data Pengiriman Berhasil Dihapus'); 
        return redirect()->to(base_url('warehouse/sales/'.$sale.'/manage')); 
    }

    public function deliveries_item_add(){
        $delivery = $this->request->getPost('delivery');
        $sale = $this->request->getPost('sale');
        $item = $this->request->getPost('item');
        $qty = $this->request->getPost('qty');
        $no_trx = $this->request->getPost('no_trx');

        $thisItem = $this->saleItemModel->where("id",$item)->first();
        $thisDeliveredItem = $this->deliveryItemModel->selectSum("quantity")->where("sale_item_id",$item)->first();

        $sumQty = $thisItem->quantity - $thisDeliveredItem->quantity;

        //lakukan pengecekan qty pesan yang telah dikirim

        if($qty == 0){
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', 'Pengiriman Item Tidak Boleh Nol');

            return redirect()->to(base_url('warehouse/sales/'.$sale.'/manage'));
        }else{
            if($qty > $sumQty){
                $this->session->setFlashdata('message_type', 'error');
                $this->session->setFlashdata('message_content', 'Pengiriman Item Telah Melebihi Kuantites Yang Dipesan');

                return redirect()->to(base_url('warehouse/sales/'.$sale.'/manage'));
            }else{
                $insert = $this->deliveryItemModel
                ->insert([
                    "delivery_id" => $delivery,
                    "sale_item_id" => $item,
                    "quantity" => $qty
                ]);


                $this->update_status_empat($no_trx);


                $this->session->setFlashdata('message_type', 'success');
                $this->session->setFlashdata('message_content', 'Pengiriman Item Berhasil Ditambahkan'); 
                return redirect()->to(base_url('warehouse/sales/'.$sale.'/manage')); 
            }
        }
    }

    public function update_status_empat($no_trx){

        //cek selisih qty pesan
        $cek_qty_pesan = $this->db->table("sales a");
        $cek_qty_pesan->select("sum(b.quantity) as quantity_pesan,b.id");
        $cek_qty_pesan->join("sale_items b","a.id=b.sale_id","inner");
        $cek_qty_pesan->where(['number'=>$no_trx]);
        $rows_qty = $cek_qty_pesan->get();

        if($rows_qty->getNumRows() > 0){

            $cek_qty_kirim = $this->db->table("sales a");
            $cek_qty_kirim->select("sum(c.quantity) as qty_kirim");
            $cek_qty_kirim->join("sale_items b","a.id=b.sale_id","inner");
            $cek_qty_kirim->join("delivery_items c","b.id=c.sale_item_id","left");
            $cek_qty_kirim->where(['number'=>$no_trx]);
            $rows_qty_kirim = $cek_qty_kirim->get();

            if($rows_qty_kirim->getNumRows() > 0){

                // 9 > 9
                if(($rows_qty->getRow()->quantity_pesan) > $rows_qty_kirim->getRow()->qty_kirim ) :

                //update status
                $this->saleModel->where("number",$no_trx)->set(["status"=>4])->update();
            else :
                $this->saleModel->where("number",$no_trx)->set(["status"=>5])->update();

            endif;
        }

    }

}

	public function deliveries_item_save(){
    	$sale = $this->request->getPost('sale');
    	$item = $this->request->getPost('item');
    	$qty = $this->request->getPost('qty');
    	$no_trx = $this->request->getPost('no_trx');

    	$thisDeliveryItem = $this->deliveryItemModel->where("id",$item)->first();
    	$thisItem = $this->saleItemModel->where("id",$thisDeliveryItem->sale_item_id)->first();
    	$thisDeliveredItem = $this->deliveryItemModel->selectSum("quantity")->where("sale_item_id",$item)->first();

    	$sumQty = $thisItem->quantity - $thisDeliveredItem->quantity;

        	// echo $sumQty."-".$qty;



    	if($qty == 0){
        	$this->session->setFlashdata('message_type', 'error');
        	$this->session->setFlashdata('message_content', 'Pengiriman Item Tidak Boleh Nol');

        	return redirect()->to(base_url('warehouse/sales/'.$sale.'/manage'));
    	}else{
        	if($qty > $sumQty){
            	$this->session->setFlashdata('message_type', 'error');
            	$this->session->setFlashdata('message_content', 'Pengiriman Item Melebihi Kuantites Yang Tersedia');

            	return redirect()->to(base_url('warehouse/sales/'.$sale.'/manage'));
        	}else{
            	$insert = $this->deliveryItemModel
            	->where("id",$item)
            	->set([
                	"quantity" => $qty,
            	])->update();

            	$this->update_status_empat($no_trx);

            	$this->session->setFlashdata('message_type', 'success');
            	$this->session->setFlashdata('message_content', 'Pengiriman Item Berhasil Disimpan'.json_encode($rows_qty)); 
            	return redirect()->to(base_url('warehouse/sales/'.$sale.'/manage'));
        }
    }
}

	public function deliveries_items_delete($sale,$item){
    	$no_trx = $this->request->getGet('no_trx');

    	$this->deliveryItemModel->where("id",$item)->delete();
    	$this->update_status_empat($no_trx);

    	$this->session->setFlashdata('message_type', 'success');
    	$this->session->setFlashdata('message_content', 'Pengiriman Item Berhasil Dihapus');

    	return redirect()->to(base_url('warehouse/sales/'.$sale.'/manage'));
	}
  
    public function deliveries_print($id,$sent){
        $sale = $this->saleModel->where("id",$id)->first();
        $delivery = $this->deliveryModel->where("id",$sent)->first();

        if($sale == NULL){
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', 'Data tidak ditemukan');
            return redirect()->to(base_url('dashboard'));
        }

        if($delivery == NULL){
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

        $delivery_items = $this->deliveryItemModel
        ->where("delivery_id",$sent)
        ->findAll();

        $data = ([
            "db"    => $this->db,
            "contact"  => $contact,
            "warehouse"=> $warehouse,
            "payment"=> $payment,
            "sale"  => $sale,
            "delivery" => $delivery,
            "vehicle"  => $vehicle,
            "items" => $items,
            "delivery_items" => $delivery_items,
        ]);

        return view("warehouse/print_sale_delivery_letter",$data);
    }
}