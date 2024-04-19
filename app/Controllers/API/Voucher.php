<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Voucher extends BaseController
{
    use ResponseTrait;

    private $voucherModel;
    private $session;

    public function __construct(){
        $this->voucherModel = model("App\Models\Voucher");
    }

    public function index()
    {
        // Ambil Semua List Voucher
        $voucher = $this->voucherModel->findAll();
        
        $response = [
           "message" => "success",
           "products" => $voucher
        ];
        
        return $this->respond($response, 200);
    }
    
    public function getByCategory()
    {
        $category = $this->request->getVar("category");
        $type = $this->request->getVar("type");
        
        $explode = explode(",", $category);
        $categories = array_map('intval', $explode);
        
        $voucher = $this->voucherModel
        ->select(["voucher.product_id", "products.name", "voucher.image", "voucher.required_points", "voucher.quantity", "voucher.validity_period"])
        ->join("products", "voucher.product_id = products.id", "left")
        ->whereIn("products.category_id", $categories)
        ->where("type", $type)
        ->orderBy("voucher.required_points", "desc")
        ->findAll();
        
        if($voucher){
            
            $response = [
               "message" => "success", 
               "products" => $voucher
            ];
            
            return $this->respond($response, 200);
        }else{
            
            $response = [
                "message" => "voucher not found",
            ];
            
            return $this->respond($respond, 404);
        }
    }

}
