<?php

namespace App\Controllers;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Hermawan\DataTables\DataTable;

class Product extends Admin
{
    private $buyModel;
    private $buyItemModel;
    private $saleModel;
    private $saleItemModel;
    private $goodCategoriesModel;
    private $goodsModel;
    private $goodStocksModel;
    private $codeModel;
    private $warehouseModel;
    private $productPriceModel;
    private $productStockModel;
    private $productRepairModel;
    private $productReturnModel;
    private $subModel;
    private $brandModel;
    private $capacityModel;
    private $voucherModel;
    private $deliveryModel;
    private $userModel;
    private $baseController;
    
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->db = \Config\Database::connect();
        $this->validation =  \Config\Services::validation();
        $this->buyItemModel = new \App\Models\BuyItem();
        $this->buyModel = new \App\Models\Buy();
        $this->goodCategoriesModel = new \App\Models\Category();
        $this->goodsModel = new \App\Models\Product();
        $this->goodStocksModel = new \App\Models\Stock();
        $this->codeModel = new \App\Models\Code();
        $this->saleModel = new \App\Models\Sale();
        $this->saleItemModel = new \App\Models\SaleItem();
        $this->warehouseModel = new \App\Models\Warehouse();
        $this->productPriceModel = new \App\Models\ProductPrice();
        $this->productStockModel = new \App\Models\ProductStock();
        $this->subModel = new \App\Models\SubCategory();
        $this->brandModel = new \App\Models\Brands();
        $this->capacityModel = new \App\Models\Capacity();
        $this->productRepairModel = new \App\Models\ProductRepair();
        $this->productReturnModel = new \App\Models\ProductReturn();
        $this->voucherModel = model("App\Models\Voucher");
        $this->deliveryModel = model("App\Models\DeliveryItem");
        $this->userModel = model("App\Models\Administrator");
        $this->baseController = new \App\Controllers\BaseController();
        
        helper("form");

        if($this->session->login_id == null){            
            $this->session->setFlashdata('msg', 'Maaf, Silahkan login terlebih dahulu!');
            header("location:".base_url('/'));
            exit();
        }else{
            if(config("Login")->loginRole != 1){
                if(config("Login")->loginRole != 8){
                if(config("Login")->loginRole != 4){
                    if(config("Login")->loginRole != 5){
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
    
    public function upload_file_image(){
        $id = $this->request->getPost('id');

        $products = $this->goodsModel
        ->select([
            'products.id',
            'products.name'
        ])
        ->where('products.id', $id)
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
        $rename_file = "product_id_".$id.".".$ext;
        $uploaddir = './public/product_image/';
        $alamatfile = $uploaddir . $rename_file;

        move_uploaded_file($_FILES['file']['tmp_name'], $alamatfile);

        $this->goodsModel
        ->where("products.id",$id)
        ->set(["files"=>$rename_file])
        ->update();

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', "Gambar Produk Berhasil Di upload");

        return redirect()->back();
    }

    public function upload_files1_images(){
        $id = $this->request->getPost('id');

        $products = $this->goodsModel
        ->select([
            'products.id',
            'products.name'
        ])
        ->where('products.id', $id)
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
        $rename_file = "product_id_behind_".$id.".".$ext;
        $uploaddir = './public/product_image/';
        $alamatfile = $uploaddir . $rename_file;

        move_uploaded_file($_FILES['file']['tmp_name'], $alamatfile);

        $this->goodsModel
        ->where("products.id",$id)
        ->set(["files1"=>$rename_file])
        ->update();

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', "Gambar Produk Berhasil Di upload");

        return redirect()->back();
    }
    
    public function upload_files2_images(){
        $id = $this->request->getPost('id');

        $products = $this->goodsModel
        ->select([
            'products.id',
            'products.name'
        ])
        ->where('products.id', $id)
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
        $rename_file = "product_id_left".$id.".".$ext;
        $uploaddir = './public/product_image/';
        $alamatfile = $uploaddir . $rename_file;

        move_uploaded_file($_FILES['file']['tmp_name'], $alamatfile);

        $this->goodsModel
        ->where("products.id",$id)
        ->set(["files2"=>$rename_file])
        ->update();

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', "Gambar Produk Berhasil Di upload");

        return redirect()->back();
    }

    
    public function upload_files3_images(){
        $id = $this->request->getPost('id');

        $products = $this->goodsModel
        ->select([
            'products.id',
            'products.name'
        ])
        ->where('products.id', $id)
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
        $rename_file = "product_id_right".$id.".".$ext;
        $uploaddir = './public/product_image/';
        $alamatfile = $uploaddir . $rename_file;

        move_uploaded_file($_FILES['file']['tmp_name'], $alamatfile);

        $this->goodsModel
        ->where("products.id",$id)
        ->set(["files3"=>$rename_file])
        ->update();

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', "Gambar Produk Berhasil Di upload");

        return redirect()->back();
    }

    public function delete_image_product($id){
        $products = $this->goodsModel
        ->where('products.id', $id)
        ->get()->getFirstRow();

        if($products->files == NULL){
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', "Gambar gagal dihapus");

            return redirect()->back();
        }

        unlink('./public/product_image/'.$products->files);

        $this->goodsModel
        ->where("products.id",$id)
        ->set(["files" => NULL])->update();

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', "Berkas pengiriman berhasil dihapus");

        return redirect()->back();
    }

    public function delete_file_behind_product($id){
        $products = $this->goodsModel
        ->where('products.id', $id)
        ->get()->getFirstRow();

        if($products->files1 == NULL){
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', "Gambar gagal dihapus");

            return redirect()->back();
        }

        unlink('./public/product_image/'.$products->files1);

        $this->goodsModel
        ->where("products.id",$id)
        ->set(["files1" => NULL])->update();

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', "Berkas pengiriman berhasil dihapus");

        return redirect()->back();
    }

    public function delete_file_left_product($id){
        $products = $this->goodsModel
        ->where('products.id', $id)
        ->get()->getFirstRow();

        if($products->files2 == NULL){
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', "Gambar gagal dihapus");

            return redirect()->back();
        }

        unlink('./public/product_image/'.$products->files2);

        $this->goodsModel
        ->where("products.id",$id)
        ->set(["files2" => NULL])->update();

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', "Berkas pengiriman berhasil dihapus");

        return redirect()->back();
    }

    public function delete_file_right_product($id){
        $products = $this->goodsModel
        ->where('products.id', $id)
        ->get()->getFirstRow();

        if($products->files3 == NULL){
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', "Gambar gagal dihapus");

            return redirect()->back();
        } 

        unlink('./public/product_image/'.$products->files3);

        $this->goodsModel
        ->where("products.id",$id)
        ->set(["files3" => NULL])->update();

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', "Berkas pengiriman berhasil dihapus");

        return redirect()->back();
    }

    public function ajaxGetStocks()
    {
        $product_id = $this->request->getVar("product_id");
        
        $userAllowedWarehouse = $this->userModel
        ->select(["allow_warehouses"])
        ->where("administrators.id", $this->session->login_id)
        ->first();
        
        if ($userAllowedWarehouse && !empty($userAllowedWarehouse->allow_warehouses)) {
            
            $allowedWarehouse = explode(",", $userAllowedWarehouse->allow_warehouses);
        
            $allowedWarehouse = array_map(function ($item) {
                return str_replace(['"', "'"], '', $item);
            }, $allowedWarehouse);
        
        
            $allowedWarehouse = array_filter($allowedWarehouse);
            
        }
        
        $warehouses = $this->warehouseModel->select(["id", "name"])->whereIn("id", $allowedWarehouse)->orderBy("name", "asc")->findAll();
        
        $warehouse_id = array_column($warehouses, "id");
        
        $productStock = $this->productStockModel
        ->select(["warehouse_id","SUM(quantity) as stock_quantity"])
        ->where("product_id", $product_id)
        ->whereIn("warehouse_id", $warehouse_id)
        ->groupBy(["product_id", "warehouse_id"])
        ->findAll();
        
        $prepareData = $this->prepareStock($warehouses, $productStock);
        
        $json = json_encode($prepareData);
        
        return $json;
        
    }
    
    public function prepareStock($warehouses, $productStock){
        $processData = [];
        foreach($warehouses as $warehouse){
            $rowData = [];
            $warehouse_id = $warehouse->id;
            $stockQty = $this->findStock($productStock, $warehouse_id);
            $rowData[$warehouse->name] = $stockQty. " Unit";
            $processData[] = $rowData;
        }
        
        return $processData;
    }
    
    public function findStock($data, $warehouse_id)
    {
        foreach($data as $item)
        {
            if($item->warehouse_id == $warehouse_id){
                return $item->stock_quantity;
            }
        }
        
        return "0";
    }
    
    public function voucher()
    {
        $data = ["voucher" => $this->voucherModel->select(["products.name as product_name","voucher.id","voucher.voucher_value", "voucher.validity_period"])->join("products","voucher.product_id = products.id","left")->findAll()];
        
        return view("modules/voucher", $data);
    }
    
    public function edit_voucher($id)
    {
        return view("modules/voucher_edit", $data = ["voucher" => $this->voucherModel->find($id), "products" => $this->goodsModel->select(["id","name"])->orderBy("name", "asc")->findAll()]);
    }
    
    public function add_voucher()
    {
        $products = $this->request->getVar("product_id");
        $image = $this->request->getFile("image");
        $warehouseName = $this->request->getVar("warehouse_name");
        $quantity = $this->request->getVar("quantity");
        
        $warehouses = $this->warehouseModel->select(["id"])->where("name", $warehouseName)->first();

        $imageName = $image->getRandomName();
        
        $image->move('./public/image', $imageName);
        
        // try{
            
        //     $stockQuantity = $this->checkStocks($products, $warehouses->id, $quantity);
            
        // }catch(\Exception $e){
        //     $this->session->setFlashdata('message_type', 'warning');
        //     $this->session->setFlashdata('message_content', 'Kuantitas Melebihi Stok Tersedia');
            
        //     return redirect()->back();
        // }
        
         $data = [
            "product_id" => $products,
            "warehouse_id" => $warehouses->id,
            "quantity" => $quantity,
            "image" => $imageName,
            "voucher_value" => $this->request->getPost("voucher_value"),
            "validity_period" => $this->request->getPost("validity_period"),
            "description" => $this->request->getPost("description"),
            "required_points" => $this->request->getPost("required_points"),
        ];
        
        $this->voucherModel->insert($data);
        
        // $voucherID = $this->voucherModel->getInsertID();
        
        // $this->productStockModel->insert([
        //     "product_id" => $products,
        //     "warehouse_id" => $warehouses->id,
        //     "quantity" => $stockQuantity,
        //     "date" => date("Y-m-d"),
        //     "voucher_id" => $voucherID
        // ]);

        return redirect()->to(base_url("products/voucher"));
    }
    
    private function checkStocks($productID, $warehouseID, $quantity){
        $productStocks = $this->productStockModel
        ->select(["SUM(quantity) as stocks"])
        ->where("product_id", $productID)
        ->where("warehouse_id", $warehouseID)
        ->where("sale_item_id IS NULL")
        ->orderBy("date", "asc")
        ->first();
        
        $stockQuantity = $productStocks->stocks;
        $totalStocks = 0;
        
        if($quantity <= $stockQuantity)
        {
            $totalStocks = -$quantity;
        }else{
            throw new \Exception('Kuantitas melebihi stok tersedia');
        }
        
        
        return $totalStocks;
    }
    
    public function save_voucher()
    {
        $id = $this->request->getVar("id");
        $product_id = $this->request->getVar("product_id");
        $value = $this->request->getVar("voucher_value");
        $valid = $this->request->getVar("validity_period");
        $point = $this->request->getVar("required_points");
        $desc = $this->request->getVar("description");

        $voucher = $this->voucherModel->find($id);

        $image = $this->request->getFile("image");

        if ($image->isValid() && !$image->hasMoved()) {

            $oldImage = $voucher->image;

            if (file_exists("./public/image/" . $oldImage)) {
                unlink("./public/image/" . $oldImage);

                $imageName = $image->getRandomName();
                $image->move("./public/image/", $imageName);
            }
        } else {
            $imageName = $voucher->image;
        }

        $data = [
            "product_id" => $product_id,
            "voucher_value" => $value,
            "validity_period" => $valid,
            "required_points" => $point,
            "description" => $desc,
            "image" => $imageName
        ];
        

        $this->voucherModel->update($id, $data);

        return redirect()->to(base_url("products/voucher"));
    }
    
    public function delete_voucher($id){
        $voucher = $this->voucherModel->find($id);
        
        $imagePath = './public/image/'.$voucher->image;
        if(file_exists($imagePath))
        {
            unlink($imagePath);
        }
        
        // $this->productStockModel->where("voucher_id", $id)->delete();
        
        $this->voucherModel->delete($id);
        
        return redirect()->to(base_url("products/voucher"));
    }
    
    public function products_categories()
    {
        $products_categories = $this->goodCategoriesModel
        ->where("trash", 0)
        ->orderBy("name", "asc")
        ->get()
        ->getResultObject();

        $data = ([
            "products_categories" => $products_categories,
        ]);

        return view('modules/products_categories', $data);
    }

    public function products_categories_add()
    {
        $cek_tidak_berkategori = $this->goodCategoriesModel
            ->where("name", "Tidak Berkategori")
            ->findAll();

        if ($cek_tidak_berkategori == NULL) {
            $this->goodCategoriesModel->insert([
                "name"          => "Tidak Berkategori",
                "trash"         => 0,
            ]);
        }

        $name = $this->request->getPost("name");

        $this->goodCategoriesModel->insert([
            "name"          => $name,
            "trash"         => 0,
        ]);

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Kategori <b>' . $name . '</b> berhasil ditambahkan');

        return redirect()->to(base_url('products/categories'));
    }

    public function products_categories_edit()
    {
        $id = $this->request->getPost("id");
        $name = $this->request->getPost("name");

        $this->goodCategoriesModel->update($id, ([
            "name"          => $name,
        ]));

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Kategori <b>' . $name . '</b> berhasil diubah');

        return redirect()->to(base_url('products/categories'));
    }

    public function products_categories_delete($id)
    {
        $thisUncategorized = $this->goodCategoriesModel->where("name", "Tidak Berkategori")->first();
        $thisCategory = $this->goodCategoriesModel->where("id", $id)->first();

        if ($thisCategory->name === "Tidak Berkategori") {
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', 'gagal hapus data !');

            return redirect()->to(base_url('products/categories'));
        } else {
            $this->goodsModel
                ->where("category_id", $id)
                ->set(['category_id' => $thisUncategorized->id])
                ->update();

            $this->goodCategoriesModel->update($id, ([
                "trash"          => 1,
            ]));

            $this->session->setFlashdata('message_type', 'success');
            $this->session->setFlashdata('message_content', 'Kategori <b>' . $thisCategory->name . '</b> berhasil dihapus');

            return redirect()->to(base_url('products/categories'));
        }
    }
    

    public function fetchProducts()
    {
        $products = $this->goodsModel
        ->select(["id", "name", "code_id", "sku_number" ,"capacity_id" ,"category_id" , "unit"])
        ->where("trash", 0)
        ->orderBy("name", "asc")
        ->findAll();
        
        $warehouses = $this->warehouseModel
        ->select(["id", "name"])
        ->where("trash" , 0)
        // ->whereNotIn("id", ["10"])
        ->orderBy("name", "asc")
        ->findAll();
        
        $categoryQuery = $this->goodCategoriesModel
        ->select(["id", "name"])
        ->whereIn("id", array_column($products, "category_id"))
        ->findAll();
        
        $codeQuery = $this->codeModel->select(["id", "name"])->whereIn("id", array_column($products, "code_id"))->findAll();
        $capacityQuery = $this->capacityModel->select(["id", "kapasitas"])->whereIn("id", array_column($products, "capacity_id"))->findAll();
        $subQuery = $this->subModel->select(["name", "code"])->whereIn("code", array_column($codeQuery, "name"))->findAll();
        
        $productID = array_column($products, "id");
        $warehouseID = array_column($warehouses, "id");
        
        
        $productStocks = $this->productStockModel
        ->select(["product_id", "warehouse_id", "id", "SUM(quantity) as stock_quantity"])
        ->whereIn("warehouse_id", $warehouseID)
        ->whereIn("product_id", $productID)
        ->groupBy(["warehouse_id", "product_id"])
        ->findAll();
        
        $productRepairs = $this->productRepairModel
        ->select(["product_id", "id", "SUM(quantity) as repair_quantity"])
        ->whereIn("product_id", $productID)
        ->groupBy("product_id")
        ->findAll();
        
        // $productReturns = $this->productReturnModel
        // ->select(["product_id", "id", "SUM(quantity) as return_quantity"])
        // ->whereIn("product_id", $productID)
        // ->groupBy("product_id")
        // ->findAll();
        
        $productSales = $this->saleItemModel
        ->select(["product_id", "sale_items.id", "SUM(quantity) as sale_quantity"])
        ->join("sales", "sale_items.sale_id = sales.id", "left")
        ->whereIn("product_id", $productID)
        ->where("sales.status <", 5)
        ->groupBy("product_id")
        ->findAll();
        
        
        return [
          "products" => $products,
          "warehouses" => $warehouses,
          "categories" => $categoryQuery,
          "product_stocks" => $productStocks,
          "product_repairs" => $productRepairs,
          "product_capacity" => $capacityQuery,
          "product_sub_category" => $subQuery,
          "product_sales" => $productSales,
          "product_codes" => $codeQuery
        ];
    }
    
    public function ajaxGetAllIndentQuantity()
    {
        $data = $this->fetchProducts();

        $products = $data["products"];

        $indent = $this->productStockModel
            ->select(["SUM(quantity) as total_indent", "product_id"])
            ->whereIn("product_id", array_column($products, "id"))
            ->where("product_stocks.warehouse_id", 6)
            ->groupBy("product_id")
            ->findAll();

        $prepare = $this->prepareAllIndentData($products, $indent);

        return $this->response->setJSON($prepare);
    }

    public function ajaxGetIndentLocation()
    {
        $location = $this->request->getVar("location");

        $data = $this->fetchProducts();

        $products = $data["products"];

        if (!empty($location)) {
            $indent = $this->productStockModel
                ->select(["SUM(quantity) as total_indent", "product_id"])
                ->whereIn("product_id", array_column($products, "id"))
                ->whereIn("inden_warehouse_id", [$location])
                ->groupBy("product_id")
                ->findAll();

            $prepare = $this->prepareAllIndentData($products, $indent);

            return $this->response->setJSON($prepare);
        } else {
            return $this->response->setJSON(["Error" => "Invalid Location Parameter"]);
        }
    }

    public function ajaxGetQuantityFromIndentWarehouse()
    {
        $warehouseName = $this->request->getVar("inden_warehouse");

        $warehouse = $this->warehouseModel->select(["id"])->where("name", $warehouseName)->first();

        $data = $this->fetchProducts();

        $products = $data["products"];

        if (!empty($warehouseName)) {
            $productIndent = $this->productStockModel
                ->select(["SUM(quantity) as total_indent", "product_id"])
                ->where("inden_warehouse_id", $warehouse->id)
                ->whereIn("product_stocks.product_id", array_column($products, "id"))
                ->groupBy(["product_stocks.product_id"])
                ->findAll();

            $prepare = $this->prepareStockForIndent($products, $productIndent);

            return $this->response->setJSON($prepare);
        } else {
            return $this->response->setJSON(["Error" => "Indent Warehouse Cannot Be Indentified"]);
        }
    }
    
    public function getSalesQuantity()
    {
        $warehouseName = $this->request->getVar("warehouse_id");
        
        $warehouses = $this->warehouseModel->where("trash", 0);
        
        if(!empty($warehouseName) && $warehouseName != "Pilih"){
            $warehouses->where("id", $warehouseName);
        }
        
        $warehouses = $warehouses->orderBy("name", "asc")->findAll();
        
        $data = $this->fetchProducts();
        
        $products = $data['products'];
        $warehouseID = array_column($warehouses, "id");
        
        // $productSales = $this->saleItemModel
        // ->select(["SUM(sale_items.quantity) as sale_quantity", "sale_items.product_id", "product_stocks.warehouse_id", "sales.id"])
        // ->join("sales", "sale_items.sale_id = sales.id", "left")
        // ->join("product_stocks", "sale_items.id = product_stocks.sale_item_id", "left")
        // ->whereIn("sale_items.product_id", array_column($products, "id"))
        // ->whereIn("product_stocks.warehouse_id", array_column($warehouses, "id"))
        // ->where("sales.status <", 5)
        // ->groupBy(["sale_items.product_id", "product_stocks.warehouse_id"])
        // ->findAll();

        // $items = [];
        // if($productSales)
        // {
        //     $productIDs = array_column($products, "id");
            
        //     if($warehouseName == "Pilih")
        //     {
        //         if(count($warehouseID) > 1):
        //             $items = $this->deliveryModel
        //             ->select(["SUM(delivery_items.quantity) as QtyKeluar", "sale_items.product_id", "product_stocks.warehouse_id"])
        //             ->join("sale_items", "sale_items.id = delivery_items.sale_item_id", "left")
        //             ->join("sales", "sale_items.sale_id = sales.id", "left")
        //             ->join("product_stocks", "sale_items.id = product_stocks.sale_item_id", "left")
        //             ->whereIn("sale_items.product_id", $productIDs)
        //             ->whereIn("product_stocks.warehouse_id", array_column($warehouses, "id"))
        //             ->where("sales.status <", 5)
        //             ->groupBy(["sale_items.product_id", "product_stocks.warehouse_id"])
        //             ->findAll();
        //         endif;
        //     }else{
        //         if(count($warehouseID) == 1):
        //             $items = $this->deliveryModel
        //             ->select(["SUM(delivery_items.quantity) as QtyKeluar", "sale_items.product_id", "product_stocks.warehouse_id"])
        //             ->join("sale_items", "sale_items.id = delivery_items.sale_item_id", "left")
        //             ->join("product_stocks", "sale_items.id = product_stocks.sale_item_id", "left")
        //             ->join("sales", "sales.id = sale_items.sale_id", "left")
        //             ->whereIn("sale_items.product_id", $productIDs)
        //             ->where("product_stocks.warehouse_id", $warehouseName)
        //             ->where("sales.status <", 5)
        //             ->groupBy(["sale_items.product_id", "product_stocks.warehouse_id"])
        //             ->findAll();
        //         endif;
        //     }
        // }
        
        
        // $prepareData = $this->prepareSalesQuantity($products, $items, $warehouses, $productSales);
        
        // return $this->response->setJSON($prepareData);
        
        if($warehouseName == "Pilih"){
            
            $productSales = $this->saleItemModel
            ->select(["SUM(sale_items.quantity) as sale_quantity", "sale_items.product_id", "product_stocks.warehouse_id"])
            ->join("sales", "sale_items.sale_id = sales.id", "left")
            ->join("product_stocks", "sale_items.id = product_stocks.sale_item_id", "left")
            ->whereIn("sale_items.product_id", array_column($products, "id"))
            ->whereIn("product_stocks.warehouse_id", array_column($warehouses, "id"))
            ->where("sales.status <", 5)
            ->groupBy(["sale_items.product_id"])
            ->findAll();
            
            $items = $this->deliveryModel
            ->select(["SUM(delivery_items.quantity) as QtyKeluar", "sale_items.product_id", "product_stocks.warehouse_id"])
            ->join("sale_items", "delivery_items.sale_item_id = sale_items.id", "left")
            ->join("sales", "sale_items.sale_id = sales.id", "left")
            ->join("product_stocks", "sale_items.id = product_stocks.sale_item_id", "left")
            ->whereIn("sale_items.product_id", array_column($products, "id"))
            ->whereIn("product_stocks.warehouse_id", array_column($warehouses, "id"))
            ->where("sales.status <", 5)
            ->groupBy(["sale_items.product_id"])
            ->findAll();
            
            $prepare = $this->prepareSaledQuantity($products, $productSales, $items);
            
            return $this->response->setJSON($prepare);
        }else{
            $productSales = $this->saleItemModel
            ->select(["SUM(sale_items.quantity) as sale_quantity", "sale_items.product_id", "product_stocks.warehouse_id"])
            ->join("sales", "sale_items.sale_id = sales.id", "left")
            ->join("product_stocks", "sale_items.id = product_stocks.sale_item_id", "left")
            ->whereIn("sale_items.product_id", array_column($products, "id"))
            ->where("product_stocks.warehouse_id", $warehouseName)
            ->where("sales.status <", 5)
            ->groupBy(["sale_items.product_id"])
            ->findAll();
            
            $items = $this->deliveryModel
            ->select(["SUM(delivery_items.quantity) as QtyKeluar", "sale_items.product_id", "product_stocks.warehouse_id"])
            ->join("sale_items", "delivery_items.sale_item_id = sale_items.id", "left")
            ->join("sales", "sale_items.sale_id = sales.id", "left")
            ->join("product_stocks", "sale_items.id = product_stocks.sale_item_id", "left")
            ->whereIn("sale_items.product_id", array_column($products, "id"))
            ->where("product_stocks.warehouse_id", $warehouseName)
            ->where("sales.status <", 5)
            ->groupBy(["sale_items.product_id"])
            ->findAll();
            
            $prepare = $this->prepareSalesQuantity($products, $warehouses, $productSales, $items);
            
            return $this->response->setJSON($prepare);
        }
        
    }
    
    protected function prepareSalesQuantity($products, $warehouses, $productSales, $items)
    {
        $data = [];
        foreach($products as $product){
            $rowData = [
                "product_name" => $product->name    
            ];
            foreach($warehouses as $warehouse){
                $saleQuantity = $this->findSaleProductsQuantity($productSales, $product->id, $warehouse->id);
                $deliveredQuantity = $this->findDeliveredQuantity($items, $product->id, $warehouse->id);

                
                $rowData["sale_quantity"] = $saleQuantity." Unit";
                $rowData["delivered"] = $deliveredQuantity;
            }
            
            $data[] = $rowData; 
        }
        
        return $data;
    }
    
    protected function prepareSaledQuantity($products, $productSales, $items)
    {
        $data = [];
        foreach($products as $product){
            $rowData = [
                "product_name" => $product->name,
                "sale_quantity" => $this->findSaleQuantity($productSales, $product->id),
                "delivered" => $this->findDeliveredProductsQuantity($items, $product->id)
            ];
    
            $data[] = $rowData; 
        }
        
        return $data;
    }
    
    private function prepareStockForIndent($products, $productIndent)
    {
        $data = [];
        foreach ($products as $product) {
            $productData = [
                "product_id" => $product->id,
                "product_name" => $product->name,
                "indent_quantity" => $this->findIndentQuantity($productIndent, $product->id)
            ];

            $data[] = $productData;
        }

        return $data;
    }
    
    protected function findDeliveredQuantity($data, $productID, $warehouseID)
    {
        foreach($data as $item)
        {
            if($item->product_id == $productID && $item->warehouse_id == $warehouseID){
                return $item->QtyKeluar;
            }
        }
        
        return "0";
    }
    
    protected function findDeliveredProductsQuantity($data, $productID)
    {
        foreach($data as $item)
        {
            if($item->product_id == $productID){
                return $item->QtyKeluar;
            }
        }
        
        return "0";
    }
    
    protected function findSaleProductsQuantity($data, $productID, $warehouseID)
    {
        foreach($data as $item){
            if($item->product_id == $productID && $item->warehouse_id == $warehouseID){
                return $item->sale_quantity;
            }
        }
        
        return "0";
    }
    
    protected function findSaleQuantity($data, $productID)
    {
        foreach($data as $item){
            if($item->product_id == $productID){
                return $item->sale_quantity;
            }
        }
        
        return "0";
    }

    private function prepareAllIndentData($products, $indent)
    {
        $data = [];
        foreach ($products as $product) {
            $rowData = [
                "quantity" => $this->findIndentQuantity($indent, $product->id)
            ];

            $data[] = $rowData;
        }

        return $data;
    }

    private function findIndentQuantity($products, $targetProduct)
    {
        foreach ($products as $product) {
            if ($product->product_id == $targetProduct) {
                return $product->total_indent;
            }
        }

        return "0";
    }
    
    public function getProducts()
    {
        
        $data = $this->fetchProducts();
        
        $products = $data["products"];
        $warehouses = $data["warehouses"];
        $categoryQuery  = $data["categories"];
        $productStocks = $data["product_stocks"];
        $productSales = $data["product_sales"];
        

        $processData = $this->prepareData($products, $warehouses, $productSales,$categoryQuery, $productStocks);
  
        return $processData;
    }
    
    protected function prepareData($products, $warehouses, $productSales,$categoryQuery, $productStocks)
    {
        $processData = [];
        
        foreach($products as $product)
        {
            $rowData = [
                "product_id" => $product->id,
                "product_name" => $product->name,
                "category_name" => $this->findName($categoryQuery, $product->category_id),
                "sales_quantity" => $this->findSalesQuantity($productSales, $product->id)." ".$product->unit
            ];
            
            foreach($warehouses as $warehouse)
            {
                $stockQuantity = $this->findStockQuantity($productStocks, $product->id, $warehouse->id);
                $rowData["stocks_".$warehouse->name] = $stockQuantity. " ".$product->unit;
            }
            
            $processData[] = $rowData;
        }
        
        return $processData;
    }
    
    protected function findName($data, $productId)
    {
        foreach($data as $item)
        {
            if($item->id == $productId){
                return $item->name;
            }
        }
        
        return "";
    }
    
    protected function findStockQuantity($data, $productId, $warehouseId)
    {
        foreach($data as $item)
        {
         if($item->warehouse_id == $warehouseId && $item->product_id == $productId)
         {
            return $item->stock_quantity;
         }
        }
        
        return 0;
    }
    
    protected function findRepairsQuantity($data, $productId)
    {
        foreach($data as $item)
        {
            if($item->product_id == $productId)
            {
                return $item->repair_quantity;
            }
        }
        
        return 0;
    }
    
    protected function findReturnsQuantity($data, $productId)
    {
        foreach($data as $item)
        {
            if($item->product_id == $productId)
            {
                return $item->return_quantity;
            }
        }
        
        return 0;
    }
    
    protected function findSalesQuantity($data, $productId)
    {
        foreach($data as $item)
        {
            if($item->product_id == $productId)
            {
                return $item->sale_quantity;
            }
        }
        
        return 0;
    }
    
    protected function findCapacity($data, $product_capacity)
    {
        foreach($data as $item)
        {
            if($item->id == $product_capacity)
            {
                return $item->kapasitas;
            }
        }
        
        return "-";
    }
    
    protected function findCategory($data, $product_category)
    {
        foreach($data as $item)
        {
            if($item->id == $product_category)
            {
                return $item->name;
            }
        }
        
        return "-";
    }
    
    protected function findSubCategory($data, $code)
    {
        foreach($data as $item)
        {
            if($item->code == $code)
            {
                return $item->name;
            }
        }
        
        return "-";
    }
    
    public function kapasitas()
    {
        $data = [
            "Kapasitas" => $this->capacityModel->findAll()
        ];
        
        return view("modules/capacity", $data);
    }
    
    public function insert_capacity()
    {
        $data = [
            "kapasitas" => $this->request->getPost("kapasitas")   
        ];
        
        $this->capacityModel->insert($data);
        return redirect()->to(base_url("products/capacity"));
    }
    
    public function delete_capacity($id)
    {
        $this->capacityModel->delete($id);
        return redirect()->to(base_url("products/capacity"));
    }
    

    public function products()
    {
        $goods = $this->goodsModel
            ->where("trash", 0)
            ->orderBy("name", "asc")
            ->get()
            ->getResultObject();
            
        $warehouses = $this->warehouseModel
            ->where("trash", 0)
            // ->whereNotIn("id", ['6'])
            ->orderBy("name", "asc")
            ->findAll();
        $categories = $this->goodCategoriesModel
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
    
        $brand = $this->brandModel->findAll();
        
        $capacity = $this->capacityModel->findAll();

        $data = ([
            "session"   => $this->session,
            "db"                => $this->db,
            "products"       => $goods,
            "categories"       => $categories,
            "warehouses"       => $warehouses,
            "prices"       => $prices,
            "codes"       => $codes,
            'brands' => $brand,
            "capacity" => $capacity,
            "validation" => $this->validation,
            "getProducts" => $this->getProducts()
        ]);

        return view('modules/products', $data);
    }
    
    public function ajaxGetCategories()
    {
        $subItemsByCategory = array();
        $categories = $this->goodCategoriesModel->findAll();

        foreach ($categories as $value) {
            $sub = $this->subModel->where('category_id', $value->id)->orderBy("name", "asc")->findAll();
            $subItemsByCategory[$value->id] = $sub;
        }
        
        // $category_id = $this->request->getPost("category_id");
        // $subCategory = $this->subModel->where("category_id", $category_id)->orderBy("name","asc")->findAll();

        $json = json_encode($subItemsByCategory);

        return $json;
    }
    
    public function ajaxGetSubs(){
        $category_id = $this->request->getVar("category_id");
        
        $subs = $this->subModel->where("category_id", $category_id)->findAll();
        $json = json_encode($subs);
        
        return $json;
    }
    
    public function ajaxGetProducts()
    {
        $products = $this->goodsModel->select(["id", "name"])->orderBy("name", "asc")->findAll();
        $json = json_encode($products);
        
        return $json;
    }
    
    public function ajaxGetSKU()
    {
        $Products = $this->goodsModel->select("sku_number")->findAll();
        $json = json_encode($Products);

        return $json;
    }

    public function products_add()
    {
        $category_id = $this->request->getPost('category_id');
        $sku_number = strtoupper($this->request->getPost('sku_number'));
        $code_id = $this->request->getPost('code_id');
        $name = strtoupper($this->request->getPost('name'));
        $unit = $this->request->getPost('unit');
        /// $stock = $this->request->getPost('stock');
        if(!empty($code_id)){
            $id = explode("|", $code_id);
            $codes = $id[0];
            $id_code = $this->codeModel->where("name", $codes)->first();
            $id_codes = $id_code->id;
        }else{
            $codes = "-";
            $id_codes = "-";
        }
        $capacity = $this->request->getPost("kapasitas");
        $details = $this->request->getPost('details');
        $price = $this->request->getPost('price');
        $formula = $this->request->getPost('formula');
        $hyd_retail = $this->request->getPost('hyd_retail');
        $hyd_online = $this->request->getPost('hyd_online');
        $hyd_grosir = $this->request->getPost('hyd_grosir');

        // masukan ke tabel goods
        $data_goods = [
            "category_id"     => $category_id,
            "sku_number"            => $sku_number,
            "code_id"            => $id_codes,
            "sub_category_id" => $codes,
            "capacity_id" => $capacity,
            "name"            => $name,
            "unit"            => $unit,
            "price"            => $price,
            "price_hyd_retail" => $hyd_retail,
            "price_hyd_online" => $hyd_online,
            "price_hyd_grosir" => $hyd_grosir,
            "price_id"            => $formula,
            "details"            => $details,
            "trash"           => 0,
        ];
        $this->goodsModel->insert($data_goods);

        // dapatkan good_id
        $good_id = $this->goodsModel->getInsertID($data_goods);

        //masukan ke tabel good_stocks
        // $data_good_stocks = [
        //     "product_id"     => $good_id,
        //     "date"            => date("Y-m-d"),
        //     "details"     => "stok awal diinput",
        //     "debit"            => $stock,
        //     "credit"            => 0,
        // ];
        // $this->goodStocksModel->insert($data_good_stocks);

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Barang : <b>' . $name . '</b> berhasil ditambahkan');

        // return redirect()->to(base_url('products/'.$good_id.'/manage'));
        return redirect()->to(base_url('products'));
    }

    public function products_edit()
    {
        $id = $this->request->getPost("id");
        $category_id = $this->request->getPost('category_id');
        $sku_number = $this->request->getPost('sku_number');
        $code_id = $this->request->getPost('code_id');
        // $sub = $this->subModel->where("code", $code_id)->first();
        $name = $this->request->getPost('name');
        $unit = $this->request->getPost('unit');
        $capacity = $this->request->getPost("kapasitas");
        $price = $this->request->getPost('price');
        $formula = $this->request->getPost('formula');
        $details = $this->request->getPost('details');
        $hyd_retail = $this->request->getPost('hyd_retail');
        $hyd_grosir = $this->request->getPost('hyd_grosir');
        $hyd_online = $this->request->getPost('hyd_online');

        // Volume Barang atau Produk
        $width = $this->request->getPost('width_product');
        $length = $this->request->getPost('length_product');
        $height = $this->request->getPost('height_product');
        
        $last_price = $this->goodsModel
        ->where('products.id', $id)
        ->get()
        ->getFirstRow();

        $this->goodsModel->update($id, ([
            "category_id"      => $category_id,
            "sku_number"       => $sku_number,
            "code_id"          => $code_id,
            "name"             => $name,
            "unit"             => $unit,
            "price"            => $price,
            "price_id"         => $formula,
            // "capacity_id"      => $capacity,
            // "sub_category_id" => $sub->id,
            "trash"            => 0,
            "price_hyd_retail" => $hyd_retail,
            "price_hyd_grosir" => $hyd_grosir,
            "price_hyd_online" => $hyd_online, 
            "last_price"       => $last_price->price,
            "last_update"      => date("Y-m-d"),
            "last_admin"       => $this->session->login_id,
            "details"          => $details,
            "item_width"       => $width, 
            "item_length"      => $length,
            "item_height"      => $height,
        ]));

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Barang : <b>' . $name . '</b> berhasil diubah');

        return redirect()->to(base_url('products/'.$id.'/manage'));
    }

    public function products_delete($id){
        $this->goodsModel->update($id, ([
            "trash"          => 1,
        ]));

        $goods = $this->goodsModel->where("id", $id)->first();

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Barang : <b>' . $goods->name . '</b> berhasil dihapus');

        return redirect()->to(base_url('products'));
    }

    public function products_search_filter_stock()
    {
        $product_id = $this->request->getPost('good_id');

        $product = $this->goodsModel
            ->where("id", $product_id)
            ->where("trash", 0)
            ->first();

        // dd($product);

        $data = [
            'product' => $product,
            'db' => $this->db,
        ];

        return view("modules/ajax_product_stock", $data);
    }

    public function products_stock(){
        
        $product_id = $this->request->getPost('good_id');
        $details = $this->request->getPost('details');

        $status = $this->request->getPost('status');
        if ($status == "credit") {
            $data = [
                "product_id"     => $product_id,
                "date"          => date("Y-m-d"),
                "details"     => $details,
                "debit"           => 0,
                "credit"           => $this->request->getPost('credit'),
            ];
            $this->goodStocksModel->insert($data);

            $goods = $this->goodsModel->where("id", $product_id)->first();

            $this->session->setFlashdata('message_type', 'success');
            $this->session->setFlashdata('message_content', 'Barang : <b>' . $goods->name . '</b> berhasil mengurangi stok');

            return redirect()->to(base_url('products'));
        } else if ($status == "debit") {
            $data = [
                "product_id"     => $product_id,
                "date"          => date("Y-m-d"),
                "details"     => $details,
                "debit"           => $this->request->getPost('debit'),
                "credit"           => 0,
            ];
            $this->goodStocksModel->insert($data);

            $goods = $this->goodsModel->where("id", $product_id)->first();

            $this->session->setFlashdata('message_type', 'success');
            $this->session->setFlashdata('message_content', 'Barang : <b>' . $goods->name . '</b> berhasil menambahkan stok');

            return redirect()->to(base_url('products'));
        }
    }
    
    public function export_nominal_product(){
        $tanggalawal = $this->request->getGet('tanggalawal');
        $tanggalakhir = $this->request->getGet('tanggalakhir');
    
        $products = $this->db->table('products as a');
        $products->select([
            'a.name as product_name',
            'a.sku_number as prd_sku',
            'a.price as product_price',
            'SUM(b.quantity) as qty_stock',
            'SUM(a.price * b.quantity) as total_value',
        ]);
        $products->join('product_stocks as b', 'a.id = b.product_id','left');
        $products->groupBy('a.id');
        $products->orderBy('a.name','asc');
        $products = $products->get();
        $products = $products->getResultObject();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'AIO Store');
        $sheet->mergeCells('A1:D1');
    
        $sheet->setCellValue('A2', 'Data Produk'.$tanggalawal." s/d ".$tanggalakhir);
        $sheet->mergeCells('A2:D2');
        $sheet->mergeCells('A3:D3');
    
        $spreadsheet->getActiveSheet()
        ->getStyle('A1:A2')
        ->getAlignment()
        ->setHorizontal(Alignment::HORIZONTAL_CENTER);
    
        $spreadsheet->getActiveSheet()
        ->getStyle('A:D')
        ->getAlignment()
        ->setHorizontal(Alignment::HORIZONTAL_CENTER);
    
        $spreadsheet->getActiveSheet()
        ->getStyle("A1:A2")
        ->getFont()
        ->setSize(14);
    
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A4', 'SKU Product');
        $sheet->setCellValue('B4', 'Product Name');
        $sheet->setCellValue('C4', 'Quantity');
        $sheet->setCellValue('D4', 'Price');
        $sheet->setCellValue('E4', 'Amount');
        
        $column = 5;
        $no = 1;
        foreach ($products as $key => $value) {
            
            $sheet->setCellValue('A'.$column, $value->prd_sku);
            $sheet->setCellValue('B'.$column, $value->product_name);

            if($value->qty_stock == NULL){
                $sheet->setCellValue('C'.$column, '0');
            }else{
                $sheet->setCellValue('C'.$column, $value->qty_stock);
            }

            $sheet->setCellValue('D'.$column, 'Rp.'.number_format($value->product_price));

            if($value->qty_stock == 0 || $value->qty_stock < 0){
                $sheet->setCellValue('E'.$column, 'Rp.'.number_format($value->product_price));
            }else{
                $sheet->setCellValue('E'.$column, 'Rp.'.number_format($value->total_value));
            }

            $column++;
        }
    
        $sheet->getStyle("A4:E4")->getFont()->setBold(true);
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
    
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename=Data Produk.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }
    
    public function export_quantitys(){
        $products = $this->goodsModel
        ->select([
            'products.id as product_id',
            'products.name as product_name',
            'products.unit as product_unit',
            'products.sku_number as sku_product',
        ])
        ->where('trash', 0)
        ->orderBy('products.name', 'asc')
        ->get()->getResultObject(); 
    
        $spreadsheet = new Spreadsheet();
        $sheet =  $spreadsheet->getActiveSheet();
    
        $sheet->setCellValue('A1', 'Data Stok Produk');
        $sheet->mergeCells('A1:C1');
    
        $spreadsheet->getActiveSheet()
        ->getStyle('A1:C1')
        ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    
        $sheet->setCellValue('A3', 'SKU Product');
        $sheet->setCellValue('B3', 'Product Name');
        $sheet->setCellValue('C3', 'Quantity');
    
        $column = 4;
    
        $warehouses = [
            'cirebon' => [
                'ids' => [1, 2, 3, 7, 8],
                'sheet_name' => 'CIREBON',
            ],
            'tasikmalaya' => [
                'ids' => [5, 10, 9],
                'sheet_name' => 'TASIKMALAYA', 
            ],
        ];
    
        foreach ($warehouses as $location => $warehouse) {
            $sheet->setCellValue('A'.$column, $warehouse['sheet_name']);
            $sheet->mergeCells('A'.$column.':C'.$column);
            $column++;
    
            foreach ($products as $key => $value) {
                $stocks = $this->db->table('product_stocks');
                $stocks->selectSum('product_stocks.quantity');
                $stocks->where('product_stocks.product_id', $value->product_id);
                $stocks->whereIn('product_stocks.warehouse_id', $warehouse['ids']);
                $stocks = $stocks->get();
                $stocks = $stocks->getFirstRow();
    
                $sheet->setCellValue('A'.$column, $value->sku_product);
                $sheet->setCellValue('B'.$column, $value->product_name);
    
                if($stocks->quantity !== NULL){
                    $sheet->setCellValue('C'.$column, $stocks->quantity);
                }else{
                    $sheet->setCellValue('C'.$column, 0);
                }
    
                $column++;
            }
        }
    
        $sheet->getStyle('A1:C1')->getFont()->setBold(true);
        $sheet->getStyle('A3:C3')->getFont()->setBold(true);
    
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
    
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename=Data Stok Produk.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }
    
    public function export_product_barang_keluar(){
        $productName = $this->request->getGet('productname');
        $tanggalawal = $this->request->getGet('tanggalawal');
        $tanggalakhir = $this->request->getGet('tanggalakhir');
        $sub = $this->request->getGet("sub_kategori");
        $capacity = $this->request->getGet('capacity');
        $getCategory = $this->request->getGet('category_id');
        
        if($tanggalawal == null && $tanggalakhir == null){
            
            $this->session->setFlashdata('message_type', 'danger');
            $this->session->setFlashdata('message_content', 'Tanggal Awal Dan Tanggal Akhir Tidak Boleh Kosong');
            
            return redirect()->to(base_url("report_produk_keluar"));
        }
        
        if(!empty($getCategory != "Pilih Kapasitas")){
            $explode = explode("|", $getCategory);
            $categoryID = $explode[0];
        }else{
            $categoryID = $getCategory;
        }
        
        $getCodes = $this->codeModel->where("name", $sub)->first();
       
        $saleItem = $this->saleItemModel
        ->select([
            'sale_items.id as sales_id',
            "sale_items.price as sale_price",
            "sale_items.quantity as sale_quantity",
            'warehouses.name as warehouse_name',
            'products.name as product_name',
            'products.sku_number as sku_number',
            'sales.transaction_date',
            'sale_items.quantity',
            'sales.number',
            "categories.name category_name",
            "sub_categories.name as sub_name",
            "capacity.kapasitas",
            'contacts.name as contact_name'
        ])
        ->join('sales', 'sale_items.sale_id = sales.id', 'left')
        ->join('contacts', 'sales.contact_id = contacts.id', 'left')
        ->join('products', 'sale_items.product_id = products.id', 'left')
        ->join("capacity", "capacity.id = products.capacity_id", "left")
        ->join("categories", "products.category_id = categories.id", "left")
        ->join('product_stocks','sale_items.id = product_stocks.sale_item_id','left')
        ->join("codes", "codes.id = products.code_id", "left")
        ->join("sub_categories","sub_categories.code = codes.name", "left")
        ->join('warehouses', 'product_stocks.warehouse_id = warehouses.id','left');

        if (!empty($productName != "Pilih Barang")) {
            $saleItem->like('products.name', $productName);
        }
        
        if (!empty($getCategory != "Pilih Kategori")) {
            $saleItem->where('products.category_id', $categoryID);
        }
        
        if (!empty($sub != "Pilih Sub Kategori")) {
            $saleItem->where('products.code_id', $getCodes->id);
        }
        
        if (!empty($capacity != "Pilih Kapasitas") && $capacity !== NULL) {
            $saleItem->like('products.name', $capacity);
        }

        if (!empty($tanggalawal) && !empty($tanggalakhir)) {
            $saleItem->where('sales.transaction_date >=', $tanggalawal)
            ->where('sales.transaction_date <=', $tanggalakhir);
        }

        $saleItem->orderBy('sales.id', 'desc');
        $result = $saleItem->findAll();
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'PT. GLOBAL MITRATAMA CEMERLANG');
        $sheet->mergeCells('A1:K1');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getFont()->setSize(14);

        $sheet->setCellValue('A2', 'DATA BARANG KELUAR  '. $tanggalawal . " s/d " . $tanggalakhir);
        $sheet->mergeCells('A2:K2');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2')->getFont()->setSize(14);

        $sheet->setCellValue('A4', 'Kode Produk');
        $sheet->setCellValue('B4', 'Nama Produk');
        $sheet->setCellValue("C4", "Kapasitas");
        $sheet->setCellValue("D4", "Kategori");
        $sheet->setCellValue("E4", "Sub Kategori");
        $sheet->setCellValue('F4', 'Nomor SO');
        $sheet->setCellValue('G4', 'Pelanggan');
        $sheet->setCellValue('H4', 'Tanggal');
        $sheet->setCellValue('I4', 'Gudang');
        $sheet->setCellValue('J4', 'Jumlah Barang Keluar');
        $sheet->setCellValue("K4", "Total Harga");

        $column = 5;

            foreach ($result as $item) {

                $sheet->setCellValue('A'.  $column, $item->sku_number);
                $sheet->setCellValue('B' . $column, $item->product_name);
                $sheet->setCellValue('C' . $column, $item->kapasitas ? $item->kapasitas : "-");
                $sheet->setCellValue('D' . $column, $item->category_name);
                $sheet->setCellValue('E' . $column, $item->sub_name);
                $sheet->setCellValue('F' . $column, $item->number);
                $sheet->setCellValue('G' . $column, $item->contact_name);
                $sheet->setCellValue('H' . $column, $item->transaction_date);
                $sheet->setCellValue('I' . $column, $item->warehouse_name);
                $sheet->setCellValue('J' . $column, $item->quantity);
                $sheet->setCellValue('K' . $column, $item->sale_price * $item->sale_quantity);
                $column++;
            }

        $sheet->getStyle('A4:K4')->getFont()->setBold(true);
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);
        $sheet->getColumnDimension('J')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'Data Barang Keluar.xlsx';
        $writer->save($filename);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        readfile($filename);
        exit();
    }
    
    private function getExportStockOut($productName, $firstDate, $endDate, $category, $subCategory, $code, $capacity)
    {   
        $saleItems = $this->saleItemModel
        ->select([
            'sale_items.id as sale_id',
            'sale_items.price as sale_price',
            'sale_items.product_id as sale_product_id',
            'sale_items.quantity as sale_quantity',
            'sales.transaction_date',
            'sales.number'
        ])
        ->join('sales', 'sale_items.sale_id = sales.id', 'left')
        ->where('sales.transaction_date >=', $firstDate)
        ->where('sales.transaction_date <=', $endDate)
        ->orderBy('sales.id', 'desc')
        ->findAll();
        
        $productID = array_column($saleItems, "sale_product_id");
        
        $categoryID = "";
        $subCategoryID = "";
        
        if(!empty($category != "Pilih Kategori")) {
            $categoryID = $category;
        }
        
        if(!empty($subCategory != "Pilih Sub Kategori")){
            $subCategoryID = $code;
        }
        
        $categories = $this->goodsCategoryModel
        ->select(["id", "name"])
        ->where("category_id", $category)
        ->findAll();
        
        $codes = $this->codeModel
        ->select(["id", "name"])
        ->where("name", $subCategoryID)
        ->first();
        
        $codesID = "";
        if($codes != null){
            $codesID  = $codes->name;
        }
        
        $subCategories = $this->subModel
        ->select(["name", "code"])
        ->where("code", $codesID)
        ->findAll();
        
        $products = $this->goodsModel
        ->select(["id", "name", "sku_number"])
        ->whereIn("id", $productID)
        ->where("category_id", $categoryID)
        ->where("code_id", $codesID)
        ->findAll();
    }
    
    
    protected function prepareExport($products, $warehouses, $productStocks, $productSales, $items)
    {
        $data = [];
        foreach($products as $product){
            $rowData = [
                "sku_number" => $product->sku_number,
                "product_name" => $product->name,
            ];
            
            foreach($warehouses as $warehouse){
                $stockQuantity = $this->findStockQuantity($productStocks, $product->id, $warehouse->id);
                $saleQuantity = $this->findSellsQuantity($productSales, $product->id, $warehouse->id);
                $deliveredQuantity = $this->findDeliveredsQuantity($items, $product->id, $warehouse->id);
                
                $rowData["stocks_".$warehouse->name] = $stockQuantity;
                $rowData["dipesan_".$warehouse->name] = $saleQuantity;
                $rowData["dikirim_".$warehouse->name] = $deliveredQuantity;
            }
            
            $data[] = $rowData;
        }
        
        return $data;
    }
    
    protected function findSellsQuantity($data, $productID, $warehouseID)
    {
        foreach ($data as $item) {
            if ($item->product_id == $productID && $item->warehouse_id == $warehouseID) {
                return $item->sale_quantity;
            }
        }

        return "0";
    }
    
    protected function findDeliveredsQuantity($items, $productID, $warehouseID)
    {
        foreach ($items as $item) {
            if ($item->product_id == $productID && $item->warehouse_id == $warehouseID) {
                return $item->QtyKeluar;
            }
        }

        return "0";
    }
    
    public function export_per_warehouse()
    {
        $warehouse_id = $this->request->getVar('warehouse');

        $data = $this->fetchProducts();

        $products = $data["products"];

        $warehouses = $this->warehouseModel
            ->select(["id", "name"])
            ->where("trash", 0)
            ->whereIn("id", $warehouse_id)
            ->orderBy("name", "asc")
            ->findAll();

        $productStocks = $this->productStockModel
            ->select(["SUM(quantity) as stock_quantity", "product_id", "warehouse_id"])
            ->whereIn("product_id", array_column($products, "id"))
            ->whereIn("warehouse_id", array_column($warehouses, "id"))
            ->groupBy(["product_id", "warehouse_id"])
            ->findAll();

        $productSales = $this->saleItemModel
            ->select(["SUM(sale_items.quantity) as sale_quantity", "product_stocks.product_id", "product_stocks.warehouse_id"])
            ->join("product_stocks", "product_stocks.sale_item_id = sale_items.id", "left")
            ->join("sales", "sales.id = sale_items.sale_id", "left")
            ->whereIn("product_stocks.product_id", array_column($products, "id"))
            ->whereIn("product_stocks.warehouse_id", array_column($warehouses, "id"))
            ->where("sales.status <", 5)
            ->groupBy(["product_stocks.product_id", "product_stocks.warehouse_id"])
            ->findAll();

        $items = [];
        if ($productSales) {
            $productIDs = array_column($products, "id");

            if (count($warehouse_id) > 1) {
                $items = $this->deliveryModel
                    ->select(["SUM(delivery_items.quantity) as QtyKeluar", "sale_items.product_id", "product_stocks.warehouse_id"])
                    ->join("sale_items", "sale_items.id = delivery_items.sale_item_id", "left")
                    ->join("sales", "sale_items.sale_id = sales.id", "left")
                    ->join("product_stocks", "sale_items.id = product_stocks.sale_item_id", "left")
                    ->whereIn("sale_items.product_id", $productIDs)
                    ->whereIn("product_stocks.warehouse_id", $warehouse_id)
                    ->where("sales.status <", 5)
                    ->groupBy(["sale_items.product_id", "product_stocks.warehouse_id"])
                    ->findAll();
            } elseif (count($warehouse_id) == 1) {
                $items = $this->deliveryModel
                    ->select(["SUM(delivery_items.quantity) as QtyKeluar", "sale_items.product_id", "product_stocks.warehouse_id"])
                    ->join("sale_items", "sale_items.id = delivery_items.sale_item_id", "left")
                    ->join("sales", "sale_items.sale_id = sales.id", "left")
                    ->join("product_stocks", "sale_items.id = product_stocks.sale_item_id", "left")
                    ->whereIn("sale_items.product_id", $productIDs)
                    ->where("product_stocks.warehouse_id", $warehouse_id)
                    ->where("sales.status <", 5)
                    ->groupBy(["sale_items.product_id", "product_stocks.warehouse_id"])
                    ->findAll();
            }
        }

        $prepareData = $this->prepareExport($products, $warehouses, $productStocks, $productSales, $items);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Laporan Stok Per Gudang');
        $sheet->mergeCells('A1:C1');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getFont()->setSize(14);

        $headColumns = ([
            "",
            "Kode Barang", "Nama Barang"
        ]);

        foreach ($warehouses as $warehouse) :
            array_push($headColumns, $warehouse->name, "");
        endforeach;

        $c = 0;
        $warehouseCounter = 0;
        foreach (range("A", "Z") as $column) :
            $c++;
            if ($c > count($headColumns) - 1) {
                break;
            } else {
                $sheet->setCellValue($column . "3", $headColumns[$c]);
                if ($column == "A" || $column == "B") {
                    $sheet->mergeCells($column . "3:" . $column . "4");
                    $sheet->getStyle($column . "3")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                } elseif ($c >= 3) {
                    if ($c % 2 == 1) {
                        $currentWarehouse = $warehouses[$warehouseCounter]->name;
                        $sheet->mergeCells($column . "3:" . chr(ord($column) + 1) . "3");
                        $sheet->setCellValue($column . "3", $currentWarehouse);
                        $sheet->getStyle($column . "3")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                        $sheet->setCellValue($column . "4", 'Stok Tersedia');
                        $sheet->setCellValue(chr(ord($column) + 1) . "4", 'Dipesan');
                        $sheet->getStyle($column . "4")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                        $sheet->getStyle(chr(ord($column) + 1) . "4")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                        $warehouseCounter++;
                    }
                }
            }
        endforeach;

        $column = 4;
        foreach ($prepareData as $item) {
            $column++;

            $dataColumns = [
                "",
                $item["sku_number"],
                $item["product_name"],
            ];

            foreach ($warehouses as $wh) :
                $stocksKey = "stocks_" . $wh->name;
                $saleKey = "dipesan_" . $wh->name;
                $deliveredKey = "dikirim_" . $wh->name;

                $stocks = $item[$stocksKey];
                $dipesan = $item[$saleKey];
                $dikirim = $item[$deliveredKey];

                $sale = intval($dipesan) - intval($dikirim);

                array_push($dataColumns, $stocks . " Unit", $sale . " Unit");
            endforeach;


            $c = 0;
            foreach (range("A", "Z") as $columnLetter) {
                $c++;
                if ($c > count($dataColumns) - 1) {
                    break;
                } else {
                    $sheet->setCellValue($columnLetter . '' . $column, $dataColumns[$c]);
                }
            }

            $c = 0;
            foreach (range('A', 'Z') as $columnLetter) {
                $c++;
                if ($c > count($headColumns) - 1) {
                    break;
                } else {
                    $sheet->getColumnDimension($columnLetter)->setAutoSize(true);
                }
            }
        }


        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename=Data Stok Per Gudang.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }
  
  
    public function export_quantity(){
        
        $data = $this->fetchProducts();
        
        $products = $data["products"];
        $warehouses = $data["warehouses"];
        $productStocks = $data["product_stocks"];
        $productCategory = $data["categories"];
        $productSubCategory = $data["product_sub_category"];
        $productCapacity = $data["product_capacity"];
        $productSales = $data["product_sales"];
        $productCodes = $data["product_codes"];
        $productService = $data["product_repairs"];
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'AIO STORE');
        $sheet->setCellValue('A2', 'Data Quantity Produk');
        $sheet->mergeCells('A1:H1');
        $sheet->mergeCells('A2:H2');
        $sheet->mergeCells('A3:H3');

        $spreadsheet->getActiveSheet()
            ->getStyle('A1')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $spreadsheet->getActiveSheet()
            ->getStyle('A2')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $spreadsheet->getActiveSheet()
            ->getStyle('A1')
            ->getFont()
            ->setSize(14);

        $spreadsheet->getActiveSheet()
            ->getStyle('A2')
            ->getFont()
            ->setSize(14);

        $headColumns = ([
            "",
            "SKU Produk", "Nama Produk", "Kapasitas", "Kategori", "Sub Kategori"
        ]);
        
        foreach($warehouses as $warehouse)
        {
            array_push($headColumns, $warehouse->name);
        }
        
        array_push($headColumns, "Servis","Dipesan");
        
        $c = 0;
        foreach(range("A", "Z") as $columns)
        {
            $c++;
            if($c > count($headColumns) -1)
            {
                
            }else{
                $sheet->setCellValue($columns. '4', $headColumns[$c]);
            }
        }
        
        $c = 0;
        foreach(range("A", "Z") as $columns)
        {
            $c++;
            if($c > count($headColumns) -1)
            {
                
            }else{
                $sheet->getStyle($columns. '4')->getFont()->setBold(true);
            }
        }
        
        $columns = 4;
        foreach($products as $product)
        {
            $columns++;
            
            $capacity = $this->findCapacity($productCapacity, $product->capacity_id);
            $code = $this->findName($productCodes, $product->code_id);
            $sub = $this->findSubCategory($productSubCategory, $code);
            $category = $this->findCategory($productCategory, $product->category_id);
            
            $dataColumns = ([
               "",
               $product->sku_number, $product->name, $capacity, $category, $sub
            ]);
            
            foreach($warehouses as $warehouse)
            {
                $stockQuantity = $this->findStockQuantity($productStocks, $product->id, $warehouse->id);
                array_push($dataColumns, $stockQuantity);
            }
            
            $service = $this->findRepairsQuantity($productService, $product->id);
            array_push($dataColumns, $service);
            
            $sales = $this->findSalesQuantity($productSales, $product->id);
            array_push($dataColumns, $sales);
            
            $c = 0;
            foreach(range("A", "Z") as $columnLetters)
            {
                $c++;
                if($c > count($dataColumns) -1)
                {
                    
                }else{
                    $sheet->setCellValue($columnLetters."". $columns,$dataColumns[$c]);
                }
            }
            
        }
        
        $c = 0;
        foreach(range("A","Z") as $columns)
        {
            $c++;
            if($c > count($headColumns) - 1)
            {
                
            }else{
                $sheet->getColumnDimension($columns)->setAutoSize(true);
            }
        }
        
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename=Data Stok Tersedia.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }
    
    public function export_stok_in()
    {
        $buys = $this->request->getGet('buy_id');
        $productName = $this->request->getGet('productName');
        $tanggalawal = $this->request->getGet('tanggalawal');
        $tanggalakhir = $this->request->getGet('tanggalakhir');

        $buyItem = $this->buyItemModel
            ->select([
                'buys.date',
                'buy_items.id',
                'buys.id as buys_id',
                'buys.number as buy_number',
                'buy_items.quantity as buy_qty',
                'products.name as product_name',
                'products.unit as product_unit',
                'warehouses.name as warehouse_name',
            ])
            
            ->join('buys', 'buy_items.buy_id = buys.id', 'left')
            ->join('warehouses', 'buys.warehouse_id = warehouses.id','left')
            ->join('products', 'buy_items.product_id = products.id', 'left')
            ->orderBy('buy_items.buy_id', 'desc');

        if (!empty($productName != "Pilih Brand")) {
            $buyItem->like('products.name', $productName);
        }

        if (!empty($tanggalawal) && !empty($tanggalakhir)) {
            $buyItem->where('buys.date >=', $tanggalawal)
                ->where('buys.date <=', $tanggalakhir);
        }
        
        if (!empty($buys != "")){
            $buyItem->where('buy_items.buy_id',$buys);
        }
        
        if (!empty($productName == "Pilih Brand")){
            
        }

        $buys = $buyItem->get()->getResultObject();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'AIO Store');
        $sheet->mergeCells('A1:F1');

        $sheet->setCellValue('A2', 'Stock in ' . $tanggalawal . " s/d " . $tanggalakhir);
        $sheet->mergeCells('A2:F2');
        $sheet->mergeCells('A3:F3');

        $spreadsheet->getActiveSheet()
            ->getStyle('A1:A2')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $spreadsheet->getActiveSheet()
            ->getStyle('A:F')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $spreadsheet->getActiveSheet()
            ->getStyle("A1:A2")
            ->getFont()
            ->setSize(14);

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue("A4", 'No');
        $sheet->setCellValue("B4", 'Date Stock In');
        $sheet->setCellValue("C4", 'Number PD');
        $sheet->setCellValue("D4", 'Location');
        $sheet->setCellValue("E4", 'Product Name');
        $sheet->setCellValue("F4", 'Quantity');

        $column = 5;
        $no = 1;
        foreach ($buys as $key => $value) {

            // $contactname = $this->contactModel->where('contacts.id',$value->contact_id)->orderBy('contacts.name','asc')->findAll();

            $sheet->setCellValue('A' . $column, $no++);
            $sheet->setCellValue('B' . $column, $value->date);
            $sheet->setCellValue('C' . $column, $value->buy_number);
            $sheet->setCellValue('D' . $column, $value->warehouse_name);
            $sheet->setCellValue('E' . $column, $value->product_name);
            
            $sheet->setCellValue('F' . $column, $value->buy_qty . ' ' . $value->product_unit);
            $column++;
        }
        
        $sheet->getStyle('A4:F4')->getFont()->setBold(true);
        // $sheet->getStyle("A4:E4")
        $sheet->getColumnDimension('A')->setWidth('8');
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSIze(true);
        $sheet->getColumnDimension('D')->setAutoSIze(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename=Data Barang Masuks.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }

    public function export_stok_out(){
        
        $tanggalawal = $this->request->getGet('tanggalawal');
        $tanggalakhir = $this->request->getGet('tanggalakhir');

        $sale = $this->saleItemModel
        ->select([
            'sale_items.id',
            'sales.admin_id',
            'sales.contact_id',
            'sale_items.sale_id',
            'sales.number as number',
            'sale_items.quantity as qty',
            'products.name as product_name',
            'products.unit as product_unit',
            'sales.transaction_date as date',
            'products.sku_number as sku_number',
            'product_stocks.warehouse_id',])

        ->join('product_stocks','sale_items.id = product_stocks.sale_item_id')
        ->join('products','sale_items.product_id = products.id','left')
        ->join('sales','sale_items.sale_id = sales.id','left')
        ->where('sales.transaction_date >=', $tanggalawal)
        ->where('sales.transaction_date <=', $tanggalakhir)
        ->orderBy('sales.id','desc')
        ->findAll();
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'AIO Store');
        $sheet->mergeCells('A1:G1');

        $sheet->setCellValue('A2', 'Stock Out '.$tanggalawal." s/d ".$tanggalakhir);
        $sheet->mergeCells('A2:G2');
        $sheet->mergeCells('A3:G3');

        $spreadsheet->getActiveSheet()
        ->getStyle('A1:A2')
        ->getAlignment()
        ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $spreadsheet->getActiveSheet()
        ->getStyle('A:G')
        ->getAlignment()
        ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $spreadsheet->getActiveSheet()
        ->getStyle("A1:A2")
        ->getFont()
        ->setSize(14);

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue("A4", 'SKU NUmber');
        $sheet->setCellValue("B4", 'Product Name');
        $sheet->setCellValue("C4", 'Number Sales Order');
        $sheet->setCellValue("D4", 'Sales Name');
        // $sheet->setCellValue("E4", 'Customer Name');
        $sheet->setCellValue("E4", 'Date Stock Out');
        $sheet->setCellValue('F4', "Location");
        $sheet->setCellValue("G4", 'Quantity');
      

        $column = 5;
        $no = 1;
        foreach ($sale as $key => $value) { 

        $sheet->setCellValue('A'.$column, $value->sku_number);
        $sheet->setCellValue('B'.$column, $value->product_name);
        $sheet->setCellValue('C'.$column, $value->number);

        //Query Administrator
        $admin = $this->db->table('administrators');
        $admin->where('administrators.id',$value->admin_id);
        $admin = $admin->get();
        $admin = $admin->getFirstRow();
        $sheet->setCellValue('D'.$column, $admin->name);


        // //Query Customer
        // $customer = $this->db->table('contacts');
        // $customer->where('contacts.id',$value->contact_id);
        // $customer->where("trash", 0);
        // $customer = $customer->get();
        // $customer = $customer->getResultObject();
        
        // $sheet->setCellValue('F'.$column, $customer->name);

        $sheet->setCellValue('E'.$column, $value->date);
        $gudang = $this->db->table('warehouses');
        $gudang->where('warehouses.id', $value->warehouse_id);
        $gudang = $gudang->get();
        $gudang = $gudang->getFirstRow();

        $sheet->setCellValue('F'.$column, $gudang->name);
        $sheet->setCellValue('G'.$column, $value->qty.' '.$value->product_unit);
       
        $column++; 
    }

        $sheet->getStyle("A4:G4")->getFont()->setBold(true);
        
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSIze(true);
        $sheet->getColumnDimension('D')->setAutoSIze(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);


        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename=Data Barang Keluar.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();

    }

    public function n(){
        $productName = $this->request->getGet('productName');
        $tanggalawal = $this->request->getGet('tanggalawal');
        $tanggalakhir = $this->request->getGet('tanggalakhir');

        $buyItem = $this->buyItemModel
        ->select([
            'buys.date',
            'buy_items.id',
            'buys.number as buy_number',
            'buy_items.quantity as buy_qty',
            'products.name as product_name',
            'products.unit as product_unit',
            'warehouses.name as warehouse_name',
        ])
        ->join('buys','buy_items.buy_id = buys.id','left')
        ->join('products', 'buy_items.product_id = products.id','left')
        ->join('warehouses', 'buys.warehouse_id = warehouses.id', 'left')
        ->orderBy('buys.id','desc');
        
        if (!empty($productName != "Pilih Brand")) {
            $buyItem->like('products.name', $productName);
        }

        if (!empty($tanggalawal) && !empty($tanggalakhir)) {
            $buyItem->where('buys.date >=', $tanggalawal)
            ->where('buys.date <=', $tanggalakhir);
        }
        
        $buys = $buyItem->get()->getResultObject();
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'AIO Store');
        $sheet->mergeCells('A1:F1');

        $sheet->setCellValue('A2', 'Stock in '.$tanggalawal." s/d ".$tanggalakhir);
        $sheet->mergeCells('A2:F2');
        $sheet->mergeCells('A3:F3');

        $spreadsheet->getActiveSheet()
        ->getStyle('A1:A2')
        ->getAlignment()
        ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $spreadsheet->getActiveSheet()
        ->getStyle('A:F')
        ->getAlignment()
        ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $spreadsheet->getActiveSheet()
        ->getStyle("A1:A2")
        ->getFont()
        ->setSize(14);

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue("A4", 'No');
        $sheet->setCellValue("B4", 'Date Stock In');
        $sheet->setCellValue("C4", 'Number PD');
        $sheet->setCellValue("D4", 'Product Name');
        $sheet->setCellValue("E4", 'Location');
        $sheet->setCellValue("F4", 'Quantity');

        $column = 5;
        $no = 1;
        foreach ($buys as $key => $value) { 

        // $contactname = $this->contactModel->where('contacts.id',$value->contact_id)->orderBy('contacts.name','asc')->findAll();

        $sheet->setCellValue('A'.$column, $no++);
        $sheet->setCellValue('B'.$column, $value->date);
        $sheet->setCellValue('C'.$column, $value->buy_number);
        $sheet->setCellValue('D'.$column, $value->product_name);
        $sheet->setCellValue('E'.$column, $value->warehouse_name);
        $sheet->setCellValue('F'.$column, $value->buy_qty.' '.$value->product_unit);
        $column++; 
    }

        $sheet->getStyle("A4:E4")->getFont()->setBold(true);
        $sheet->getColumnDimension('A')->setWidth('8');
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSIze(true);
        $sheet->getColumnDimension('D')->setAutoSIze(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename=Data Barang Masuks.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }

  
    public function exportData(){
        $tanggalawal = $this->request->getGet('tanggalawal');
        $tanggalakhir = $this->request->getGet('tanggalakhir');

        $products = $this->productStockModel
        ->select([
            'products.name as product_name',
            'buys.date as buy_date',
            'buy_items.quantity as buy_quantity',
            'sale_items.quantity as sale_quantity',
            'COALESCE(sales.number, buys.number) as document_number',
            'COALESCE(buys.date, sales.transaction_date) as document_date',
        ])
        ->where('product_stocks.date >=', $tanggalawal)
        ->where('product_stocks.date <=', $tanggalakhir)
        ->join('products', 'product_stocks.product_id = products.id', 'left')
        ->join('buy_items', 'product_stocks.buy_item_id = buy_items.id', 'left')
        ->join('buys','buy_items.buy_id = buys.id', 'left')
        ->join('sale_items', 'product_stocks.sale_item_id = sale_items.id', 'left')
        ->join('sales','sale_items.sale_id = sales.id', 'left')
        ->join('warehouses', 'product_stocks.warehouse_id = warehouses.id', 'left')
        ->orderBy('products.name', 'asc')
        ->orderBy('document_date', 'desc')
        ->get()
        ->getResultObject();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'AIO Store');
        $sheet->mergeCells('A1:E1');

        $sheet->setCellValue('A2', 'Data Pergerakan Barang ' . $tanggalawal . " s/d " . $tanggalakhir);
        $sheet->mergeCells('A2:E2');
        $sheet->mergeCells('A3:E3');

        $spreadsheet->getActiveSheet()
        ->getStyle('A1:A2')
        ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $spreadsheet->getActiveSheet()
        ->getStyle('A:G')
        ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $spreadsheet->getActiveSheet()
        ->getStyle('A1:A2')
        ->getFont()->setSize(14);

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A4', 'Nama Produk');
        $sheet->setCellValue('B4', 'Tanggal Transaksi');
        $sheet->setCellValue('C4', 'Jenis Transaksi');
        $sheet->setCellValue('D4', 'Nomer Dokumen');
        $sheet->setCellValue('E4', 'Quantity');

        $sheet->getStyle('A4:E4')->getFont()->setBold(true);

        $rowIndex = 5;
        $prevProduct = null;

        foreach ($products as $key => $value) {
        if ($prevProduct !== $value->product_name) {
            $sheet->setCellValue('A' . $rowIndex, $value->product_name);
            $sheet->mergeCells('A' . $rowIndex . ':A' . ($rowIndex + 1));
            $sheet->getStyle('A' . $rowIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A' . $rowIndex)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        }

        $sheet->setCellValue('B' . $rowIndex, $value->document_date);

        if ($value->buy_quantity !== null) {
            $sheet->setCellValue('C' . $rowIndex, 'Pembelian');
            $sheet->setCellValue('D' . $rowIndex, $value->document_number);
            $sheet->setCellValue('E' . $rowIndex, '+' . $value->buy_quantity);
        } else {
            $sheet->setCellValue('C' . $rowIndex, 'Penjualan');
            $sheet->setCellValue('D' . $rowIndex, $value->document_number);
            $sheet->setCellValue('E' . $rowIndex, '-' . $value->sale_quantity);
        }

        $prevProduct = $value->product_name;
        $rowIndex++;
    }

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename=Data Pergerakan Barang.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    } 
    
    public function detail_export_products(){
        $dataproducts = $this->db->table('products as a');
        $dataproducts->select([
            'a.id',
            'a.price_id',
            'a.sku_number',
            'a.name as product_name',
            'b.name as category_name',
            'a.price as product_price',
            'c.plus_one',
            'c.plus_two',
            'c.plus_three',
            'c.plus_four',
            'c.plus_five',
            'c.plus_six',
            'c.plus_seven',
            'c.plus_eight',
            'c.plus_nine',
            'c.plus_ten',
        ]);
        $dataproducts->join('categories as b','a.category_id = b.id','left');
        $dataproducts->join('product_prices as c','a.price_id = c.id','left');
        $dataproducts->orderBy('a.name', 'asc');
        $dataproducts->where('a.trash', 0);
        $dataproducts = $dataproducts->get();
        $dataproducts = $dataproducts->getResultObject();

        $data = ([
            'db'    => $this->db,
            'dataproducts'  => $dataproducts,
        ]);

        return view('modules/detail_export_data', $data);        
    }
  
    public function export(){
    	$products = $this->goodsModel
    	->select([
    	   "categories.name as category_name",
    	   "products.id",
    	   "products.sku_number",
    	   "products.name",
    	   "products.unit",
    	   "products.price",
    	   "products.price_id",
    	   "price_hyd_retail",
    	   "price_hyd_grosir",
    	])
    	->join('categories','products.category_id = categories.id','left')
    	->orderBy("products.name","asc")
    	->where("products.trash",0)
    	->findAll();
    	
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
    
    	$sheet->setCellValue('A1', 'Data Produk');
        $sheet->mergeCells('A1:P1');
        $spreadsheet->getActiveSheet()
        ->getStyle('A1')
        ->getAlignment()
        ->setHorizontal(Alignment::HORIZONTAL_CENTER);  

        $spreadsheet->getActiveSheet()
            ->getStyle('A1')
            ->getFont()
            ->setSize(14);

        $headColumns = ([
            "",
            "Nama Produk","SKU Produk","Kategori"
        ]);

        //$warehouses = $this->warehouseModel->where("trash", 0)->orderBy("name", "asc")->findAll();

       // foreach($warehouses as $warehouse){
        //    array_push($headColumns,$warehouse->name);
       // } 

        array_push($headColumns,"Harga Utama","Harga Ke-2","Harga Ke-3","Harga Ke-4"
        ,"Harga Ke-5","Harga Ke-6","Harga Ke-7","Harga Ke-8","Harga Ke-9","Harga Ke-10");

        $countHeadColumns = count($headColumns);

        $c = 0;
        foreach (range('A', 'Z') as $column){
            $c++;
            if($c > count($headColumns) - 1){

            }else{
                $sheet->setCellValue($column.'2', $headColumns[$c]);
            }
        }

        $c = 0;
        foreach (range('A', 'Z') as $column){
            $c++;
            if($c > count($headColumns) - 1){

            }else{
                $sheet->getStyle($column.'2')->getFont()->setBold(true);
            }
        }

        // $sheet->setCellValue('A1', 'No');
        // $sheet->setCellValue('B1', 'Nama Barang');
        // $sheet->setCellValue('C1', 'Nomer SKU');
        // $sheet->setCellValue('D1', 'Satuan');
        // $sheet->setCellValue('E1', 'Harga Utama');
    	// $sheet->setCellValue('F1', 'Harga Ke-2');
        // $sheet->setCellValue('G1', 'Harga Ke-3');
        // $sheet->setCellValue('H1', 'Harga Ke-4');
        // $sheet->setCellValue('I1', 'Harga Ke-5');
        // $sheet->setCellValue('J1', 'Harga Ke-6');
        // $sheet->setCellValue('K1', 'Harga Ke-7');
        // $sheet->setCellValue('L1', 'Harga Ke-8');
        // $sheet->setCellValue('M1', 'Harga Ke-9');
        // $sheet->setCellValue('N1', 'Harga Ke-10');
    
    	// $sheet->getStyle('A1')->getFont()->setBold(true);
        // $sheet->getStyle('B1')->getFont()->setBold(true);
        // $sheet->getStyle('C1')->getFont()->setBold(true);
        // $sheet->getStyle('D1')->getFont()->setBold(true);
        // $sheet->getStyle('E1')->getFont()->setBold(true);
        // $sheet->getStyle('F1')->getFont()->setBold(true);
        // $sheet->getStyle('G1')->getFont()->setBold(true);
        // $sheet->getStyle('H1')->getFont()->setBold(true);
        // $sheet->getStyle('I1')->getFont()->setBold(true);
        // $sheet->getStyle('J1')->getFont()->setBold(true);
        // $sheet->getStyle('K1')->getFont()->setBold(true);
        // $sheet->getStyle('L1')->getFont()->setBold(true);
        // $sheet->getStyle('M1')->getFont()->setBold(true);
        // $sheet->getStyle('N1')->getFont()->setBold(true);
    
        $column = 2;
        foreach($products as $product) {
            $column++;
            
          	$rumus = $this->productPriceModel->where("id",$product->price_id)->first();
          
          	if($rumus == NULL){
                $margins = ([
                    0, // 0
                    0, // margin ke-1
                    0, // margin ke-2
                    0, // margin ke-3
                    0, // margin ke-4
                    0, // margin ke-5
                    0, // margin ke-6
                    0, // margin ke-7
                    0, // margin ke-8
                    0, // margin ke-9
                    0, // margin ke-10
                ]);
            }else{
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
            }

            $arrayPrices = ([0]);

            $thisPrice = floatval($product->price);
            array_push($arrayPrices,$thisPrice);
            for($p = 2; $p <= 10; $p++){
                $thisPrice += $margins[$p];
                array_push($arrayPrices, $thisPrice);
            }

            $dataColumns = ([
                "",
                $product->name,$product->sku_number,$product->category_name,
            ]);

         //  foreach($warehouses as $warehouse){
         //       $location = $this->db->table("product_stocks");
         //       $location->selectSum("quantity");
        //        $location->where("warehouse_id",$warehouse->id);
        //        $location->where("product_id",$product->id);
        //        $location = $location->get();
        //        $location = $location->getFirstRow();
                
         //       if($location->quantity == NULL){
         //           array_push($dataColumns,"0 ".$product->unit);
          //      }else{
          //          array_push($dataColumns,$location->quantity." ".$product->unit);
          //      }
          //  }

            array_push($dataColumns,
            $product->price,
            $arrayPrices[2],
            $arrayPrices[3],
            $arrayPrices[4],
            $arrayPrices[5],
            $arrayPrices[6],
            $arrayPrices[7],
            $arrayPrices[8],
            $arrayPrices[9],
            $arrayPrices[10]
            );

            $c = 0;
            foreach (range('A', 'Z') as $columnLetter){
                $c++;
                if($c > count($dataColumns) - 1){

                }else{
                    $sheet->setCellValue($columnLetter.''.$column, $dataColumns[$c]);
                }
            }

            // $sheet->setCellValue('A'.$column, ($column-1));
            // $sheet->setCellValue('B'.$column, $product->name);
            // $sheet->setCellValue('C'.$column, $product->sku_number);
            // $sheet->setCellValue('D'.$column, $product->unit);
            // $sheet->setCellValue('E'.$column, $product->price);
            // $sheet->setCellValue('F'.$column, $arrayPrices[2]);
            // $sheet->setCellValue('G'.$column, $arrayPrices[3]);
            // $sheet->setCellValue('H'.$column, $arrayPrices[4]);
            // $sheet->setCellValue('I'.$column, $arrayPrices[5]);
            // $sheet->setCellValue('J'.$column, $arrayPrices[6]);
            // $sheet->setCellValue('K'.$column, $arrayPrices[7]);
            // $sheet->setCellValue('L'.$column, $arrayPrices[8]);
            // $sheet->setCellValue('M'.$column, $arrayPrices[9]);
            // $sheet->setCellValue('N'.$column, $arrayPrices[10]);
        }

        $c = 0;
        foreach (range('A', 'Z') as $column){
            $c++;
            if($c > count($headColumns) - 1){

            }else{
                $sheet->getColumnDimension($column)->setAutoSize(true);
            }
        }

        // $sheet->getColumnDimension('A')->setAutoSize(true);
        // $sheet->getColumnDimension('B')->setAutoSize(true);
        // $sheet->getColumnDimension('C')->setAutoSize(true);
        // $sheet->getColumnDimension('D')->setAutoSize(true);
        // $sheet->getColumnDimension('E')->setAutoSize(true);
    	// $sheet->getColumnDimension('F')->setAutoSize(true);
        // $sheet->getColumnDimension('G')->setAutoSize(true);
        // $sheet->getColumnDimension('H')->setAutoSize(true);
        // $sheet->getColumnDimension('I')->setAutoSize(true);
        // $sheet->getColumnDimension('J')->setAutoSize(true);
        // $sheet->getColumnDimension('K')->setAutoSize(true);
        // $sheet->getColumnDimension('L')->setAutoSize(true);
        // $sheet->getColumnDimension('M')->setAutoSize(true);
        // $sheet->getColumnDimension('N')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename=DataBarang.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }
  
  	public function export_dataproduct()
    {
     	$productname = $this->request->getGet('productname');

        $products = $this->goodsModel
        ->orderBy("name","asc")
        ->like("name", $productname)
        ->where("trash",0)
        ->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
    
        $sheet->setCellValue('A1', 'Data Produk '.$productname);
        $sheet->mergeCells('A1:M1');
        $spreadsheet->getActiveSheet()
        ->getStyle('A1')
        ->getAlignment()
        ->setHorizontal(Alignment::HORIZONTAL_CENTER);  

        $spreadsheet->getActiveSheet()
        ->getStyle('A1')
        ->getFont()
        ->setSize(14);
 
        $sheet->setCellValue('A2', 'Nama Produk');
        $sheet->setCellValue('B2', 'Nomer SKU');
        $sheet->setCellValue('C2', 'Satuan Produk');
        $sheet->setCellValue('D2', 'Harga Utama');
        $sheet->setCellValue('E2', 'Harga Ke-2');
        $sheet->setCellValue('F2', 'Harga Ke-3');
        $sheet->setCellValue('G2', 'Harga Ke-4');
        $sheet->setCellValue('H2', 'Harga Ke-5');
        $sheet->setCellValue('I2', 'Harga Ke-6');
        $sheet->setCellValue('J2', 'Harga Ke-7');
        $sheet->setCellValue('K2', 'Harga Ke-8');
        $sheet->setCellValue('L2', 'Harga Ke-9');
        $sheet->setCellValue('M2', 'Harga Ke-10');
    
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('B2')->getFont()->setBold(true);
        $sheet->getStyle('C2')->getFont()->setBold(true);
        $sheet->getStyle('D2')->getFont()->setBold(true);
        $sheet->getStyle('E2')->getFont()->setBold(true);
        $sheet->getStyle('F2')->getFont()->setBold(true);
        $sheet->getStyle('G2')->getFont()->setBold(true);
        $sheet->getStyle('H2')->getFont()->setBold(true);
        $sheet->getStyle('I2')->getFont()->setBold(true);
        $sheet->getStyle('J2')->getFont()->setBold(true);
        $sheet->getStyle('K2')->getFont()->setBold(true);
        $sheet->getStyle('L2')->getFont()->setBold(true);
        $sheet->getStyle('M2')->getFont()->setBold(true);
    
        $column = 2;
        foreach($products as $product) {
            $column++;
            
            $rumus = $this->productPriceModel->where("id",$product->price_id)->first();
          
            if($rumus == NULL){
                $margins = ([
                    0, // 0
                    0, // margin ke-1
                    0, // margin ke-2
                    0, // margin ke-3
                    0, // margin ke-4
                    0, // margin ke-5
                    0, // margin ke-6
                    0, // margin ke-7
                    0, // margin ke-8
                    0, // margin ke-9
                    0, // margin ke-10
                ]);
            }else{
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
            }

            $arrayPrices = ([0]);

            $thisPrice = floatval($product->price);
            array_push($arrayPrices,$thisPrice);
            
            for($p = 2; $p <= 10; $p++){
                $thisPrice += $margins[$p];
                array_push($arrayPrices, $thisPrice);
            } 

            $sheet->setCellValue('A'.$column, $product->name);
            $sheet->setCellValue('B'.$column, $product->sku_number);
            $sheet->setCellValue('C'.$column, $product->unit);
            $sheet->setCellValue('D'.$column, $product->price);
            $sheet->setCellValue('E'.$column, $arrayPrices[2]);
            $sheet->setCellValue('F'.$column, $arrayPrices[3]);
            $sheet->setCellValue('G'.$column, $arrayPrices[4]);
            $sheet->setCellValue('H'.$column, $arrayPrices[5]);
            $sheet->setCellValue('I'.$column, $arrayPrices[6]);
            $sheet->setCellValue('J'.$column, $arrayPrices[7]);
            $sheet->setCellValue('K'.$column, $arrayPrices[8]);
            $sheet->setCellValue('L'.$column, $arrayPrices[9]);
            $sheet->setCellValue('M'.$column, $arrayPrices[10]);
        }

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);
        $sheet->getColumnDimension('J')->setAutoSize(true);
        $sheet->getColumnDimension('K')->setAutoSize(true);
        $sheet->getColumnDimension('L')->setAutoSize(true);
        $sheet->getColumnDimension('M')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename=Data Barang produk '.$productname.'.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit(); 
    }
  
}
