<?php

namespace App\Controllers;

class SpvGrosir extends BaseController
{
    protected $session;
    protected $validation;
    protected $db;

    protected $adminModel;

    private $productCategoriesModel;
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

        if($this->session->login_id == null){            
            $this->session->setFlashdata('msg', 'Maaf, Silahkan login terlebih dahulu!');
            header("location:".base_url('/'));
            exit();
        }else{
            if(config("Login")->loginRole != 5){
                header("location:".base_url('/dashboard'));
                exit();
            }
        }
    }

    public function products()
    {
        $products = $this->productModel
            ->where("trash", 0)
            ->orderBy("name", "asc")
            ->get()
            ->getResultObject();        

        $data = ([
            "db"                => $this->db,
            "products"       => $products,
        ]);

        return view('spvgrosir/products', $data);
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

        $data = ([
            "product"   => $product,
            "thisCategory"   => $category,
            "thisCode"   => $code,
            "categories"   => $categories,
            "codes"   => $codes,
            "db"        => $this->db,
        ]);

        return view("spvgrosir/product_manage",$data);
    }
    public function product_price_set($price, $product, $status){
        $this->productPriceModel
        ->where("id",$price)
        ->set([
            "approve_spv_grosir_status" => $status,
            "spv_grosir_id" => $this->session->login_id,
            "date_spv_grosir_approve"   => date("Y-m-d")
        ])->update();

        if($status == 2){
            $this->session->setFlashdata('message_type', 'success');
            $this->session->setFlashdata('message_content', 'Harga berhasil disetujui');

            return redirect()->to(base_url('spv/grosir/products/'.$product.'/manage'));
        }else{
            $this->session->setFlashdata('message_type', 'success');
            $this->session->setFlashdata('message_content', 'Harga berhasil tidak disetujui');

            return redirect()->to(base_url('spv/grosir/products/'.$product.'/manage'));
        }
    }

    public function price_approval(){
        $prices = $this->db->table("product_prices");
        $prices->select("product_prices.level as 'price_level'");
        $prices->select("product_prices.percentage as 'price_percentage'");
        $prices->select("products.id as 'product_id'");
        $prices->select("products.name as 'product_name'");
        $prices->select("products.price as 'product_price'");
        $prices->select("products.sku_number as 'product_sku_number'");
        $prices->select("categories.name as 'category_name'");
        $prices->select("codes.name as 'code_name'");
        $prices->join("products","product_prices.product_id=products.id","left");
        $prices->join("categories","products.category_id=categories.id","left");
        $prices->join("codes","products.code_id=codes.id","left");
        $prices->where("product_prices.approve_spv_grosir_status",1);
        $prices->orderBy("product_prices.level","desc");
        $prices->orderBy("product_prices.date_created","desc");
        $prices->orderBy("product_prices.id","desc");

        $prices = $prices->get();
        $prices = $prices->getResultObject();

        $data = ([
            "prices"          => $prices,
        ]);

        return view("spvgrosir/price_approval",$data);
    }

    public function sales(){
        $sales = $this->saleModel
        ->orderBy("transaction_date","desc")
        ->orderBy("id","desc")->findAll();

        $data = ([
            "sales" => $sales,  
            "db"    => $this->db,
        ]);

        return view("spvgrosir/sales",$data);
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

        return view("spvgrosir/sales_manage",$data);
    }
}