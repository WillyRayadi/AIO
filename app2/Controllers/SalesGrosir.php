<?php

namespace App\Controllers;

class SalesGrosir extends BaseController
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
    private $contactModel;
    private $warehouseModel;
    private $vehicleModel;
    private $paymentModel;
    private $saleModel;
    private $saleItemModel;
    private $tagModel;
    private $promoModel;

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
        $this->contactModel = new \App\Models\Contact();
        $this->warehouseModel = new \App\Models\Warehouse();
        $this->vehicleModel = new \App\Models\Vehicle();
        $this->paymentModel = new \App\Models\PaymentTerm();
        $this->saleModel = new \App\Models\Sale();
        $this->saleItemModel = new \App\Models\SaleItem();
        $this->tagModel = new \App\Models\Tag();
        $this->promoModel = new \App\Models\Promo();

        if($this->session->login_id == null){            
            $this->session->setFlashdata('msg', 'Maaf, Silahkan login terlebih dahulu!');
            header("location:".base_url('/'));
            exit();
        }else{
            if(config("Login")->loginRole != 3){
                header("location:".base_url('/dashboard'));
                exit();
            }
        }
    }


    public function sales(){
        $sales = $this->saleModel
        ->where("admin_id",$this->session->login_id)
        ->orderBy("transaction_date","desc")
        ->orderBy("id","desc")->findAll();

        $data = ([
            "sales" => $sales,  
            "db"    => $this->db,
        ]);

        return view("salesgrosir/sales",$data);
    }
    public function sales_add(){
        $contacts = $this->contactModel
        ->where("type",2)
        ->where("trash",0)
        ->orderBy("name","asc")
        ->findAll();

        $warehouses = $this->warehouseModel
        ->where("trash",0)
        ->orderBy("name","asc")
        ->findAll();

        $payments = $this->paymentModel
        ->where("trash",0)
        ->orderBy("name","asc")
        ->findAll();

        $tags = $this->tagModel
        ->orderBy("name","asc")
        ->findAll();

        $data = ([
            "contacts"  => $contacts,
            "warehouses"=> $warehouses,
            "payments"=> $payments,
            "tags"=> $tags,
        ]);

        return view("/salesgrosir/sales_add",$data);
    }
    public function ajax_sales_add_contact_data(){
        $id = $this->request->getPost('id');
        $row = $this->contactModel->where("id",$id)->first();
        echo json_encode($row);
    }
    public function ajax_sales_add_expired_data(){
        $id = $this->request->getPost('id');
        $row = $this->paymentModel->where("id",$id)->first();

        echo date("Y-m-d",strtotime("+".$row->due_date." days"));
    }
    public function sales_insert(){
        $contact = $this->request->getPost('contact');
        $invoice_address = $this->request->getPost('invoice_address');
        $sales_notes = $this->request->getPost('sales_notes');
        $transaction_date = $this->request->getPost('transaction_date');
        $expired_date = $this->request->getPost('expired_date');
        $payment = $this->request->getPost('payment');
        $reference = $this->request->getPost('reference');
        $tags = $this->request->getPost('tags');
        $warehouse = $this->request->getPost('warehouse');

        $thisTags = NULL;

        foreach($tags as $tag){
            $thisTags .= $tag.", ";
        }
        // echo $thisTag;


        $maxId = $this->db->table("sales");
        $maxId->selectMax("id");
        $maxId = $maxId->get();
        $maxId = $maxId->getFirstRow();
        $maxId = $maxId->id;

        $thisID = $maxId + 1;

        $transaction_number = "SO/".date("y")."/".date("m")."/".$thisID;

        $this->saleModel
        ->insert([
            "id"    => $thisID,
            "number"    => $transaction_number,
            "admin_id"    => $this->session->login_id,
            "contact_id"    => $contact,
            "warehouse_id"=> $warehouse,
            "invoice_address"=> $invoice_address,
            "sales_notes"=> $sales_notes,
            "transaction_date"  => $transaction_date,
            "expired_date"  => $expired_date,
            "payment_id"    => $payment,
            "customer_reference_code"=> $reference,
            "tags"  => $thisTags,
            "status"    => 1,
        ]);

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Pesanan penjualan berhasil dibuat');

        return redirect()->to(base_url('sales/grosir/sales/'.$thisID.'/manage'));
    }    
    public function sales_manage($id){
        $sale = $this->saleModel->where("id",$id)->where("admin_id",$this->session->login_id)->first();

        if($sale == NULL){
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', 'Data tidak ditemukan');

            return redirect()->to(base_url('dashboard'));
        }

        $contacts = $this->contactModel
        ->where("type",2)
        ->where("trash",0)
        ->orderBy("name","asc")
        ->findAll();

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

        if($sale->status == 1){
            return view("salesgrosir/sales_manage",$data);
        }else{
            return view("salesgrosir/sales_manage_fix",$data);
        }
    }
    public function sales_save(){
        $id = $this->request->getPost('id');
        $contact = $this->request->getPost('contact');
        $invoice_address = $this->request->getPost('invoice_address');
        $sales_notes = $this->request->getPost('sales_notes');
        $transaction_date = $this->request->getPost('transaction_date');
        $expired_date = $this->request->getPost('expired_date');
        $payment = $this->request->getPost('payment');
        $reference = $this->request->getPost('reference');
        $tags = $this->request->getPost('tags');

        $thisTags = NULL;

        foreach($tags as $tag){
            $thisTags .= "#".$tag;
        }
        // echo $thisTag;

        if($this->request->getPost('sales_notes')){
            $sales_notes = $this->request->getPost('sales_notes');
        }else{
            $sales_notes = NULL;
        }

        $this->saleModel
        ->where("id",$id)
        ->set([
            "contact_id"    => $contact,
            "invoice_address"=> $invoice_address,
            "sales_notes"=> $sales_notes,
            "transaction_date"  => $transaction_date,
            "expired_date"  => $expired_date,
            "payment_id"    => $payment,
            "customer_reference_code"=> $reference,
            "tags"  => $thisTags,
            "sales_notes"=> $sales_notes,
        ])->update();

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Pesanan penjualan berhasil disimpan');

        return redirect()->to(base_url('sales/grosir/sales/'.$id.'/manage'));
    }
    public function ajax_sale_product_stocks(){
        $product = $this->request->getPost('product');
        $warehouse = $this->request->getPost('warehouse');

        $stocks = $this->db->table("product_stocks");
        $stocks->selectSum("product_stocks.quantity");
        $stocks->select("products.unit as 'product_unit'");
        $stocks->join("products","product_stocks.product_id=products.id","right");
        $stocks->where("product_stocks.product_id",$product);
        $stocks->where("product_stocks.warehouse_id",$warehouse);

        $stocks = $stocks->get();
        $stocks = $stocks->getFirstRow();

        if($stocks->quantity <= 0){
            echo "0~".$stocks->product_unit;
        }else{
            echo $stocks->quantity."~".$stocks->product_unit;
        }
    }
    public function ajax_sale_product_prices(){
        $id = $this->request->getPost('product');

        $product = $this->productModel->where("id",$id)->first();
        
        $rumus = $this->productPriceModel->where("id",$product->price_id)->first();

        $margins = ([
            0, // 0
            $rumus->plus_one, // margin ke-1
            $rumus->plus_two, // margin ke-2
            $rumus->plus_three, // margin ke-3
            $rumus->plus_four, // margin ke-4
            $rumus->plus_five, // margin ke-5
            $rumus->plus_six, // margin ke-6
            $rumus->plus_seven, // margin ke-7
            $rumus->plus_eight, // margin ke-8
            $rumus->plus_nine, // margin ke-9
            $rumus->plus_ten, // margin ke-10
        ]);

        $arrayPrices = ([0]);

        $thisPrice = floatval($product->price);
        array_push($arrayPrices,$thisPrice);
        for($p = 2; $p <= 10; $p++){
            $thisPrice += $margins[$p];
            $thisPrice = (round(($thisPrice + config("App")->priceRound / 2) / config("App")->priceRound) * config("App")->priceRound);
            array_push($arrayPrices, $thisPrice);
        }

        for($x = 1; $x <= 10; $x++){
            echo"<option value='".$x."-".$arrayPrices[$x]."'>($x) Rp. ".number_format($arrayPrices[$x],0,",",".")."</option>";
        }
    }
    public function ajax_sale_product_promos(){
        $product = $this->request->getPost('product');
        $promos = $this->promoModel
        ->where("product_id", $product)
        ->orderBy("code","asc")
        ->where("date_start <=",date("Y-m-d"))
        ->where("date_end >=",date("Y-m-d"))
        ->findAll();
        echo"<option value='0'>--Tanpa Promo--</option>";
        foreach($promos as $promo){
            echo"<option value='".$promo->id."'>".$promo->code."-".$promo->details."</option>";
        }
    }

    public function sale_item_add(){
        $sale = $this->request->getPost('sale');
        $warehouse = $this->request->getPost('warehouse');
        $product = $this->request->getPost('product');
        $price = $this->request->getPost('price');
        $qty = $this->request->getPost('qty');
        $tax = $this->request->getPost('tax');
        $promo = $this->request->getPost('promo');

        $thisSale = $this->saleModel->where("id",$sale)->first();

        $explodePrice = explode("-",$price);
        $thisPriceLevel = $explodePrice[0];
        $thisPriceValue = $explodePrice[1];
        
        if($thisPriceLevel == 3){
            $dataInsert = ([
                "sale_id"   => $sale,
                "product_id"   => $product,
                "quantity" => $qty,
                "price" => $thisPriceValue,
                "price_level" => $thisPriceLevel,
                "tax"   => $tax,
                "promo_id"   => $promo,
                "need_approve"=>2,
            ]);
        }elseif($thisPriceLevel <= 2){
            $dataInsert = ([
                "sale_id"   => $sale,
                "product_id"   => $product,
                "quantity" => $qty,
                "price" => $thisPriceValue,
                "price_level" => $thisPriceLevel,
                "tax"   => $tax,
                "promo_id"   => $promo,
                "need_approve"=>3,
            ]);
        }else{
            $dataInsert = ([
                "sale_id"   => $sale,
                "product_id"   => $product,
                "quantity" => $qty,
                "price" => $thisPriceValue,
                "price_level" => $thisPriceLevel,
                "tax"   => $tax,
                "promo_id"   => $promo,
                "need_approve"=>0,
            ]);
        }


        $this->saleItemModel->insert($dataInsert);

        $saleItemID = $this->saleItemModel->getInsertID();

        $qtyStock = 0 - $qty;
        $this->productStockModel->insert([
            "product_id"    => $product,
            "warehouse_id" => $warehouse,
            "sale_item_id" => $saleItemID,
            "date"  => date("Y-m-d"),
            "quantity"  => $qtyStock,
        ]);

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Barang berhasil ditambahkan ke dalam pesanan penjualan');

        return redirect()->to(base_url('sales/grosir/sales/'.$sale.'/manage'));
    }
    public function sales_item_delete($sale,$item){
        $thisItem = $this->saleItemModel->where("id",$item)->first();

        // if($thisItem->price_level <= 3){
        //     $this->saleModel->where("id",$sale)
        //     ->set([
        //         "need_approve_spv_grosir"=>0,
        //         "need_approve_owner"=>0,
        //     ])->update();            
        // }
        
        $this->saleItemModel->where("id",$item)->delete();
        $this->productStockModel->where("sale_item_id",$item)->delete();
        
        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Barang berhasil dihapus dari daftar penjualan');

        return redirect()->to(base_url('sales/grosir/sales/'.$sale.'/manage'));
    }
    public function sales_delete($id){
        $sale = $this->saleModel->where("id",$id)->first();

        $items = $this->saleItemModel
        ->where("sale_id",$id)
        ->findAll();

        if(count($items) <= 0){
            $this->saleModel->delete($id);
            $this->session->setFlashdata('message_type', 'success');
            $this->session->setFlashdata('message_content', 'Penjualan (SO) berhasil dihapus');

            return redirect()->to(base_url('sales/grosir/sales/'));
        }else{
            $this->session->setFlashdata('message_type', 'warning');
            $this->session->setFlashdata('message_content', 'Penjualan (SO) gagal dihapus');

            return redirect()->to(base_url('sales/grosir/sales/'.$id.'/manage'));
        }
    }
}