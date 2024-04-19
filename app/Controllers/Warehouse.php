<?php

namespace App\Controllers;

class Warehouse extends Admin
{
    private $warehouseModel;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->db = \Config\Database::connect();
        $this->validation =  \Config\Services::validation();

        $this->warehouseModel = new \App\Models\Warehouse();
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
  
  	public function delivery_orders()
    {
     $items = $this->saleItemModel
     ->findAll();

     $data = ([
     "items" => $items,
     "db"=> $this->db,
  	 ]);
     return view('warehouse/delivery_orders', $data);
    }

    public function warehouses()
    {
        $warehouses = $this->warehouseModel
            ->where("trash", 0)
            ->orderBy("name", "asc")
            ->get()
            ->getResultObject();

        $data = ([
            "warehouses"       => $warehouses,
        ]);

        return view('modules/warehouses', $data);
    }

    public function warehouses_add()
    {
        $name = $this->request->getPost('name');
        $code = $this->request->getPost('code');
        $details = $this->request->getPost('details');
        $address = $this->request->getPost('address');

        $warehouses = $this->warehouseModel->where("code", $code)->where("trash", 0)->first();

        if ($warehouses != null) {
            $this->session->setFlashdata('message_type', 'warning');
            $this->session->setFlashdata('message_content', 'Code Gudang : <b>' . $warehouses->code . '</b> sudah terdaftar !');
            return redirect()->to(base_url('warehouses'));
        } else {
            $this->warehouseModel->insert([
                "name"          => $name,
                "code"          => $code,
                "details"          => $details,
                "address"       => "-",
                "trash"          => 0,
            ]);

            $this->session->setFlashdata('message_type', 'success');
            $this->session->setFlashdata('message_content', 'Gudang <b>' . $name . '</b> berhasil ditambahkan');

            return redirect()->to(base_url('warehouses'));
        }
    }

    public function warehouses_edit()
    {
        $id = $this->request->getPost("id");
        $name = $this->request->getPost("name");
        $code = $this->request->getPost("code");
        $details = $this->request->getPost("details");
        $address = $this->request->getPost("address");

        $warehouses = $this->warehouseModel->where("code", $code)->where("trash", 0)->first();
        $data_gudang = $this->warehouseModel->where("id", $id)->where("trash", 0)->first();

        if ($warehouses != null && $data_gudang->code != $code) {
            $this->session->setFlashdata('message_type', 'warning');
            $this->session->setFlashdata('message_content', 'Code Gudang : <b>' . $warehouses->code . '</b> sudah terdaftar !');
            return redirect()->to(base_url('warehouses'));
        } else {
            $this->warehouseModel->update($id, ([
                "name"          => $name,
                "code"          => $code,
                "details"          => $details,
                "address"       => $address,
                "trash"          => 0,
            ]));

            $this->session->setFlashdata('message_type', 'success');
            $this->session->setFlashdata('message_content', 'Gudang <b>' . $name . '</b> berhasil diubah');

            return redirect()->to(base_url('warehouses'));
        }
    }

    public function warehouses_delete($id)
    {
        $this->warehouseModel->update($id, ([
            "trash"          => 1,
        ]));

        $supplier = $this->warehouseModel->where("id", $id)->first();

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Gudang <b>' . $supplier->name . '</b> berhasil dihapus');

        return redirect()->to(base_url('warehouses'));
    }
}
