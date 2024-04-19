<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Token extends BaseController
{
    use ResponseTrait;

    private $tokenModel;
    private $session;

    public function __construct(){
        $this->tokenModel = model("App\Models\Token");
    }

    public function index()
    {
       $user_id = $this->request->getVar('users');
       
       $data = [
          "user_id" => $user_id,
          "token" => $this->generateToken($user_id)
       ];
       
       $this->tokenModel->insert($data);
    }
    
    function generateToken($user_id)
    {
       return bin2hex(random_bytes(16));
    }
}
