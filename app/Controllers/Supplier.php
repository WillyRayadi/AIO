<?php

namespace App\Controllers;

class Supplier extends Admin
{
    private $supplierModel;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->db = \Config\Database::connect();
        $this->validation =  \Config\Services::validation();

        $this->supplierModel = new \App\Models\Supplier();
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

    public function suppliers()
    {
        $suppliers = $this->supplierModel
            ->where("trash", 0)
            ->orderBy("name", "asc")
            ->get()
            ->getResultObject();

        $data = ([
            "suppliers"       => $suppliers,
        ]);

        return view('modules/suppliers', $data);
    }

    public function suppliers_add()
    {
        $name = $this->request->getPost('name');
        $phone = $this->request->getPost('phone');
        $email = $this->request->getPost('email');
        $address = $this->request->getPost('address');

        $this->supplierModel->insert([
            "name"          => $name,
            "phone"          => $phone,
            "email"          => $email,
            "address"       => $address,
            "trash"          => 0,
        ]);

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Pemasok <b>' . $name . '</b> berhasil ditambahkan');

        return redirect()->to(base_url('suppliers'));
    }

    public function suppliers_edit()
    {
        $id = $this->request->getPost("id");
        $name = $this->request->getPost("name");
        $phone = $this->request->getPost("phone");
        $email = $this->request->getPost("email");
        $address = $this->request->getPost("address");

        $this->supplierModel->update($id, ([
            "name"          => $name,
            "phone"          => $phone,
            "email"          => $email,
            "address"       => $address,
            "trash"          => 0,
        ]));

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Pemasok <b>' . $name . '</b> berhasil diubah');

        return redirect()->to(base_url('suppliers'));
    }

    public function suppliers_delete($id)
    {
        $this->supplierModel->update($id, ([
            "trash"          => 1,
        ]));

        $supplier = $this->supplierModel->where("id", $id)->first();

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Pemasok <b>' . $supplier->name . '</b> berhasil dihapus');

        return redirect()->to(base_url('suppliers'));
    }
}
