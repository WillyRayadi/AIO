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
    }
    
    public function index(){
        $id = $this->request->getPost('purchase_id');
        
        $headers = $this->buyModel
        ->select([
            'buys.id',
            'buys.date as purchase_delivery',
            'buys.number as buy_number',
        ])
        ->where('buys.id', $id)
        ->get()->getResultObject();
        
        if($headers){
            $items = $this->buyItemModel
            ->select([
                'buys.number as buy_number',
                'buy_items.quantity as buy_qty',
            ])
            ->join('buys', 'buy_items.buy_id = buys.id', 'left')
            ->groupBy('buy_items.buy_id')
            ->where('buy_items.buy_id', $id)
            ->findAll();
            
            if(!empty($items)){
                $response = [
                    "message"  => "success",
                    'headers'  => $headers,
                ];
                
                return $this->respond($response, 200);
            }else{
                $response = [
                    "message"  => "Tidak ada item di data purchases ini",
                ];
                
                return $this->respond($response, 400);
            }
        }else{
            $response = [
                "message"  => "Nomer PD tidak ditemukan",
            ];
            
            return $this->respond($response, 400);
        }
    }
    
}