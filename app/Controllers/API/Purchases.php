<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Purchases extends BaseController
{
    use ResponseTrait; 

    private $buyModel;
    private $productModel;
    private $buyItemModel;
    private $validation;
    private $warehouseModel;
    
    public function __construct(){
        $this->buyModel = model("App\Models\Buy");
        $this->buyItemModel = model('App\Models\BuyItem');
        $this->productModel = model('App\Models\Product');
        $this->validation = \Config\Services::validation();
        $this->warehouseModel = model('App\Models\Warehouse');
    }

    public function index(){
        try {
            $buys = $this->buyModel->orderBy('buys.id','desc')->get()->getResultObject();
            
            if (!empty($buys)) {
                $response = [
                    "message" => "Berhasil Mengambil Data",
                    "buys" => $buys,
                ];
                return $this->respond($response, 200);
            } else {
                // Respon jika tidak ada data
                return $this->failNotFound("Tidak ada data purchase order");
            }
            
        } catch (\Exception $e) {
            // Respon jika gagal mengambil data
            return $this->failServerError("Internal Server Error, Silahkan coba lagi nanti");
        }
    }
    
    public function insert(){
        $body = $this->validate([
            "suppliers" => [
                "rules" => "required",
                "errors" => [
                    "required" => "{field} is required" 
                ]
            ],
            "purchases" => [
                "rules" => "required",
                "errors" => [
                    "required" => "{field} is required",
                    "valid_date" => "{field} should be a valid date"
                ]
            ],
            "remarks" => [
                "rules" => "required",
                "errors" => [
                    "required" => "{field} is required"   
                ]
            ],
            "warehouses" => [
                "rules" => "required",
                "errors" => [
                    "required" => "{field} is required"
                ]
            ],
            "products"  => [
                "rules" => "required",
                "errors" => [
                    "required" => "{field} is required"
                ]
            ],
        ]);   
    
        if(!$body){
            $data = [
                "messages" => implode(", ", $this->validation->getErrors()),
                "status" => 400,
                "error" => true
            ];    
            return $this->respond($data, 400);
        }
    
        $suppliers = $this->request->getVar('suppliers');
        $warehouses = $this->request->getVar('warehouses');
        $products = $this->request->getVar('products');
        
        $gudang = $this->warehouseModel->where('name', $warehouses)->first();
        
        $data = [
            'date'        => date("Y-m-d"),
            'supplier_id' => $suppliers,
            'warehouse_id' => $gudang->id,
            'admin_id'  => 38,
        ];
        
        $purchases = $this->buyModel->insert($data);
        $purchaseID = $this->buyModel->getInsertID();
        $purchase_number = "PD/".date("y")."/".date("m")."/".$purchaseID;
        
        $this->buyModel->where('id', $purchaseID)
        ->set([
            'number'    => $purchase_number
        ])->update();
    
        if(!$purchaseID){
            $message = [
                "error" => "Failed to insert purchase."
            ];
        
            return $this->failValidationError(json_encode($message));
        }


        foreach($products as $product){
            $id_product = $this->productModel
            ->where('sku_number', $product->sku)
            ->first();

            $this->buyItemModel->insert([
                'price'       => 0,
                'approve_status' => 0,
                'admin_approve_id' => 0,  
                'product_id'  => $id_product->id,
                'quantity'    => $product->quantity,
                'buy_id'      => $purchaseID,
            ]);
        }
        
        $id = $this->buyModel->getInsertID();
        
        array_unshift($data, ["purchase_id" => $id]);
    
        $success = [
            "status"    => 201,
            "error"     => false,
            "message"   => "success",
            'purchase_delivery' => $data,
        ];
    
        return $this->respondCreated($success);
    }

    public function delete()
    {
        $body = $this->validate([
            "id" => [
                "rules" => "required",
                "errors" => [
                    "required" => '{field} is required'
                ]
            ] 
        ]);
        
        if(!$body) {
                
            $data = [
                "messages" => implode(", ", $this->validation->getErrors()),
                "status" => 400,
                "error" => true
            ];    
            
            return $this->respond($data, 400);
        }
        
        $buys = $this->buyModel->select('buys.id')->where('id', $this->request->getVar('id'))->first();
        
        if(empty($buys->id)) {
            $data = [
                "messages" => "Purchases Delivery History Not Found",
                "status" => 404,
                "error" => true
            ];
            
            return $this->respond($data, 404);
        }
        
        $this->buyModel->where('id', $buys->id)->delete();
        $this->buyItemModel->where('buy_id', $buys->id)->delete();
        
        $data = [
            "messages" => "Purchase History Success Deleted!",
            "status" => 200,
            "error" => false
        ]; 
        
        return $this->respond($data, 200);
    }
}