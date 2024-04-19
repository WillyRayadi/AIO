<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Vehicle extends BaseController
{
    private $vehicleModel;
    private $session;
    private $validation;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $db = \Config\Database::connect();
        $this->validation =  \Config\Services::validation();

        $this->vehicleModel = new \App\Models\Vehicle();
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

    public function vehicle()
    {
        $vehicles = $this->vehicleModel
            ->where("trash", 0)
            ->orderBy("brand", "asc")
            ->get()
            ->getResultObject();

        $data = ([
            "vehicles"       => $vehicles,
        ]);

        return view('modules/vehicles', $data);
    }

    public function vehicle_add()
    {
        $brand = $this->request->getPost('brand');
        $type = $this->request->getPost('type');
        $number = $this->request->getPost('number');
        $capacity = $this->request->getPost('capacity');
        $details = $this->request->getPost('details');

        $this->vehicleModel->insert([
            "type"          => $type,
            "brand"          => $brand,
            "number"          => $number,
            "capacity"          => $capacity,
            "details"       => $details,
            "trash"          => 0,
        ]);

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Kendaraan merek <b>' . $brand . '</b> dan nomor <b>' . $number . '</b> berhasil ditambahkan');

        return redirect()->to(base_url('vehicles'));
    }

    public function vehicle_edit()
    {
        $id = $this->request->getPost("id");
        $brand = $this->request->getPost("brand");
        $type = $this->request->getPost("type");
        $number = $this->request->getPost("number");
        $capacity = $this->request->getPost("capacity");
        $details = $this->request->getPost("details");

        $this->vehicleModel->update($id, ([
            "brand"          => $brand,
            "type"          => $type,
            "number"          => $number,
            "capacity"          => $capacity,
            "details"       => $details,
            "trash"          => 0,
        ]));

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Kendaraan merek <b>' . $brand . '</b> dan nomor <b>' . $number . '</b> berhasil diubah');

        return redirect()->to(base_url('vehicles'));
    }


    public function vehicle_delete($id)
    {
        $vehicle = $this->vehicleModel->where("id", $id)->first();
        if ($vehicle) {
            $this->vehicleModel->update($id, ([
                "trash"          => 1,
            ]));
            $this->session->setFlashdata('message_type', 'success');
            $this->session->setFlashdata('message_content', 'Kendaraan merek <b>' . $vehicle->brand . '</b> dan nomor <b>' . $vehicle->number . '</b> berhasil dihapus');

            return redirect()->to(base_url('vehicles'));
        } else {
            $this->session->setFlashdata('message_type', 'warning');
            $this->session->setFlashdata('message_content', 'Data tidak ditemukan');

            return redirect()->to(base_url('vehicles'));
        }
    }
}
