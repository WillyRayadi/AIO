<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;

class Contacts extends BaseController
{
    use ResponseTrait;

    protected $contactModel;

    public function __construct()
    {
        $this->contactModel = new \App\Models\Contact();
    }

    public function index()
    {
        try {
            $contacts = $this->contactModel->findAll();

            if (!empty($contacts)) {
                $response = [
                    "message" => "Berhasil Mengambil Data",
                    "contacts" => $contacts
                ];
                return $this->respond($response, 200);
            } else {
                return $this->failNotFound("Tidak ada kontak dalam database");
            }
        } catch (\Exception $e) {
            return $this->failServerError("Internal Server Error, Silahkan coba lagi nanti");
        }
    }

    public function show($id = null)
    {
        try {
            $contact = $this->contactModel->find($id);

            if (!empty($contact)) {
                $response = [
                    "message" => "Berhasil mengambil data",
                    "contact" => $contact
                ];

                return $this->respond($response, 200);
            } else {
                return $this->failNotFound("Kontak tidak ditemukan di database");
            }
        } catch (\Exception $e) {
            return $this->failServerError("Internal Server Error, Silahkan coba lagi nanti");
        }
    }

}
