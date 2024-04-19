<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Tags extends BaseController
{

    private $tagsModel;
    protected $session;
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->tagsModel = new \App\Models\Tag();
        if($this->session->login_id == null){            
            $this->session->setFlashdata('msg', 'Maaf, Silahkan login terlebih dahulu!');
            header("location:".base_url('/'));
            exit();
        }else{
            if(config("Login")->loginRole != 1){
                if(config("Login")->loginRole != 7){
                    if(config("Login")->loginRole != 4){
                        if(config("Login")->loginRole != 5){
                            header("location:".base_url('/dashboard'));
                            exit();
                        }
                    }
                }
            }
        }
        helper("form");
    }


    public function tags()
    {
        $data = [
            'tags' => $this->tagsModel->orderBy("name", "asc")->where('tags.active', 0)->findAll(),
        ];
        return view('modules/tags', $data);
    }

    public function tags_add()
    {
        $name = $this->request->getPost("name");

        $this->tagsModel->insert([
            "name"          => $name,
        ]);

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Tag <b>' . $name . '</b> berhasil ditambahkan');

        return redirect()->to(base_url('tags'));
    }


    public function tags_edit()
    {
        $id = $this->request->getPost("id");
        $name = $this->request->getPost("name");

        $this->tagsModel->update($id, ([
            "name"          => $name,
        ]));

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Tag <b>' . $name . '</b> berhasil diubah');

        return redirect()->to(base_url('tags'));
    }

    public function tags_delete($id)
    {
        $tagData = $this->tagsModel->where("id", $id)->first();
        
        // if ($tagData) {
        //     $this->tagsModel->delete($id);

        //     $this->session->setFlashdata('message_type', 'success');
        //     $this->session->setFlashdata('message_content', 'Tag <b>' . $tagData->name . '</b> berhasil dihapus');

        //     return redirect()->to(base_url('tags'));
        // } else {
        //     $this->session->setFlashdata('message_type', 'warning');
        //     $this->session->setFlashdata('message_content', 'Data tidak ditemukan');

        //     return redirect()->to(base_url('tags'));
        // }
        
        $this->tagsModel->where('id', $id)
        ->set([
            'active'    => 1,    
        ])->update();
        
        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data tag '.$tagData->name.' berhasil dihapus');
        
        return redirect()->back();
    }
}
