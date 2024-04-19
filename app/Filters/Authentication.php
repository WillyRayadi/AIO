<?php

namespace App\Filters;

use \CodeIgniter\Filters\FilterInterface;
use \CodeIgniter\HTTP\RequestInterface;
use \CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class Authentication implements FilterInterface {
    
    private $apiKeyModel;
    private $throttler;
    
    public function __construct()
    {
        $this->apiKeyModel = model('App\Models\ApiKey');
        $this->throttler = Services::throttler();
    }
    
    public function before(RequestInterface $request, $arguments = null) {
        
        $headers = $this->checkRequestHeader($request->getHeaders(), $_SERVER['REQUEST_URI']);
        
        if($headers == false) {
            $data = [
                'messages' => 'invalid parameter',
                'status' => 401,
                'error' => true
            ];   
            
           return Services::response()->setStatusCode(401)->setJSON($data);
        }
        
        if($headers['secret_key'] != getenv('APP_SECRET_KEY')) {
            $data = [
                'messages' => 'invalid secret key',
                'status' => 401,
                'error' => true
            ];   
            
           return Services::response()->setStatusCode(401)->setJSON($data);
        }
        
        if($_SERVER['REQUEST_URI'] === '/api/generate-key') {
            return; 
        }
        
        $api = $this->getApiKey($headers['api_key']);
            
        if($api == false) {
            $data = [
                'messages' => 'invalid api key',
                'status' => 401,
                'error' => true
            ];   
                
            return Services::response()->setStatusCode(401)->setJSON($data);
        }
        
        if(!$this->validateApiKey($api['exp_time'])) {
            $data = [
                'messages' => 'api key expired',
                'status' => 401,
                'error' => true,
            ];   
                
            return Services::response()->setStatusCode(401)->setJSON($data);
        }
    }
    
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
        ;
    }
    
    private function checkRequestHeader($headers, $request)
    {
        if($request == "/api/generate-key") {
            
            if(!isset($headers['X-Aio-Secret-Key'])) {
                return false;
            }
            
            $secretKey = explode(' ', $headers['X-Aio-Secret-Key']);
            
            return [
                'secret_key' => $secretKey[1]    
            ];
        }
        
        if(!isset($headers['X-Aio-Secret-Key'])) {
            return false;
        }
        
        if(!isset($headers['X-Api-Key'])) {
            return false;
        }
        
        $secretKey = explode(' ', $headers['X-Aio-Secret-Key']);
        $apiKey = explode(' ', $headers['X-Api-Key']);
        
        return [
            'secret_key' => $secretKey[1],
            'api_key' => $apiKey[1]
        ];
    }
    
    private function getApiKey($api_key)
    {
        $api = $this->apiKeyModel->select(['api_key', 'expired_time'])->where('api_key', $api_key)->first();
        
        if(!isset($api->api_key)) {
            return false;
        }
        
        return [
            'api_key' => $api->api_key,
            'exp_time' => $api->expired_time
        ];
    }
    
    private function validateApiKey($exp_time)
    {
        $currentTime = strtotime(date('Y-m-d H:i:s'));
        
        if($currentTime > strtotime($exp_time)) {
            return false;
        }
        
        return true;
    }
}