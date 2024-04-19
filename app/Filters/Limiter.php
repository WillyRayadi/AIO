<?php

namespace App\Filters;

use \CodeIgniter\Filters\FilterInterface;
use \CodeIgniter\HTTP\RequestInterface;
use \CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class Limiter implements FilterInterface {
    
    public function before(RequestInterface $request, $arguments = null) {
        $throttler = Services::throttler();
        $this->tokenModel = model('App\Models\Token');
        
        $user_id = $request->header('users');
        
        $token = $this->tokenModel
        ->where('user_id', $user_id)
        ->orderBy('id', 'desc')
        ->first();
        
        if($throttler->check($request->getIPAddress(), 100, MINUTE) == FALSE) {
            return Services::response()->setStatusCode(429)->setBody(json_encode(['message' => 'Terlalu Banyak Permintaan, Coba Lagi Nanti...']));
        }
    }
    
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
        ;
    }
}