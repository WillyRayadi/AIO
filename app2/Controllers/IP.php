<?php

namespace App\Controllers;

class IP extends BaseController
{
    protected $session;
    protected $validation;
    protected $db;

    protected $addressModel;

    public function __construct(){
        $this->session = \Config\Services::session();

        $this->db = \Config\Database::connect();
        $this->validation =  \Config\Services::validation();
        
        $this->addressModel = new \App\Models\Address();

        if($this->session->login_id == null){            
            $this->session->setFlashdata('msg', 'Maaf, Silahkan login terlebih dahulu!');
            header("location:".base_url('/'));
            exit();
        }else{            
        }
    }

    public function ajax_check_ip(){
        $ip = $this->request->getPost("ip");
        

        if(config("Login")->loginRole == 7){
            echo "1";
        }elseif(config("Login")->loginRole == 3){
            echo "1";
        }else{
            $ipExist = $this->addressModel->where("address",$ip)->first();
    
            if($ipExist){
                echo "1";
            }else{
                echo "0";
            }
        }
    }
}