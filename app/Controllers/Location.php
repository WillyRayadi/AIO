<?php

namespace App\Controllers;

class Location extends Admin
{
    private $locationModel;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->db = \Config\Database::connect();
        $this->validation =  \Config\Services::validation();

        $this->locationModel = new \App\Models\Location();
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

    public function locations()
    {
        $locations = $this->locationModel
            ->where("trash", 0)
            ->orderBy("name", "asc")
            ->get()
            ->getResultObject();

        $data = ([
            "locations"       => $locations,
        ]);

        return view('modules/locations', $data);
    }

    public function locations_add()
    {
        $name = $this->request->getPost('name');

        $locations = $this->locationModel
            ->where("name", $name)
            ->where('trash', 0)
            ->first();

        if ($locations != null) {
            $this->session->setFlashdata('message_type', 'warning');
            $this->session->setFlashdata('message_content', 'Area Lokasi <b>' . $locations->name . '</b> sudah terdaftar !');
            return redirect()->to(base_url('locations'));
        } else {
            $this->locationModel->insert([
                "name"          => $name,
                "trash"          => 0,
            ]);

            $this->session->setFlashdata('message_type', 'success');
            $this->session->setFlashdata('message_content', 'Area Lokasi <b>' . $name . '</b> berhasil ditambahkan');

            return redirect()->to(base_url('locations'));
        }
    }

    public function locations_edit()
    {
        $id = $this->request->getPost("id");
        $name = $this->request->getPost("name");

        $locations = $this->locationModel
            ->where("name", $name)
            ->where('trash', 0)
            ->first();

        $data_locations = $this->locationModel
            ->where("id", $id)
            ->where('trash', 0)
            ->first();

        if ($locations != null && $data_location->name != $name) {
            $this->session->setFlashdata('message_type', 'warning');
            $this->session->setFlashdata('message_content', 'Nama lokasi <b>' . $locations->name . '</b> sudah terdaftar !');
            return redirect()->to(base_url('locations'));
        } else {
            $this->locationModel->update($id, ([
                "name"          => $name,
                "trash"          => 0,
            ]));
            $this->session->setFlashdata('message_type', 'success');
            $this->session->setFlashdata('message_content', 'Nama lokasi <b>' . $name . '</b> berhasil diubah');
            return redirect()->to(base_url('locations'));
        }
    }

    public function locations_delete($id)
    {
        $this->locationModel->update($id, ([
            "trash"          => 1,
        ]));

        $locations = $this->locationModel->where("id", $id)->first();

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Nama lokasi <b>' . $locations->name . '</b> berhasil dihapus');

        return redirect()->to(base_url('locations'));
    }
}
