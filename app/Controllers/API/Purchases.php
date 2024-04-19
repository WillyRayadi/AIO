<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Purchases extends BaseController
{
    use ResponseTrait; 

    private $buyModel;
    private $buyItemModel;
    
    public function __construct(){
        $this->buyModel = model("App\Models\Buy");
        $this->buyItemModel = model('App\Models\BuyItem');
        $this->deliveryModel = model('App\Models\Deliveries');
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
    
    
    public function buy_deletes(){
        $id = $this->request->getVar('id');
        $purchase_id = $this->request->getVar('id_purchases');
        
        if($purchase_id){
            $deleted = $this->buyModel->where('buys.id', $purchase_id);
            
            if($deleted){
                $response = [
                    "message" => "Berhasil Menghapus Data",
                ];
                
                return $this->respond($response, 200);
            }else{
                $response = [
                    'message' => "Gagal Menghapus Data",    
                ];
                
                return $this->respond($response, 500);
            }
        }else{
            $response = [
                'message'     => "Tidak Ada ID Purchase",
            ];
            
            return $this->failNotFound($response);
        }
    }
    
}