<?php

namespace App\Controllers;

class PaymentTerms extends Admin
{
    private $buysModel;
    private $buyItemsModel;
    private $paymentTermsModel;
    private $supplierModel;
    private $stocksModel;
    private $categoriesModel;
    protected $session;
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->buysModel = new \App\Models\Buy();
        $this->buyItemsModel = new \App\Models\BuyItem();
        $this->paymentTermsModel = new \App\Models\PaymentTerm();
        $this->categoriesModel = new \App\Models\Category();
        $this->suppliers = new \App\Models\Supplier();
        $this->stocksModel = new \App\Models\Stock();
        $this->supplierModel = new \App\Models\Supplier();
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
        helper("form");
    }


    public function buy_terms_manage()
    {
        $buyTerms = $this->paymentTermsModel->where(['trash' => 0])->findAll();

        $data = [
            'buy_terms' => $buyTerms,
        ];
        // dd($data);
        return view('modules/payment_terms', $data);
    }

    public function buy_terms_add()
    {
        $name = $this->request->getPost('name');
        $notes = $this->request->getPost('detail');
        $due_date = $this->request->getPost('due_date');
        $data = [
            'name' => $name,
            'due_date' => $due_date,
            'details' => $notes,
        ];
        $this->paymentTermsModel->insert($data);
        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data <b>' . $name . '</b> berhasil di tambah');
        return redirect()->to(base_url('/payment/terms'));
    }

    public function buy_terms_update()
    {
        $idBuyTerms = $this->request->getPost('idBuyTerms');

        $dataBuyTerms = $this->paymentTermsModel->find($idBuyTerms);

        if ($dataBuyTerms) {
            $name = $this->request->getPost('name');
            $due_date = $this->request->getPost('due_date');
            $notes = $this->request->getPost('notes');
            $data = [
                'name' => $name,
                'due_date' => $due_date,
                'notes' => $notes,
            ];
            $this->paymentTermsModel->update($idBuyTerms, $data);
            $this->session->setFlashdata('message_type', 'success');
            $this->session->setFlashdata('message_content', 'Data  <b>' . $name . '</b> berhasil di update');
            return redirect()->to(base_url('/payment/terms'));
        } else {
            $this->session->setFlashdata('message_type', 'Warning');
            $this->session->setFlashdata('message_content', 'Data Tidak ditemukan');
            return redirect()->to(base_url('/payment/terms'));
        }
    }
    public function buy_terms_delete($buyTermsId)
    {
        $buyTermsData = $this->paymentTermsModel->find($buyTermsId);
        if ($buyTermsData) {
            $data = [
                'trash' => 1,
            ];
            $this->paymentTermsModel->update($buyTermsId, $data);
            $this->session->setFlashdata('message_type', 'success');
            $this->session->setFlashdata('message_content', 'Data  <b>' . $buyTermsData->name . '</b> berhasil di Hapus');
            return redirect()->to(base_url('/payment/terms'));
        } else {
            $this->session->setFlashdata('message_type', 'warning');
            $this->session->setFlashdata('message_content', 'Data Tidak ditemukan');
            return redirect()->to(base_url('/payment/terms'));
        }
    }
}
