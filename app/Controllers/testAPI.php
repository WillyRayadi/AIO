<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;

class testAPI extends BaseController
{
    use ResponseTrait;

    private $productModel;
    private $voucherModel;
    private $pointExchangeModel;
    private $pointModel;
    private $contactModel;
    private $saleItemModel;
    private $salesModel;
    private $userAddressModel;
    private $session;
    
    public function __construct()
    {
        $this->productModel = model("App\Models\Product");
        $this->voucherModel = model("App\Models\Voucher");
        $this->pointExchangeModel = model("App\Models\PointExchange");
        $this->pointModel = model("App\Models\UserPoint");
        $this->contactModel = model("App\Models\Contact");
        $this->saleItemModel = model("App\Models\SaleItem");
        $this->salesModel = model("App\Models\Sale");
        $this->userAddressModel = model("App\Models\UserAddress");
        $this->session = \Config\Services::session();
    }
    
    public function getListVoucher()
    {
        $get = $this->request->getVar();
        if(!$get["session_name"])
        {
            return $this->failNotFound("Params Name Required");
        }
        
        $name = $get["session_name"];
        
        $users = $this->pointModel
        ->select([
            "user_point.id",
            "user_point.point_in",
            "contacts.id as contact_id",
            'contacts.name',
        ])
        ->join("contacts", "user_point.contact_id = contacts.id", "left")
        ->like("contacts.name", $name)
        ->findAll();
        
       $list = $this->voucherModel
        ->select([
            "voucher.id",
            "voucher.required_points",
            "voucher.validity_period",
            "voucher.image",
            "products.name"
        ])
        ->join("products", "voucher.product_id = products.id", "left")
        ->findAll();
        
        $point = $this->pointModel
        ->select([
            "user_point.point_in",
            'sale_items.id'
        ])
        ->select("SUM(sale_items.price * sale_items.quantity) as totalPrice")
        ->join('sale_items', 'user_point.sale_item_id = sale_items.id', 'left')
        ->join('contacts', 'user_point.contact_id = contacts.id', 'left')
        ->like("contacts.name", $name)
        ->groupBy('sale_items.sale_id')
        ->findAll();
        
        $exchange = $this->pointExchangeModel
        ->select(['point'])
        ->join('contacts', 'point_exchange.contact_id = contacts.id', 'left')
        ->like('contacts.name', $name)
        ->findAll();
        
        if(!empty($list))
        {
            $response = [
                "message" => "success",
                "list" => $list,
                "users" => $users,
                "points" => $point,
                "exchange" => $exchange
            ];
            
            return $this->respond($response, 200);
        }else{
            return $this->failNotFound("Data Tidak Ditemukan");
        }
    }
    
    public function getAllVoucher()
    {
        $products = $this->voucherModel
        ->select(["voucher.product_id", "products.name", "products.category_id","voucher.image", "voucher.required_points", "voucher.quantity", "voucher.validity_period"])
        ->join('products', 'voucher.product_id = products.id', 'left')
        ->orderBy('products.name', 'asc')
        ->findAll();
        
        if($products){
            
            $response = [
                "message" => "success",
                "products" => $products
            ];
            
            return $this->respond($response, 200);
        }else{
            
            $response = [
                "message" => "Internal Server Error, Please Try Again Later"  
            ];
            
            return $this->respond($response, 500);
        }
    }
    
    public function getVoucherByCategory()
    {
        $category = $this->request->getVar("category");
        $type = $this->request->getVar('type');
        
        $categoriesArray = explode(',', $category);
        $categoriesArray = array_map('intval', $categoriesArray);
        
        $products = $this->voucherModel
        ->select(["voucher.product_id", "products.name", "voucher.name as short_name" ,"voucher.image", "voucher.required_points", "voucher.quantity", "voucher.validity_period"])
        ->join("products", "voucher.product_id = products.id", "left")
        ->whereIn("products.category_id", $categoriesArray)
        ->where('type', $type)
        ->orderBy("voucher.name", "asc")
        ->findAll();
        
        if(!empty($products)){
            $response = [
                "message" => "success",
                "products" => $products
            ];
            
            return $this->respond($response, 200);
        }else{
            return $this->failNotFound("Data Tidak Ditemukan");
        }
    }
    
    public function getContact()
    {
        $get = $this->request->getVar();
        if(!isset($get["session_name"]))
        {
            return $this->failNotFound("Params Required");
        }
        
        $name = $get["session_name"];
        
        $Users = $this->pointModel
        ->select([
           "user_point.id",
           "user_point.point_in",
           "user_point.date",
           "contacts.name"
        ])
        ->join("contacts", "user_point.contact_id = contacts.id")
        ->like("contacts.name", $name)
        ->findAll();
        
        if(!empty($Users))
        {
            $response = [
                "message" => "Success",
                "point" => $Users
            ];
            
            return $this->respond($response, 200);
        }else{
            return $this->failNotFound("Data Tidak Ditemukan");
        }
    }
    
    public function exchange_voucher($id)
    {
        $points = $id;
        $user_point_id = $this->request->getVar("id");
        $product_name = $this->request->getVar("voucher_name");
        $totalPoint = $this->request->getVar("total_point");
        
        
        $product = $this->productModel->select(["id","name"])->where("name", $product_name)->first();


        $pointUsers = $this->pointModel->where("id", $user_point_id)->first();
        $voucher = $this->voucherModel->where("product_id", $product->id)->first();
        
        if($pointUsers === null)
        {
            return redirect()->to("https://aiostore.co.id/testing?flash_message=Point%20Anda%20Tidak%20Cukup");
        }
        
        if($totalPoint < $voucher->required_points)
        {
            $this->session->setFlashData("message", "Point Anda Tidak Cukup");
            return redirect()->to("https://aiostore.co.id/testing?flash_message=Point%20Anda%20Tidak%20Cukup");
        }else{
            
            $pointExchange = [
              "voucher_id" => $voucher->id,
              "product_id" => $product->id,
              "contact_id" => $pointUsers->contact_id,
              "point" => $points,
              "exchange_date" => date("Y-m-d")
            ];
        

            // $this->pointModel->where("id", $user_point_id)->set(["point_out" => $points, "total_point" => $pointUsers->point_in - $points])->update();
            $this->pointExchangeModel->insert($pointExchange);
            
            return redirect()->to("https://aiostore.co.id/mypoint");
        }
       
    }
    
    public function isUserExist()
    {
        $phone = $this->request->getVar("phone");
        
        $contacts = $this->contactModel->where("phone", $phone)->first();
        
        if($contacts){
            $response = [
                "messages" => "user found",
                "users" => $contacts
            ];
            
            return $this->response->setJSON($response);
        }else{
            $response = [
              "messages" => "user not found"  
            ];
            
            return $this->response->setJSON($response);
        }
    }
    
    public function checkUser()
    {
        $phone = $this->request->getVar("phone");
        
        if(!empty($phone)){
            
            $contact = $this->contactModel->where("phone", $phone)->first();
        }else{
            
            $data = [
                "type" => "2",
                "name" => $this->request->getVar("name"),
                "phone" => $this->request->getVar("telepon"),
                "email" => "-",
                "address" => $this->request->getVar("alamat"),
                "trash" => "0"
            ];
            
           $user = $this->contactModel->insert($data);
           
           if($user)
           {
                $id = $this->contactModel->getInsertID();
                $contact = $this->contactModel->where("id", $id)->first();
           }else{
               return $this->failServerError("Internal Server Error, Please Try Again Later...");
           }
           
        }
        
        $response = [
            "message" => "Success",
            "users" => $contact
        ];
            
        return $this->respond($response, 200);
        
    }
    
    public function updateUsers()
    {
        $phone = $this->request->getVar("nomor_lama");
        // $oldAddress = $this->request->getVar("alamat_lama");
         
        $users = $this->contactModel->where("is_member", 1)->where("phone", $phone)->first();
        
        if($users){
            
            // Kalau user ketemu update
            $this->contactModel->where("id", $users->id)->set(["phone" => $this->request->getVar("nomor_baru")])->update();
            // $this->userAddressModel->where("contacts_id", $users->id)->where("address", $oldAddress)->set(["address" => $this->request->getVar("alamat")])->update();
              
            $response = [
                "message" => "success"  
            ];
            
            return $this->respond($response, 200);
        }else{
            
            $response = [
                "message" => "Error, User Not Found"    
            ];
            
            return $this->respond($response, 404);
        }
    }
    
    public function insertContact()
    {
        $name = $this->request->getVar("name");
        $phone = $this->request->getVar("phone");
        $email = $this->request->getVar("email");
        $address = $this->request->getVar("address");
        
        $refCode = $this->request->getVar('referral_code');
        
        // Cek Apakah Contact Sudah Ada
        $contacts = $this->contactModel->where("phone", $phone)->first();
        
        // Jika Ada Update is_member menjadi true, jika tidak insert baru
        if(!empty($contacts)){
            
            $this->userAddressModel->insert(["contacts_id" => $contacts->id, "address" => $contacts->address]); 
            $this->contactModel->where("id", $contacts->id)->set(["is_member" => "1"])->update();
            
        }else{
        
            $data = [
                "type" => "2",
                "name" => $name,
                "phone" => $phone,
                "email" => $email,
                "address" => "-",
                "no_reference" => $refCode ?? "-",
                "is_member" => "1",
                "trash" => "0"
            ];
            
            $users = $this->contactModel->insert($data);
            
            if($users){
                
                $lastID = $this->contactModel->getInsertID();
                
                $arrayData = [
                    "contacts_id" => $lastID,
                    "address" => $address
                ];
                
                $this->userAddressModel->insert($arrayData);
            }
        
        }
        
        $response = [
            "message" => "success"  
        ];
        
        return $this->respond($response, 200);
    }
    
    public function insertNewAddress()
    {
        $phone = $this->request->getVar("telp_user");
        
        $contacts = $this->contactModel->where("is_member", 1)->where("phone", $phone)->first();
        
        if($contacts){
            
            $data = [
               "contacts_id" => $contacts->id,
               "address" => $this->request->getVar("address"),
               "kecamatan" => $this->request->getVar("kecamatan"),
               "kelurahan" => $this->request->getVar("kelurahan"),
               "kabupaten/kota" => $this->request->getVar("kabupaten/kota"),
               "provinsi" => $this->request->getVar("provinsi"),
               "kode_pos" => $this->request->getVar("kode_pos")
            ];
            
            $this->userAddressModel->insert($data);
            
            $response = [
                "message" => "Success"
            ];
            
            return $this->respond($response, 200);
        }else{
            
            $response = [
                "message" => "Failed, Contacts not found"  
            ];
            
            return $this->respond($response, 404);
        }
    }
    
    public function addUser()
    {
        $data = [
          "type" => "2",
          "name" => $this->request->getVar("name"),
          "phone" => $this->request->getVar("telepon"),
          "email" => $this->request->getVar("email"),
          "address" => "-",
          "no_refence" => "-",
          "trash" => "0",
        ];
        
        $this->contactModel->insert($data);
        
        $response = [
            "message" => "Success",
            
        ];
        
        return $this->respond($response, 200);
    }
    
    public function getUserPoint()
    {
        $phone = $this->request->getVar("phone");
        
        $contacts = $this->contactModel->where("is_member", 1)->where("phone", $phone)->first();
        
        if($contacts){
            
            $userPoint = $this->pointModel->select(["SUM(point_in) as total_points"])->where("contact_id", $contacts->id)->findAll();
            
            $response = [
                "message" => "success",
                "points" => $userPoint 
            ];
            
            
            return $this->respond($response, 200);
        }else{
            
            $response = [
                "message" => "user not found"    
            ];
            
            return $this->respond($response, 404);
        }
    }
    
    public function exchangeUserPoint()
    {
        $phone = $this->request->getVar("user_phone");
        $productID = $this->request->getVar("product_id");
        $userTotalPoint = $this->request->getVar("total_point");
        
        $contacts = $this->contactModel->where("is_member", 1)->where("phone", $phone)->first();
        $voucher = $this->voucherModel->where('product_id', $productID)->first();
        
        if($contacts && $voucher){
            
            /* Cek Point user apakah cukup jika tidak redirect kembali ke halaman point
             * Jika Sesuai Insert ke table point_exchange ambil last insert id, lalu insert ke table user_point
             */ 
             
            if($userTotalPoint < $voucher->required_points){
                
                return redirect()->to('https://aiostore.co.id/point/?message=Point%20Tidak%20Cukup');
            }else{
                
                $voucherCode = $this->generateVoucherCode(12);
                
                $dataExchange = [
                    "code" => $voucherCode,
                    "voucher_id" => $voucher->id,
                    "product_id" => $productID,
                    "contact_id" => $contacts->id,
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
                        "point_in" => 0 - $voucher->required_points
                    ];
                    
                    $this->pointModel->insert($dataPoint);
                    
                    
                    return redirect()->to('https://aiostore.co.id/point?message=berhasil');
                }
                
            }
        }
    }
    
    public function getUserVoucher()
    {
        $phone = $this->request->getVar("phone");
        
        $contacts = $this->contactModel->where("is_member", 1)->where("phone", $phone)->first();
        
        if($contacts){
            
            $voucher = $this->pointExchangeModel
            ->select(["point_exchange.id as id_voucher", "point_exchange.code as kode_voucher", "point_exchange.exchange_date", "products.name"])
            ->join('products', 'point_exchange.product_id = products.id', 'left')
            ->where("point_exchange.contact_id", $contacts->id)
            ->where("is_claimed", 1)
            ->where("is_redeemed IS NULL")
            ->findAll();
            
            if($voucher){
                
                $response = [
                   "message" => "success",
                   "voucher" => $voucher
                ];
                
                return $this->respond($response, 200);
            }else{
                return $this->failNotFound("Maaf, Kamu belum memiliki riwayat penukaran point");
            }        
    
        }else{
            
            $response = [
                "message" => "Contact Not Found"  
            ];
            
            return $this->respond($response, 404);
        }
    }
    
    public function getTotalUserTransaction()
    {
        $phone = $this->request->getVar("phone");
        
        $contacts = $this->contactModel->where("is_member", 1)->where("phone", $phone)->first();
        
        if($contacts){
            
            // Ambil Semua Total Transaksi
            $totalTransaction = $this->salesModel
            ->select("SUM(sale_items.quantity * sale_items.price) as total")
            ->join('sale_items', 'sales.id = sale_items.sale_id', 'left')
            ->where("sales.transaction_date >=", date('Y-01-01'))
            ->where('sales.transaction_date <=', date('Y-12-31'))
            ->where('sales.contact_id', $contacts->id)
            ->where('sales.status', 6)
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
    
    public function updateUserPrimaryAddress()
    {
        $alamatUtama = $this->request->getVar("alamat_utama");
        $alamatYangInginDijadikanUtama = $this->request->getVar('alamat');
        $telepon = $this->request->getVar('no_telepon');
        
        $user = $this->contactModel->where('is_member', 1)->where("phone", $telepon)->first();
        
        if($user){
            
            if(!empty($alamatUtama)){
                
                $this->userAddressModel->where('contacts_id', $user->id)->where("address", $alamatUtama)->set(["is_primary" => NULL])->update();
                $this->userAddressModel->where('contacts_id', $user->id)->where("address", $alamatYangInginDijadikanUtama)->set(["is_primary" => 1])->update();
            }else{
                $this->userAddressModel->where('contacts_id', $user->id)->where("address", $alamatYangInginDijadikanUtama)->set(["is_primary" => 1])->update();
            }
            
            return $this->respond("OK", 200);
        }else{
            return $this->respond("user not found", 404);
        }
        
    
    }
    
    public function updateAddress()
    {
        $phone = $this->request->getVar('phone');
        $oldAddress = $this->request->getVar("old_address");
        
        $contacts = $this->contactModel->where("is_member", 1)->where("phone", $phone)->first();
        
        if($contacts){
            
            // Kalau Ketemu Update Data
            $data = [
               "contacts_id" => $contacts->id,
               "address" => $this->request->getVar("address"),
               "kecamatan" => $this->request->getVar("kecamatan"),
               "kelurahan" => $this->request->getVar("kelurahan"),
               "kabupaten/kota" => $this->request->getVar("kabupaten/kota"),
               "provinsi" => $this->request->getVar("provinsi"),
               "kode_pos" => $this->request->getVar("kode_pos")
            ];
            
            $this->userAddressModel->where("address", $oldAddress)->set($data)->update();
            
            return $this->respond("OK", 200);
        }else{
            return $this->respond("Contacts Not Found", 404);
        }
    }
    
    public function deleteUserAddress()
    {
        $alamat = $this->request->getVar("alamat");
        $phone = $this->request->getVar("phone");
        
        $contacts = $this->contactModel->where('is_member', 1)->where('phone', $phone)->first();
        
        if($contacts){
            $this->userAddressModel->where('contacts_id', $contacts->id)->where('address', $alamat)->delete();
            
            return $this->respond("OK", 200);
        }else{
            return $this->respond("contact not found", 404);
        }
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
