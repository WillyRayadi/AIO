<?php

namespace App\Controllers;

class ServiceCenter extends BaseController
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
    private $saleReturnModel;
    private $productReturnModel;
    private $productReturnItemModel;
    
    public function __construct(){
        $this->session = \Config\Services::session(); 
        $this->db = \Config\Database::connect();
        $this->validation =  \Config\Services::validation(); 
        $this->adminModel = new \App\Models\Administrator(); 
        $this->buysModel = new \App\Models\Buy();
        $this->saleReturnModel = new \App\Models\saleRetur();
        $this->buyItemsModel = new \App\Models\BuyItem();
        $this->productCategoriesModel = new \App\Models\Category();
        $this->deliveryModel = new \App\Models\Delivery();
        $this->productModel = new \App\Models\Product();
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
        $this->paymentTermsModel = new \App\Models\PaymentTerm();
        $this->categoriesModel = new \App\Models\Category();
        $this->productReturnModel = new \App\Models\ProductReturn();
        $this->productReturnItemModel = new \App\Models\ProductReturnItem();
        $this->warehouseTransferModel = new \App\Models\WarehouseTransfer(); 
        $this->warehouseTransfersItemsModel = new \App\Models\WarehouseTransfersItems();

        if($this->session->login_id == null){            
            $this->session->setFlashdata('msg', 'Maaf, Silahkan login terlebih dahulu!');
            header("location:".base_url('/'));
            exit();
        }else{
            if(config("Login")->loginRole != 10){
                header("location:".base_url('/dashboard'));
                exit();
            }
        }
    }
    
    public function return_pemasok_item_delete($id, $items){
        $returPemasokItem = $this->productReturnItemModel->find($items);
    
        if ($returPemasokItem) {
            $this->productReturnItemModel->where('id', $items)->delete();
            $this->productStockModel->where('product_return_pemasok_id', $items)->delete();
    
            $this->session->setFlashdata('message_type', 'success');
            $this->session->setFlashdata('message_content', 'Produk Berhasil Di Hapus');
    
            return redirect()->back();
    
        } else {
            $this->session->setFlashdata('message_type', 'success');
            $this->session->setFlashdata('message_content', 'Produk gagal dihapus');
    
            return redirect()->back();
        } 
    }
    
    public function warehouse_transfers(){
        $data_transfers = $this->db->table('warehouse_transfers')
        ->where('admin_id', $this->session->login_id)
        ->orderBy('id', 'desc')->get()->getResultObject();
        
        $warehouses = $this->db->table('warehouses')
        ->where("trash",0)
        ->orderBy("warehouses.name","asc")
        ->get()
        ->getResultObject();
        
        $admins = $this->db->table('administrators')
        ->where('id', $this->session->login_id)
        ->where('active !=', 0)
        ->orderBy('name', 'asc')
        ->get()->getResultObject();
        
        $data = ([
            'db'  => $this->db,
            'warehouses' => $warehouses,
            'admins'    => $admins,
            'data_transfers'=> $data_transfers,
        ]);
        
        return view ('servis_center/product_transfers', $data);
    }
    
    public function add_warehouse_transfers_header(){
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
    
        return redirect()->to(base_url('warehouse/transfers'));
    }
    
    public function warehouse_transfers_manage($id){
        $data_transfers = $this->warehouseTransferModel->get()->getFirstRow();

        $admins = $this->adminModel
        ->where("role >=",2)
        ->where("role <=",3)
        ->where("active !=",0)
        ->orderBy("administrators.name","asc")
        ->findAll();
    
        if ($data_transfers != NULL) {
            $goods = $this->productModel->where(['trash' => 0])->orderBy('name','asc')->findAll();
            $warehouses = $this->warehouseModel->where('trash',0)->orderBy('warehouses.name','desc')->findAll();
            $good_transfers = $this->warehouseTransferModel
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
            ->where('warehouse_transfers.id',$id)
            ->get()->getFirstRow();
    
            $good_transfers_items = $this->warehouseTransfersItemsModel
            ->join('products','warehouse_transfers_items.product_id = products.id','left')
            ->select([
                'warehouse_transfers_items.id',
                'products.name as product_name',
                'warehouse_transfers_items.quantity',
                'warehouse_transfers_items.warehouse_transfers_id',
            ])
            ->where('warehouse_transfers_id', $id)
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
    
            return view('servis_center/product_transfers_manage',$data);
    
        } else {
            $this->session->setFlashdata('message_type','warning');
            $this->session->setFlashdata('message_content','Data Tidak Ditemukan');
            return redirect()->to(base_url('warehouse/transfers'));
        }  
    }
    
    public function warehouse_transfers_items(){
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
        
        return redirect()->to(base_url('warehouse/transfers') . '/' . $warehouse_transfers_id);
    }
    
    public function warehouse_transfers_delete($id)
    {
        $items = $this->warehouseTransfersItemsModel->where('warehouse_transfers_id',$id)->first();
        
        $this->warehouseTransferModel->delete($id);
        $this->warehouseTransfersItemsModel->where('warehouse_transfers_id',$id)->delete();
        $this->productStockModel->where("warehouse_transfer_id", $items->id)->delete();
        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data transfer barang berhasil dihapus');

        return redirect()->to(base_url('warehouse/transfers'));
    }
    
    public function warehouse_transfers_delete_items($id, $warehouse_items){
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
    
    public function return_pemasok()
    {
        $pemasok = $this->contactModel->where('trash', 0)->where('type', 1)->orderBy('contacts.name', 'asc')->get()->getResultObject();

        $returns = $this->productReturnModel
        ->select([
            'product_returns.id',
            'contacts.name as contact_name',
            'product_returns.date as retur_date',
            'product_returns.number as number_retur',
            'product_returns.keterangan as keterangan',
            'warehouses.name as warehouse_name',
        ])
        ->join('contacts', 'product_returns.contact_id = contacts.id', 'left')
        ->join('administrators', 'product_returns.admin_id = administrators.id', 'left')
        ->join('warehouses', 'product_returns.warehouse_id = warehouses.id', 'left')
        ->orderBy('product_returns.id', 'desc')->get()->getResultObject();

        $data = ([
            'pemasok' => $pemasok,
            'returns' => $returns,
            'db'      => $this->db,
        ]);

        return view('servis_center/retur_data', $data);
    }

    public function return_pemasok_add()
    {
        $return_pemasok = $this->db->table('product_returns');
        $return_pemasok->selectMax('id');
        $return_pemasok = $return_pemasok->get();
        $return_pemasok = $return_pemasok->getFirstRow();

        $return_pemasok = $return_pemasok->id;
        $id = $return_pemasok + 1;
        $number_retur = "SRP/" . date("y") . "/" . $id;
        $dates = $this->request->getPost('dates');
        $contacts = $this->request->getPost('contact_id');
        $keterangan = $this->request->getPost('keterangan');
        $warehouses = $this->request->getPost('warehouse_id');

        $this->productReturnModel->insert([
            'date'       => $dates,
            'admin_id'   => $this->session->login_id,
            'contact_id' => $contacts,
            'keterangan' => $keterangan,
            'number'     => $number_retur,
            'warehouse_id'  => $warehouses,
        ]);

        return redirect()->to(base_url('retur/data'));
    }

    public function return_pemasok_manage($id)
    {
        $data_retur = $this->productReturnModel->where(['product_returns.id' => $id])->first();

        if ($data_retur != NULL) {
            $goods = $this->productStockModel
            ->select([
                'products.id as product_id',
                'products.name as product_name',
            ])
            ->join('products', 'product_stocks.product_id = products.id', 'left')
            ->whereIn('warehouse_id', [7, 10])
            ->groupBy('products.name')
            ->get()->getResultObject();

            $good_retur = $this->productReturnModel
            ->select([
                'product_returns.date',
                'contacts.name as contact_name',
                'product_returns.id as pemasok_id', 
                'administrators.name as admin_name',
                'warehouses.name as warehouse_name',
                'product_returns.files as retur_files',
                'product_returns.number as retur_number',
                'product_returns.keterangan as keterangan',
            ])
            ->join('contacts', 'product_returns.contact_id = contacts.id', 'left')
            ->join('warehouses', 'product_returns.warehouse_id = warehouses.id', 'left')
            ->join('administrators', 'product_returns.admin_id = administrators.id', 'left')
            ->where('product_returns.id', $id)->get()->getFirstRow();

            $retur_item = $this->productReturnItemModel
            ->select([
                'product_returns_item.files as retur_files',
                'products.name as product_name',
                'product_returns_item.quantity',
                'product_returns_item.id as return_item_id',
            ])
            ->join('products', 'product_returns_item.product_id = products.id', 'left')
            ->where('product_returns_item.return_pemasok_id', $id)
            ->get()->getResultObject();

            $data = ([
                'db' => $this->db,
                'goods' => $goods,
                'good_retur' => $good_retur,
                'retur_item' => $retur_item,
            ]);

            return view('servis_center/retur_manage', $data);

        } else {
            $this->session->setFlashdata('message_type', 'success');
            $this->session->setFlashdata('message_content', 'Data tidak ditemukan');

            return redirect()->to(base_url('return/pemasok'));
        }
    }

    public function return_pemasok_add_items()
    {
        $date = $this->request->getPost('dates');
        $retur_id = $this->request->getPost('retur_id');
        $products = $this->request->getPost('product_id');
        $quantity = $this->request->getPost('quantity');
        $warehouses = $this->request->getPost('warehouse_id');

        $this->productReturnItemModel->insert([
            "quantity"      => $quantity,
            "product_id"    => $products,
            "return_pemasok_id"  => $retur_id,
        ]);

        $returID = $this->productReturnItemModel->getInsertID();

        $qtyStock = 0 - $quantity;
        $this->productStockModel->insert([
            'date'          => $date,
            "product_id"    => $products,
            "quantity"      => $qtyStock,
            "warehouse_id"  => $warehouses,
            "product_return_pemasok_id" => $returID,
        ]);

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data berhasil ditambahkan');

        return redirect()->to(base_url('return/pemasok/manage') . '/' . $retur_id);
    }

    public function return_pemasok_print($good_retur)
    {
        $data_returs = $this->productReturnModel
        ->select([
            'product_returns.id',
            'contact_id',
            'number as retur_number',
            'admin_id',
            'keterangan',
            'date',
        ])
        ->where('product_returns.id', $good_retur)->get()->getFirstRow();

        $item_returs = $this->productReturnItemModel
        ->select([
            'products.name as product_name',
            'product_returns_item.quantity',
        ])
        ->join('products', 'product_returns_item.product_id = products.id', 'left')
        ->where('product_returns_item.return_pemasok_id', $good_retur)
        ->get()->getResultObject();

        $administrator = $this->adminModel->where('administrators.id', $data_returs->admin_id)->first();
        $contacts = $this->contactModel->where('contacts.id', $data_returs->contact_id)->first();

        $data = ([
            'db' => $this->db,
            'contacts'  => $contacts,
            'data_returs' => $data_returs,
            'item_returs' => $item_returs,
            'administrator' => $administrator,
        ]);

        return view('modules/retur_pemasok_print', $data);
    }

    public function return_pemasok_delete($id)
    {
        $items = $this->productReturnItemModel
            ->where("return_pemasok_id", $id)
            ->findAll();

        foreach ($items as $item) {
            $this->productReturnItemModel->where("id", $item->id)->delete();
            $this->productStockModel->where("product_return_pemasok_id", $item->id)->delete();
        }

        $this->productReturnModel->delete($id);
        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Retur Pemasok Berhasil Dihapus');

        return redirect()->back();
    }

    public function return_pemasok_insert_file()
    {
        $id = $this->request->getPost('id');

        $returns = $this->productReturnItemModel
        ->select('product_returns_item.return_pemasok_id')
        ->where('product_returns_item.return_pemasok_id', $id)
        ->get()->getFirstRow();


        $validationRule = [
            'file' => [
                'label' => 'File',
                'rules' => 'uploaded[file]',
            ],
        ];

        if (!$this->validate($validationRule)) {
            print_r($this->validator->getErrors());
            $errors = $this->validator->getErrors();
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', $errors['file']);

            return redirect()->back();
        }

        $filename = $_FILES['file']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $rename_file = "Receipt_retur_" . $id . "_" . date("dmYHis") . "." . $ext;
        $uploaddir = './public/return_pemasok/';
        $alamatfile = $uploaddir . $rename_file;

        move_uploaded_file($_FILES['file']['tmp_name'], $alamatfile);

        $this->productReturnItemModel
        ->where("product_returns_item.id", $id)
        ->set(["files" => $rename_file])
        ->update();

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', "Berkas Retur Berhasil Di upload");

        return redirect()->back();
    }

}