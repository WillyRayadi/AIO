<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Sales extends BaseController
{
    use ResponseTrait;

    private $salesModel;
    private $categoriesModel;
    private $productModel;
    private $productPriceModel;
    private $contactModel;

    public function __construct(){
        $this->salesModel = model("App\Models\Sale");
        $this->productModel = new \App\Models\Product();
        $this->productPriceModel = new \App\Models\ProductPrice();
        $this->categoriesModel = new \App\Models\Category();
        $this->contactModel = model("App\Models\Contact");
    }

    public function index()
    {
        // Ambil Total Seluruh Transaksi User
        $phone = $this->request->getVar("phone");
        
        $contacts = $this->contactModel->where("phone", $phone)->first();
        
        if($contacts){
            
            $totalTransaction = $this->salesModel
            ->select("SUM(sale_items.quantity * sale_items.price) as total")
            ->join('sale_items', 'sales.id = sale_items.sale_id', 'left')
            // ->where("sales.transaction_date >=", date('Y-01-01'))
            // ->where('sales.transaction_date <=', date('Y-12-31'))
            ->where('sales.contact_id', $contacts->id)
            // ->where('sales.status', 6)
            ->findAll();
            
            if(!empty($totalTransaction)){
                
                $response = [
                    "message" => "success",
                    "sales" => $totalTransaction
                ];
                
                return $this->respond($response, 200);
            }else{
                
                $response = [
                    "message" => "User Tidak Memiliki Riwayat Transaksi",
                ];
                
                return $this->respond($response, 404);
            }
        }else{
            
             $response = [
                "message" => "User Tidak Ditemukan"  
            ];
            
            return $this->respond($response, 404);
        }
    }

}
