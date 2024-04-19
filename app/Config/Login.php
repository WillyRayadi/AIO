<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Login extends BaseConfig
{
    private $session;
    private $adminModel;

    public $loginName = NULL;
    public $loginAddress = NULL;
    public $loginPhone = NULL;
    public $loginEmail = NULL;
    public $loginUsername = NULL;
    public $loginRole = NULL;
    public $loginSaleTarget = NULL;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->adminModel = new \App\Models\Administrator();

        if ($this->session->login_id != NULL) {
            $admin = $this->adminModel->where("id", $this->session->login_id)->first();

            $this->loginName = $admin->name;
            $this->loginAddress = $admin->address;
            $this->loginPhone = $admin->phone;
            $this->loginEmail = $admin->email;
            $this->loginUsername = $admin->username;
            $this->loginRole = $admin->role;
            $this->loginSaleTarget = $admin->sale_target;
        }
    }
}
