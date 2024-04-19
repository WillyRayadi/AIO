<?php

namespace App\Controllers;

class Code extends Admin
{
    private $codeModel;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->db = \Config\Database::connect();
        $this->validation =  \Config\Services::validation();

        $this->codeModel = new \App\Models\Code();
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

    public function codes()
    {
        $codes = $this->codeModel
            ->where("trash", 0)
            ->orderBy("name", "asc")
            ->get()
            ->getResultObject();

        $data = ([
            "codes"       => $codes,
        ]);

        return view('modules/codes', $data);
    }

    public function codes_add()
    {
        $name = $this->request->getPost('name');

        $codes = $this->codeModel
            ->where("name", $name)
            ->where('trash', 0)
            ->first();

        if ($codes != null) {
            $this->session->setFlashdata('message_type', 'warning');
            $this->session->setFlashdata('message_content', 'Kode <b>' . $codes->name . '</b> sudah terdaftar !');
            return redirect()->to(base_url('codes'));
        } else {
            $this->codeModel->insert([
                "name"          => $name,
                "trash"          => 0,
            ]);

            $this->session->setFlashdata('message_type', 'success');
            $this->session->setFlashdata('message_content', 'Kode <b>' . $name . '</b> berhasil ditambahkan');

            return redirect()->to(base_url('codes'));
        }
    }

    public function codes_edit()
    {
        $id = $this->request->getPost("id");
        $name = $this->request->getPost("name");

        $codes = $this->codeModel
            ->where("name", $name)
            ->where('trash', 0)
            ->first();

        $data_codes = $this->codeModel
            ->where("id", $id)
            ->where('trash', 0)
            ->first();

        if ($codes != null && $data_codes->name != $name) {
            $this->session->setFlashdata('message_type', 'warning');
            $this->session->setFlashdata('message_content', 'Kode <b>' . $codes->name . '</b> sudah terdaftar !');
            return redirect()->to(base_url('codes'));
        } else {
            $this->codeModel->update($id, ([
                "name"          => $name,
                "trash"          => 0,
            ]));
            $this->session->setFlashdata('message_type', 'success');
            $this->session->setFlashdata('message_content', 'Kode <b>' . $name . '</b> berhasil diubah');
            return redirect()->to(base_url('codes'));
        }
    }

    public function codes_delete($id)
    {
        $this->codeModel->update($id, ([
            "trash"          => 1,
        ]));

        $codes = $this->codeModel->where("id", $id)->first();

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Kode <b>' . $codes->name . '</b> berhasil dihapus');

        return redirect()->to(base_url('codes'));
    }
}
