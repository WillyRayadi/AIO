<?php

namespace App\Controllers;

class Branch extends Admin
{
    private $branchModel;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->db = \Config\Database::connect();
        $this->validation =  \Config\Services::validation();

        $this->branchModel = new \App\Models\Branch();
        helper("form");

        if($this->session->login_id == null){            
            $this->session->setFlashdata('msg', 'Maaf, Silahkan login terlebih dahulu!');
            header("branch:".base_url('/'));
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

    public function branch()
    {
        $branch = $this->branchModel
            ->where("trash", 0)
            ->orderBy("name_city", "asc")
            ->get()
            ->getResultObject();

        $data = ([
            "branch"       => $branch,
        ]);

        return view('modules/kota', $data);
    }

    public function branch_add()
    {
        $name = $this->request->getPost('name');

        $branch = $this->branchModel
            ->where("name_city", $name)
            ->where('trash', 0)
            ->first();

        if ($branch != null) {
            $this->session->setFlashdata('message_type', 'warning');
            $this->session->setFlashdata('message_content', 'Area Kota <b>' . $branch->name . '</b> sudah terdaftar !');
            return redirect()->to(base_url('branch'));
        } else {
            $this->branchModel->insert([
                "name_city"          => $name,
                "trash"          => 0,
            ]);

            $this->session->setFlashdata('message_type', 'success');
            $this->session->setFlashdata('message_content', 'Area Kota <b>' . $name . '</b> berhasil ditambahkan');

            return redirect()->to(base_url('branch'));
        }
    }

    public function branch_edit()
    {
        $id = $this->request->getPost("id");
        $name = $this->request->getPost("name");

        $branch = $this->branchModel
            ->where("name_city", $name)
            ->where('trash', 0)
            ->first();

        $data_branch = $this->branchModel
            ->where("id", $id)
            ->where('trash', 0)
            ->first();

        // if ($branch != null && $data_branch->name != $name) {
        //     $this->session->setFlashdata('message_type', 'warning');
        //     $this->session->setFlashdata('message_content', 'Nama kota <b>' . $branch->name . '</b> sudah terdaftar !');
        //     return redirect()->to(base_url('branch'));
        // } else {
        //     $this->branchModel->update($id, ([
        //         "name_city"          => $name,
        //         "trash"          => 0,
        //     ]));
        //     $this->session->setFlashdata('message_type', 'success');
        //     $this->session->setFlashdata('message_content', 'Nama kota <b>' . $name . '</b> berhasil diubah');
        // }
                $this->branchModel->update($id, ([
                    "name_city"          => $name,
                    "trash"          => 0,
                ]));
                return redirect()->to(base_url('branch'));
    }

    public function branch_delete($id)
    {
        $this->branchModel->update($id, ([
            "trash"          => 1,
        ]));

        $branch = $this->branchModel->where("id", $id)->first();

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Nama kota <b>' . $branch->name_city . '</b> berhasil dihapus');

        return redirect()->to(base_url('branch'));
    }
}
