<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;

class Products extends BaseController
{
    use ResponseTrait;

    private $categoriesModel;
    private $productModel;
    private $productPriceModel;

    public function __construct(){
        $this->productModel = new \App\Models\Product();
        $this->productPriceModel = new \App\Models\ProductPrice();
        $this->categoriesModel = new \App\Models\Category();
    }

    public function index()
    {
        try {
            $productName = $this->request->getVar("product_name");
            $rumus = $this->productPriceModel->findAll();
            $allProducts = [];
            $margins = [];

            foreach ($rumus as $formula) {
                $products = $this->productModel->where("price_id", $formula->id);

                if (!empty($productName)) {
                    $products = $products->like("name", $productName);
                }

                $products = $products->orderBy("id", "asc")->findAll();

                $allProducts = array_merge($allProducts, $products);

                $margins[] = $formula->plus_one;
                $margins[] = $formula->plus_two;
                $margins[] = $formula->plus_three;
                $margins[] = $formula->plus_four;
                $margins[] = $formula->plus_five;
                $margins[] = $formula->plus_six;
                $margins[] = $formula->plus_seven;
                $margins[] = $formula->plus_eight;
                $margins[] = $formula->plus_nine;
                $margins[] = $formula->plus_ten;
            }

            if (!empty($allProducts)) {
                $response = [
                    "rumus" => $rumus,
                    "message" => "Berhasil Mengambil Data",
                    "products" => $allProducts,
                    "margins" => $margins,
                    "testing" => $this->getProducts()
                ];
                return $this->respond($response, 200);
            } else {
                return $this->failNotFound("Tidak ada produk ini di database");
            }
        } catch (\Exception $e) {
            return $this->failServerError("Internal Server Error, Silahkan coba lagi nanti");
        }
    }
    
    // public function index()
    // {
    //     try {
    //         $productName = $this->request->getVar("product_name");
    //         $rumus = $this->productPriceModel->findAll();
    //         $allProducts = [];
    //         $margins = [];
    
    //         foreach ($rumus as $formula) {
    //             $products = $this->productModel->where("price_id", $formula->id);
    
    //             if (!empty($productName)) {
    //                 $products = $products->like("name", $productName);
    //             }
    
    //             $pager = $this->productModel->pager; 
    //             $currentPage = $this->request->getVar('page_product') ? $this->request->getVar('page_product') : 1;
    //             $perPage = 36; 
    
    //             $products = $products->orderBy("id", "asc")->paginate($perPage, 'product', $currentPage);
    //             $pager = $this->productModel->pager;
    
    //             $allProducts = array_merge($allProducts, $products);
    
    //             $margins[] = $formula->plus_one;
    //             $margins[] = $formula->plus_two;
    //             $margins[] = $formula->plus_three;
    //             $margins[] = $formula->plus_four;
    //             $margins[] = $formula->plus_five;
    //             $margins[] = $formula->plus_six;
    //             $margins[] = $formula->plus_seven;
    //             $margins[] = $formula->plus_eight;
    //             $margins[] = $formula->plus_nine;
    //             $margins[] = $formula->plus_ten;
    //         }
    
    //         if (!empty($allProducts)) {
    //             $response = [
    //                 "rumus" => $rumus,
    //                 "message" => "Berhasil Mengambil Data",
    //                 "products" => $allProducts,
    //                 "margins" => $margins,
    //                 "pager" => $pager,
    //                 "testing" => $this->getProducts()
    //             ];
    //             return $this->respond($response, 200);
    //         } else {
    //             return $this->failNotFound("Tidak ada produk ini di database");
    //         }
    //     } catch (\Exception $e) {
    //         return $this->failServerError("Internal Server Error, Silahkan coba lagi nanti");
    //     }
    // }
    
    public function getProducts()
    {
        
        $products = $this->productModel
        ->join("product_prices", "products.price_id = product_prices.id", "left")
        ->where("files IS NOT NULL")
        ->orderBy("name", "asc")
        ->findAll();
        
        $prepare = $this->prepareData($products);
        
        return $prepare;
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
                "product_name" => $product->name,
                "price" => $product->price,
                "margins" => $margins,
                "gambar" => $product->files,
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

    public function show($id = null){
        
        try {
            $product = $this->productModel->find($id);

            if (!empty($product)) {
                $response = [
                    "message" => "Berhasil mengambil data",
                    "product" => $product
                ];

                return $this->respond($response, 200);
            } else {
                return $this->failNotFound("Tidak ada produk ini di database");
            }
        } catch (\Exception $e) {
            return $this->failServerError("Internal Server Error, Silahkan coba lagi nanti");
        }
    } 

}
