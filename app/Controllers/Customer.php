<?php

namespace App\Controllers;

class Customer extends Admin
{
    private $customerModel;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->db = \Config\Database::connect();
        $this->validation =  \Config\Services::validation();

        $this->customerModel = new \App\Models\Customer();
        helper("form");

        if($this->session->login_id == null){            
            $this->session->setFlashdata('msg', 'Maaf, Silahkan login terlebih dahulu!');
            header("location:".base_url('/'));
            exit();
        }else{
            if(config("Login")->loginRole != 1){
                if(config("Login")->loginRole != 7){
                    header("location:".base_url('/dashboard'));
                    exit();
                }
            }
        }
    }

    public function customers()
    {
        $customers = $this->customerModel
            ->where("trash", 0)
            ->orderBy("name", "asc")
            ->get()
            ->getResultObject();

        $data = ([
            "customers"       => $customers,
        ]);

        return view('modules/customers', $data);
    }

    public function customers_add()
    {
        $name = $this->request->getPost('name');
        $phone = $this->request->getPost('phone');
        $email = $this->request->getPost('email');
        $address = $this->request->getPost('address');

        $this->customerModel->insert([
            "name"          => $name,
            "phone"          => $phone,
            "email"          => $email,
            "address"       => $address,
            "trash"          => 0,
        ]);

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Customer <b>' . $name . '</b> berhasil ditambahkan');

        return redirect()->to(base_url('customers'));
    }

    public function customers_edit()
    {
        $id = $this->request->getPost("id");
        $name = $this->request->getPost("name");
        $phone = $this->request->getPost("phone");
        $email = $this->request->getPost("email");
        $address = $this->request->getPost("address");

        $this->customerModel->update($id, ([
            "name"          => $name,
            "phone"          => $phone,
            "email"          => $email,
            "address"       => $address,
            "trash"          => 0,
        ]));

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Customer <b>' . $name . '</b> berhasil diubah');

        return redirect()->to(base_url('customers'));
    }

    public function customers_delete($id)
    {
        $this->customerModel->update($id, ([
            "trash"          => 1,
        ]));

        $supplier = $this->customerModel->where("id", $id)->first();

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Customer <b>' . $supplier->name . '</b> berhasil dihapus');

        return redirect()->to(base_url('customers'));
    }
}
