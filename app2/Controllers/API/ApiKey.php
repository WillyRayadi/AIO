<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class ApiKey extends BaseController
{
    use ResponseTrait;

    private $apiKeyModel;

    public function __construct(){
        $this->apiKeyModel = model("App\Models\ApiKey");
    }

    public function insert()
    {
        $expTime = time() + (7 * 24 * 60 * 60);
        $expiredTime = date("Y-m-d H:i:s", $expTime);
        
        $data = [
           'api_key' => $this->generateApiKey(32),
           'created_at' => date('Y-m-d H:i:s'),
           'expired_time' => $expiredTime
        ];
        
        $this->apiKeyModel->insert($data);
        
        return $this->respondCreated($data);
    }
    
    public function checkApiKey()
    {
        $headers = $this->request->getHeaders();
        
        $apiKey = explode(' ', $headers['X-Api-Key']);
        
        $api = $this->apiKeyModel->where('api_key', $apiKey[1])->first();
        
        $data = [
            "message" => "success",
            "status" => 200,
            "expired_at" => $api->expired_time,
            "error" => false
        ];
    
        return $this->respond($data, 200);
    }
    
    public function generateApiKey($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $characters_length = strlen($characters);
        $random_string = '';

        for ($i = 0; $i < $length; $i++) {
            $random_string .= $characters[rand(0, $characters_length - 1)];
        }

        return $random_string;
    }
    
}
