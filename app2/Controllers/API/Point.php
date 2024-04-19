<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Point extends BaseController
{
    use ResponseTrait;

    private $productModel;
    private $voucherModel;
    private $pointExchangeModel;
    private $pointModel;
    private $contactModel;
    private $stockModel;
    private $saleModel;

    public function __construct() {
        $this->productModel = model("App\Models\Product");
        $this->voucherModel = model("App\Models\Voucher");
        $this->pointExchangeModel = model("App\Models\PointExchange");
        $this->pointModel = model("App\Models\UserPoint");
        $this->contactModel = model("App\Models\Contact");
        $this->stockModel = model("App\Models\ProductStock");
        $this->saleModel = model('App\Models\Sale');
    }

    public function index()
    {
        $phone = $this->request->getVar("phone");
        
        $contacts = $this->contactModel->where("is_member", 1)->where("phone", $phone)->first();
        
        if($contacts){
            
            $userPoint = $this->pointModel->select(["SUM(point_in) as total_points"])->where("contact_id", $contacts->id)->findAll();
            
            $response = [
                "message" => "success",
                "points" => $userPoint,
            ];
            
            return $this->respond($response, 200);
        }else{
            
            $response = [
                "message" => "user not found"    
            ];
            
            return $this->respond($response, 404);
        }
    }
    
    public function redeemPoint()
    {
        $phone = $this->request->getVar("user_phone");
        $productID = $this->request->getVar("product_id");
        $userTotalPoint = $this->request->getVar("total_point");
        
        $contacts = $this->contactModel->where("is_member", 1)->where("phone", $phone)->first();
        $voucher = $this->voucherModel->where('product_id', $productID)->first();
        
        // For Redirect
        $category = $this->request->getVar("category");
        $type = $this->request->getVar('type');
        
        $products = $this->voucherModel->select(["name as product_name"])->where('product_id', $productID)->first();
        
        if($contacts && $voucher){
            
            /* Cek Point user apakah cukup jika tidak redirect kembali ke halaman point
             * Jika Sesuai Insert ke table point_exchange ambil last insert id, lalu insert ke table user_point
             */
             
             
            if($userTotalPoint < $voucher->required_points){
                
                $redirectURL = "https://aiostore.co.id/all-voucher?category=$category&type=$type&status=Insufficient";
            
                return $this->response->setJSON(["redirect_url" => $redirectURL]);
                
            }else{
                
                $checkStock = $this->stockModel->select(['SUM(quantity) as total_quantity'])->where('product_id', $productID)->first();
                
                if($checkStock->total_quantity <= 0){
                    
                    $redirectURL = "https://aiostore.co.id/all-voucher?category=$category&type=$type&status=Failed";
                    
                    return $this->response->setJSON(["redirect_url" => $redirectURL]);
                }
                
                
                $voucherCode = $this->generateVoucherCode(12);
                
                $dataExchange = [
                    "code" => $voucherCode,
                    "voucher_id" => $voucher->id,
                    "product_id" => $productID,
                    "contact_id" => $contacts->id,
                    // 'quantity' => 1,
                    "point" => $voucher->required_points,
                    "exchange_date" => date("Y-m-d"),
                    'is_claimed' => 1
                ];
                
                $data = $this->pointExchangeModel->insert($dataExchange);
                
                if($data){
                    
                    $exchange = $this->pointExchangeModel->getInsertID();
                    
                    $dataPoint = [
                        "contact_id" => $contacts->id,
                        "exchange_id" => $exchange,
                        "date" => date('Y-m-d'),
                        "point_in" => 0 - $voucher->required_points,
                    ];
                    
                    $this->pointModel->insert($dataPoint);
                    
                   $redirectURL = "https://aiostore.co.id/all-voucher?category=$category&type=$type&status=Success&product=$products->product_name";
                   
                   return $this->response->setJSON(["redirect_url" => $redirectURL]);
                }
                
            }
        }else{
            
            // redirect back
            $redirectURL = "https://aiostore.co.id/all-voucher?category=$category&type=$type&status=404";
            
            return $this->response->setJSON(["redirect_url" => $redirectURL]);
        }
    }
    
    public function getMyVoucher()
    {
        $phone = $this->request->getVar('phone');
        
        $contacts = $this->contactModel
        ->select(['contacts.id'])
        ->where('is_member', 1)
        ->where('phone', $phone)
        ->first();
                                
        if($contacts) {
            // Get Claimed Voucher
            $voucher = $this->pointExchangeModel
            ->select([
               "point_exchange.code",
               "point_exchange.point",
               "point_exchange.exchange_date",
               "voucher.name",
               "voucher.image"
            ])
            ->join('voucher', 'point_exchange.voucher_id = voucher.id', 'left')
            ->where('contact_id', $contacts->id)
            ->where('is_claimed', 1) 
            ->where('is_redeemed', NULL)
            ->findAll();
            
            $response = [
                "message" => "success",    
                "voucher" => $voucher
            ];
            
            return $this->respond($response, 200);
        }
    }
    
    public function getMyRedeemedVoucher() 
    {
        $phone = $this->request->getVar('phone');
        
        $contacts = $this->contactModel->select(['contacts.id'])->where('is_member', 1)->where('phone', $phone)->first();
        
        if($contacts) {
            
            $voucher = $this->pointExchangeModel
            ->select([
               "point_exchange.code",
               "point_exchange.point",
               "point_exchange.exchange_date",
               "voucher.name",
               "voucher.image"
            ])
            ->join('voucher', 'point_exchange.voucher_id = voucher.id', 'left')
            ->where('is_redeemed', 1)
            ->where('contact_id', $contacts->id)
            ->orderBy('point_exchange.id', 'desc')
            ->findAll();
            
            $response = [
                "message" => "success",
                "voucher" => $voucher
            ];  
            
            return $this->respond($response, 200);
        }
    }
    
    public function checkUserTotalTransaction()
    {
        $phone = $this->request->getVar('phone');
        
        $contacts = $this->contactModel->where('is_member', 1)->where('phone', $phone)->first();
        
        if($contacts) {
            
            $totalTransaction = $this->calculateTotalTransaction($contacts->id);
            
            if($totalTransaction >= 200000000) {
                
                $lastClaimedVoucher = $this->pointExchangeModel
                ->where('contact_id', $contacts->id)
                ->where('product_id', 2504)
                ->orderBy("id", "desc")
                ->first();
                
                $isEligible = false;
                
                if(!$lastClaimedVoucher || strtotime($lastClaimedVoucher->exchange_date) < strtotime('-1 month')) {
                    $isEligible = true;
                }
                
                if($isEligible) {
                    
                    $data = [
                        'code' => $this->generateVoucherCode(12),
                        'voucher_id' => 44,
                        'product_id' => 2504,
                        'contact_id' => $contacts->id,
                        'point' => 0,
                        'exchange_date' => date('Y-m-d'),
                        'is_claimed' => 1
                    ]; 
                    
                    $this->pointExchangeModel->insert($data);
    
                }else{
                    return $this->respond(["message" => "Voucher Hanya Bisa Diklaim 1 bulan sekali"]);
                }
                
            }
        }else{
            return $this->respond(["message" => "contacts not found"]);
        }
    }
    
    private function calculateTotalTransaction($id)
    {
        $sales = $this->saleModel
        ->select(['SUM(sale_items.price * sale_items.quantity) as totalPrice'])
        ->join('sale_items', 'sales.id = sale_items.sale_id', 'left')
        ->where('sales.contact_id', $id)
        ->findAll();
        
        $total = 0;
        
        foreach($sales as $item):
            $total += $item->totalPrice;
        endforeach;
        
        return $total;
    }

    function generateVoucherCode($length = 12) 
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $randomString = '';
    
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
    
        return $randomString;
    }
}
