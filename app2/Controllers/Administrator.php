<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;

class Administrator extends BaseController
{
    use ResponseTrait;

    protected $AdminModel;

    public function __construct()
    {
        $this->AdminModel = new \App\Models\Administrator();
    }

    public function index()
    {
        try {
            $Users = $this->AdminModel->orderBy("administrators.name", "asc")->where('active',1)->findAll();

            if (!empty($Users)) {
                $response = [
                    "message" => "Success Fetching Data",
                    "users" => $Users
                ];

                return $this->respond($response, 200);
            } else {
                return $this->failNotFound("There's No Data In The Table");
            }
        } catch (\Exception $e) {
            return $this->failServerError("Internal Server Error, Please Try Again Later....");
        }
    }

    function show($id = NULL)
    {
        try {
            $Users = $this->AdminModel->orderBy('administrators.name','asc')->where('id', $id)->first();

            if (!empty($Users)) {
                $response = [
                    "message" => "Success Fetching Data",
                    "users" => $Users
                ];

                return $this->respond($response, 200);
            } else {
                return $this->failNotFound("There's No Data With ID $id");
            }
        } catch (\Exception $e) {
            return $this->failServerError("Internal Server Error, Please Try Again Later....");
        }
    }

    function create()
    {
        $validationRules = [
            'name' => 'required',
            'email' => 'required|valid_email',
            'username' => 'required',
            'password' => 'required|min_length[8]',
            'phone' => 'required',
            'address' => 'required',
        ];

        $validationMessages = [
            'password.min_length' => 'The password must be at least 8 characters long.',
        ];

        if (!$this->validate($validationRules, $validationMessages)) {
            $response = [
                'message' => 'Validation Error',
                'errors' => $this->validator->getErrors(),
            ];
            return $this->respond($response, 400);
        }

        $StoreData = [
            "name" => $this->request->getVar('name'),
            "email" => $this->request->getVar('email'),
            "username" => $this->request->getVar('username'),
            "password" => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
            "phone" => $this->request->getVar('phone'),
            "address" => $this->request->getVar('address'),
            "cabang" => "Cirebon - Kalijaga",
            "role" => 8,
            "active" => 1,
        ];

        if ($this->AdminModel->insert($StoreData)) {
            $response = [
                'message' => 'Success Inserting Data',
                'user' => $StoreData,
            ];
            return $this->respond($response, 201);
        } else {
            $response = [
                'message' => 'Failed to save data',
            ];
            return $this->respond($response, 500);
        }
    }

    function update($id = NULL)
    {
        $dataExist = $this->AdminModel->find($id);

        try {

            if (!$dataExist) {
                return $this->failNotFound("There's No Data With ID $id");
            }

            $validationRules = [
                'name' => 'required',
                'email' => 'required|valid_email',
                'username' => 'required',
                'password' => 'required|min_length[8]',
                'phone' => 'required',
                'address' => 'required',
            ];

            $validationMessages = [
                'password.min_length' => 'The password must be at least 8 characters long.',
            ];

            if (!$this->validate($validationRules, $validationMessages)) {
                $response = [
                    'message' => 'Validation Error',
                    'errors' => $this->validator->getErrors(),
                ];
                return $this->respond($response, 400);
            }

            $data = $this->request->getRawInput();

            if (isset($data)) {
                $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
            }

            $dataSave = $this->AdminModel->update($id, $data);

            if (!$dataSave) {
                return $this->failNotFound("an Error occured while trying to update data");
            } else {
                $response = [
                    'message' => "Success Updating Data",
                ];

                return $this->respond($response, 200);
            }
        } catch (\Exception $e) {
            return $this->failServerError("Internal Server Error");
        }
    }

    function delete($id = NULL)
    {
        try {
            $dataExist = $this->AdminModel->find($id);

            if (!$dataExist) {
                return $this->failNotFound("There's No Data With ID $id");
            }

            $this->AdminModel->delete($id);
            $response = [
                'message' => "Success Deleting Data",
                'status' => 200
            ];

            return $this->respondDeleted($response);
        } catch (\Exception $e) {
            return $this->failServerError("an Error occured while trying to delete data");
        }
    }
}
