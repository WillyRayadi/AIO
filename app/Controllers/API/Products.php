<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Products extends BaseController
{
    use ResponseTrait;

    private $db;
    private $categoriesModel;
    private $productModel;
    private $productPriceModel;

    public function __construct(){ 
        $this->db = \Config\Database::connect();
        $this->productModel = new \App\Models\Product();
        $this->productPriceModel = new \App\Models\ProductPrice();
        $this->categoriesModel = new \App\Models\Category();
    }

    public function index()
    {
        try {
            $page = $this->request->getVar('page') ?? 1;
            $perPage = $this->request->getVar('perPage') ?? 36;
            
            $start = ($page - 1) * $perPage;
            
            $products = $this->getProducts($perPage, $page);
            
            // $products = $this->getProducts();
            
            $total = $this->productModel
            ->where('files !=', NULL)
            ->countAllResults();
         
            $number = ($page <= 0) ? null: $page;
            $totalPage = ($perPage <= 0) ? null: ceil($total / $perPage);
            
            $firstPage = ($page == 1);
            $lastPage = ($number == $totalPage);

            if (!empty($products)) {
                $response = [
                    "message" => "Berhasil Mengambil Data",
                    "products" => $products,
                    "pagination" => [
                        "page" => $page,
                        "size" => $perPage,
                        "totalPage" => $totalPage,
                        "number" => $number,
                        "firstPage" => $firstPage,
                        "lastPage" => $lastPage
                    ] 
                ];
                return $this->respond($response, 200);
            } else {
                return $this->failNotFound("Tidak ada produk ini di database");
            }
        } catch (\Exception $e) {
            return $this->failServerError("Internal Server Error, Silahkan coba lagi nanti");
        }
    }
    
    public function dataProduct(){
        $id = $this->request->getVar('id');
         
        $dataProd = $this->productModel
        ->select([
            'products.details',
            'capacity.kapasitas',
            'products.sku_number',
            'products.files as pict_first',
            'products.files1 as pict_behind',
            'products.files2 as pict_left',
            'products.files3 as pict_right',
            'products.name as product_name', 
            'products.price as product_price',
            'categories.name as category_name',
            'products.item_width',
            'products.item_height',
            'products.item_length',
            "product_prices.plus_one",  
            "product_prices.plus_two",  
            "product_prices.plus_three",  
            "product_prices.plus_four",  
            "product_prices.plus_five",  
            "product_prices.plus_six",  
            "product_prices.plus_seven",  
            "product_prices.plus_eight",  
            "product_prices.plus_nine",  
            "product_prices.plus_ten", 
        ])
        ->join('capacity','products.capacity_id = capacity.id','left')
        ->join('categories','products.category_id = categories.id','left')
        ->join("product_prices", "products.price_id = product_prices.id", "left")
        ->where('products.id', $id)
        ->findAll(); 
         
        $response = [
            "message" => "success",
            "dataProd" => $dataProd,
        ];
            
        return $this->respond($response, 200);
    }
    
    public function getTotalProducts()
    {
        $products = $this->getProducts();
        $totalProducts = count($products);
        
        $response = [
            "message" => "Berhasil Mengambil Data",
            "total_products" => $totalProducts    
        ];
        
        return $this->respond($response, 200);
    }
    
    public function getProducts($perPage, $start){
        $products = $this->productModel
        ->select([
            "products.id",
            "products.name",  
            "products.files",  
            "products.price",  
            "products.category_id",  
            "product_prices.plus_one",  
            "product_prices.plus_two",  
            "product_prices.plus_three",  
            "product_prices.plus_four",  
            "product_prices.plus_five",  
            "product_prices.plus_six",  
            "product_prices.plus_seven",  
            "product_prices.plus_eight",  
            "product_prices.plus_nine",  
            "product_prices.plus_ten",  
        ])
        ->join("product_prices", "products.price_id = product_prices.id", "left")
        ->where('files !=', NULL)
        ->orderBy("name", "asc")
        // ->findAll();
        ->paginate($perPage, "products", $start);
        
        $prepare = $this->prepareData($products);
        
        return $prepare;
    }
    
    public function getFilteredProducts(){
        
        $productsName = $this->request->getVar("product_name");
        $products = $this->productModel
        ->join("product_prices", "products.price_id = product_prices.id", "left")
        ->where('files !=', NULL)
        ->like("name", $productsName)
        ->orderBy("name", "asc")
        ->findAll();
        
        $prepare = $this->prepareData($products);
        
        if(!empty($prepare)){
            $response = [
                "message" => "Success",
                "products" => $prepare,
            ];
            
            return $this->respond($response, 200);
        }else {
            return $this->failNotFound("Tidak ada produk ini di database");
        }
    }
    
    public function getProductsByCategories()
    {
        $category = $this->request->getVar("categories");
        
        $products = $this->productModel
        ->join("product_prices", "products.price_id = product_prices.id", "left")
        ->where('files !=', NULL)
        ->where("category_id", $category)
        ->orderBy("name", "asc")
        ->findAll();
        
        $prepare = $this->prepareData($products);
        
        if(!empty($prepare)){
            $response = [
                "message" => "Success",
                "products" => $prepare,
            ];
            
            return $this->respond($response, 200); 
        }else {
            return $this->failNotFound("Tidak ada produk ini di database");
        }
    }
    
    public function prepareData($products)
    {
        $data = [];
        $margins = [];
        foreach($products as $product)
        {
            $margins = [
                $product->plus_one,
                $product->plus_two,
                $product->plus_three,
                $product->plus_four,
                $product->plus_five,
                $product->plus_six,
                $product->plus_seven,
                $product->plus_eight,
                $product->plus_nine,
                $product->plus_ten
            ];
            
            $rowData = [
                "product_id" => $product->id,
                "product_name" => $product->name,
                "price" => $product->price,
                "margins" => $margins,
                "gambar" => $product->files,
                "kategori" => $product->category_id
            ];
            
            $data[] = $rowData;
        }
        
        
        return $data;
    }
    
    public function findProducts($products, $rumusID)
    {
        foreach($products as $product){
            if($product->price_id == $rumusID){
                $data = [
                  "products_name" => $product->name,
                  "price" => $product->price,
                  "files" => $product->files,
                  "sku_number" => $product->sku_number
                ];
                
                return $data;
            }
        }
        
        return "";
    }


}
