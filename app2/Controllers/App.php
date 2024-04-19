<?php

namespace App\Controllers;

class App extends BaseController
{
    protected $session;
    protected $validation;
    protected $db;

    protected $adminModel;
    protected $addressModel;

    public function __construct(){
        $this->session = \Config\Services::session();

        $this->db = \Config\Database::connect();
        $this->validation =  \Config\Services::validation();
        
        $this->adminModel = new \App\Models\Administrator();
        $this->addressModel = new \App\Models\Address();
        
    }
}