<?php

namespace App\Controllers;

class Buys extends Admin
{
    private $buysModel;
    private $buyItemsModel;
    private $paymentTermsModel;
    private $supplierModel;
    private $warehouseModel;
    private $contactModel;
    private $stocksModel;
    private $categoriesModel;
    private $statusModel;
    
    protected $session;
    
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->buysModel = new \App\Models\Buy();
        $this->statusModel = new \App\Models\Status();
        $this->buyItemsModel = new \App\Models\BuyItem();
        $this->paymentTermsModel = new \App\Models\PaymentTerm();
        $this->categoriesModel = new \App\Models\Category();
        $this->suppliers = new \App\Models\Supplier();
        $this->contactModel = new \App\Models\Contact();
        $this->warehouseModel = new \App\Models\Warehouse();
        $this->stocksModel = new \App\Models\Stock();
        $this->supplierModel = new \App\Models\Supplier();
        
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
    
    
    public function perubahan_data(){
        $alasan = $this->statusModel
         ->select([
            'status_pd.id as status_id',
            'products.name as product_name',
            'contacts.name as contact_name',
            'status_pd.buy_id as buy_id',
            'buys.number as buy_number',
            'administrators.name as admin_name',
            'status_pd.alasan as alasan',
        ])
        ->where('status_pd.admin_id',$this->session->login_id)
        ->join('products', 'status_pd.product_id = products.id','left')
        ->join('contacts','status_pd.contact_id = contacts.id','left')
        ->join('buys','status_pd.buy_id = buys.id','left')
        ->join('administrators','status_pd.admin_id = administrators.id','left')
        ->orderBy('status_pd.id','desc')->get()->getResultObject();

        $data = ([
            "alasan" => $alasan,
            "db" => $this->db,
        ]);

        return view('modules/perubahan_data',$data);
    } 
    
    public function perubahan_data_manages($id){
        $headers = $this->statusModel
        ->select([
            'status_pd.ready',
            'status_pd.id as status_id',
            'buys.number as buy_number',
            'contacts.name as contact_name',
            'products.name as product_name',
            'administrators.name as admin_name',
            'status_pd.alasan as alasan_perubahan',
        ])
        ->join('products','status_pd.product_id = products.id','left')
        ->join('buys','status_pd.buy_id = buys.id','left')
        ->join('contacts','status_pd.contact_id = contacts.id','left')
        ->join('administrators','status_pd.admin_id = administrators.id','left')
        ->where('status_pd.id', $id)
        ->where('status_pd.admin_id', $this->session->login_id)
        ->get()->getFirstRow();

        $products = $this->statusModel
        ->select([
            'status_pd.ready',
            'buy_items.buy_id',
            'status_pd.stok_awal',
            'buy_items.product_id',
            'status_pd.stok_sekarang',
            'products.name as product_name',
        ])
        ->where('status_pd.id', $id)
        ->join('products','status_pd.product_id = products.id','left')
        ->join('buy_items','status_pd.buy_id = buy_items.buy_id','left')
        ->get()->getResultObject();

        $data = ([
            'db' => $this->db,
            'headers' => $headers,
            'products' => $products,
        ]);

        return view('modules/perubahan_data_manages',$data);
    }
    
    public function admin_comment_add(){
        $alasan_status = $this->request->getPost('alasan_status');
        $buy_id = $this->request->getpost('buy_id');
        $contact_id = $this->request->getPost('contact_id');
        $product_id = $this->request->getPost('product_id');
        $stok_awal = $this->request->getPost('stok_awal');
        $stok_sekarang = $this->request->getPost('stok_sekarang');

        $alasan = $this->statusModel->orderBy('id','desc')->get()->getFirstRow();
        $items = $this->buyItemsModel->where('buy_items.buy_id',$buy_id)->where('buy_items.product_id',$product_id)->get()->getFirstRow();

        $this->statusModel->insert([
            'alasan' => $alasan_status,
            'admin_id' => $this->session->login_id,
            'buy_id' => $buy_id,
            'buy_item_id' => $items->id,
            'contact_id' => $contact_id,
            'product_id' => $product_id,
            'stok_awal' => $stok_awal,
            'stok_sekarang' => $stok_sekarang,
        ]);

        $this->session->setFlashdata('message_type','success');
        $this->session->setFlashdata('message_content', 'Data berhasil dikirim');

        return redirect()->back();
    }
    
   public function purchase_shipping_receipt(){
        $id = $this->request->getPost('id');

        $buys = $this->buysModel
        ->select('buys.id')
        ->where('buys.id', $id)
        ->get()->getFirstRow();

        $validationRule = [
            'file' => [
                'label' => 'File',
                'rules' => 'uploaded[file]',
            ],
        ];

        if (! $this->validate($validationRule)) {
            print_r($this->validator->getErrors());
            $errors = $this->validator->getErrors();
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', $errors['file']);

            return redirect()->back();
        }
        
        $filename = $_FILES['file']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $rename_file = "Receipt_purchase".$buys->id."_".date("dmYHis").".".$ext;
        $uploaddir = './public/purchase_receipts/';
        $alamatfile = $uploaddir . $rename_file;

        move_uploaded_file($_FILES['file']['tmp_name'], $alamatfile);

        $this->buysModel
        ->where("buys.id",$id)
        ->set(["file"=>$rename_file])
        ->update();

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', "Berkas Retur Berhasil Di upload");

        return redirect()->back();
    }

    public function purchase_delete_shipping_receipt($buys){
        $buyData = $this->buysModel->where("id",$buys)->first();

        if($buyData->file == NULL){
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', "Berkas pengiriman pembelian gagal dihapus");

            return redirect()->to(base_url('products/buys/manage') . '/' . $buys);
        }

        unlink('./public/purchase_receipts/'.$buyData->file);

        $this->buysModel->where("id",$buys)->set(["file"=>NULL])->update();

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', "Berkas pengiriman pembelian berhasil dihapus");

       return redirect()->back();
    }

    public function product_buys()
    {
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
        return view('modules/buys', $data);
    }
    
    public function product_buys_admin(){

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
        ->where('contacts.name !=', "")
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
        
        return view('modules/buys_admin', $data);
    }

    public function product_buys_add()
    {
        $supplier = $this->request->getPost('supplier');
        $warehouse = $this->request->getPost('warehouse');
        // $termID = $this->request->getPost('term_id');
        // $invoiceNumber = $this->request->getPost('invoice_number');
        $date = $this->request->getPost('date');
        // $discount = $this->request->getPost('discount');
        // $tax = $this->request->getPost('tax');
        $notes = $this->request->getPost('notes');
        $data = [
            'admin_id' => $this->session->login_id,
            'supplier_id' => $supplier,
            'warehouse_id' => $warehouse,
            'payment_term_id' => 0,
            'number' => 0,
            'date' => $date,
            'discount' => 0,
            'tax' => 0,
            'notes' => $notes,
        ];
        $this->buysModel->insert($data);
        $goodBuysID = $this->buysModel->getInsertID();

        $number = "PD/".date("y")."/".date("m")."/".$goodBuysID;

        $this->buysModel->where("id",$goodBuysID)
        ->set(["number"=>$number])->update();

        $this->session->setFlashdata('notif_status', 'success');
        $this->session->setFlashdata('notif_title', 'Berhasil');
        $this->session->setFlashdata('notif_content', 'Pembelian dengan nomor faktur <b>' . $number . '</b> berhasil ditambah');

        return redirect()->to(base_url('products/buys/manage') . '/' . $goodBuysID);
    }
    
    public function product_buys_add_admin()
    {
        $supplier = $this->request->getPost('supplier');
        $warehouse = $this->request->getPost('warehouse'); 
        $date = $this->request->getPost('date'); 
        $notes = $this->request->getPost('notes');
        $data = [
            'admin_id' => $this->session->login_id,
            'supplier_id' => $supplier,
            'warehouse_id' => $warehouse,
            'payment_term_id' => 0,
            'number' => 0,
            'date' => $date,
            'discount' => 0,
            'tax' => 0,
            'notes' => $notes,
        ];
        
        $this->buysModel->insert($data);
        $goodBuysID = $this->buysModel->getInsertID();

        $number = "PD/".date("y")."/".date("m")."/".$goodBuysID;

        $this->buysModel->where("id",$goodBuysID)
        ->set(["number"=>$number])->update();

        $this->session->setFlashdata('notif_status', 'success');
        $this->session->setFlashdata('notif_title', 'Berhasil');
        $this->session->setFlashdata('notif_content', 'Pembelian dengan nomor faktur <b>' . $number . '</b> berhasil ditambah');

        return redirect()->to(base_url('products/buy/manage') . '/' . $goodBuysID);
    }


    public function product_buys_edit()
    {
        $goodBuysId = $this->request->getPost('good_buys_id');
        $supplier = $this->request->getPost('supplier');
        $invoiceNumber = $this->request->getPost('invoice_number');
        // $warehouse = $this->request->getPost('warehouse');
        $date = $this->request->getPost('date');
        $notes = $this->request->getPost('notes');

        $data = [
            'supplier_id' => $supplier,
            // 'warehouse_id' => $warehouse,
            'date' => $date,
            'notes' => $notes,
        ];

        // $stockGoodBuys = $this->stocksModel->where(['buy_id' => $goodBuysId])->get()->getResultArray();


        // if ($stockGoodBuys) {

        //     $result = array();
        //     foreach ($stockGoodBuys as $stockGoodBuy) {
        //         $result[] = array(
        //             'id' => $stockGoodBuy["id"],
        //             'date' => $date,
        //         );
        //     }
        //     $this->stocksModel->updateBatch($result, 'id');
        // }



        $this->buysModel->update($goodBuysId,  $data);
        $this->session->setFlashdata('notif_status', 'success');
        $this->session->setFlashdata('notif_title', 'Success');
        $this->session->setFlashdata('notif_content', 'Data Berhasil dengan nomor faktur <b>' . $invoiceNumber . '</b> diubah');
        return redirect()->to(base_url('products/buys/manage') . '/' . $goodBuysId);
        // dd($_POST);
    }



    public function product_buys_delete($goodBuysId)
    {
        $goodBuys = $this->buysModel->find($goodBuysId);
        // dd($goodBuys);
        if ($goodBuys) {
            $this->buysModel->delete($goodBuysId);
            $this->stocksModel->where(['buy_id' => $goodBuysId])->delete();
            $this->buyItemsModel->where(['buy_id' => $goodBuysId])->delete();

            $this->session->setFlashdata('notif_status', 'success');
            $this->session->setFlashdata('notif_title', 'Success');
            $this->session->setFlashdata('notif_content', 'data pembelian dengan nomor faktur <b>' . $goodBuys->number . '</b> berhasil di hapus');

            return redirect()->to(base_url('products/buys'));
            // return redirect()->to(base_url('/clinic-admin/good-buys-manage') . '/' . $goodBuysId);
        } else {
            // dd($goodBuys);
            $this->session->setFlashdata('notif_status', 'danger');
            $this->session->setFlashdata('notif_title', 'Danger');
            $this->session->setFlashdata('notif_content', 'Data gagal dihapus');
            return redirect()->to(base_url('product/buys'));
        }
    }
}
