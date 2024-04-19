<?php

namespace App\Controllers;

class SalesRetail extends BaseController
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
            if(config("Login")->loginRole != 2){
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

        return view("salesretail/sales",$data);
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

        return view("/salesretail/sales_add",$data);
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

        return redirect()->to(base_url('sales/retail/sales/'.$thisID.'/manage'));
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

        $warehouse = $this->warehouseModel
        ->where("id",$sale->warehouse_id)
        ->first();

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
            "contact"   => $contact,
            "payment" => $payment,
            "warehouse"          => $warehouse,
        ]);

        if($sale->status == 1){
            return view("salesretail/sales_manage",$data);
        }else{
            return view("salesretail/sales_manage_fix",$data);
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
            $thisTags .= $tag.", ";
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

        return redirect()->to(base_url('sales/retail/sales/'.$id.'/manage'));
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

        $prices = $this->productPriceModel
        ->where("product_id",$id)
        ->where("approve_owner_status",2)
        ->where("approve_spv_retail_status",2)
        ->where("approve_spv_grosir_status",2)
        ->where("level >=",2)
        ->orderBy("level","asc")->findAll();

        $product = $this->productModel->where("id",$id)->first();

        foreach($prices as $price){
            $thisPrice = $product->price + ($product->price * $price->percentage / 100);
            $thisPrice = round(($thisPrice + config("App")->priceRound / 2) / config("App")->priceRound) * config("App")->priceRound;
            echo"<option value='$thisPrice'>(".$price->level.") Rp. ".number_format($thisPrice,0,",",".")."</option>";
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

        $this->saleItemModel->insert([
            "sale_id"   => $sale,
            "product_id"   => $product,
            "quantity" => $qty,
            "price" => $price,
            "tax"   => $tax,
            "promo_id"   => $promo,
        ]);

        $saleItem = $this->saleItemModel
        ->where("product_id", $product)
        ->where("sale_id", $sale)
        ->first();

        $qtyStock = 0 - $qty;
        $this->productStockModel->insert([
            "product_id"    => $product,
            "warehouse_id" => $warehouse,
            "sale_item_id" => $saleItem->id,
            "date"  => date("Y-m-d"),
            "quantity"  => $qtyStock,
        ]);

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Barang berhasil ditambahkan ke dalam pesanan penjualan');

        return redirect()->to(base_url('sales/retail/sales/'.$sale.'/manage'));
    }
    public function sales_item_delete($sale,$item){
        $this->saleItemModel->where("id",$item)->delete();
        $this->productStockModel->where("sale_item_id",$item)->delete();

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Barang berhasil dihapus dari daftar penjualan');

        return redirect()->to(base_url('sales/retail/sales/'.$sale.'/manage'));
    }
}