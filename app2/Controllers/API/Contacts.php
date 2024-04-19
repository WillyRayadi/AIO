<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Contacts extends BaseController
{
    use ResponseTrait;

    private $contactModel;
    private $userAddressModel;

    public function __construct(){
        $this->contactModel = model("App\Models\Contact");
        $this->userAddressModel = model('App\Models\UserAddress');
    }

    public function insertContacts()
    {
        $name = $this->request->getVar('name');
        $phone = $this->request->getVar("phone");
        $email = $this->request->getVar("email");
        $address = $this->request->getVar("address");
        
        $refCode = $this->request->getVar('referral_code');
        
        $contacts = $this->contactModel->where('phone', $phone)->first();
        
        if(!empty($contacts)) {
            
            // Update The Data
            $this->userAddressModel->insert(["contact_id" => $contacts->id, "address" => $contacts->address]);
            $this->contactModel->where('id', $contacts->id)->set(["is_member" => 1, "no_reference" => $refCode ?? "-"])->update();
        }else {
            
            $data = [
                "type" => "2",
                "name" => $name,
                "phone" => $phone,
                "email" => $email,
                "address" => "-",
                "no_reference" => $refCode ?? "-",
                "is_member" => "1",
                "member_level" => 1,
                "trash" => "0"
            ];
            
            $users = $this->contactModel->insert($data);
            
            if($users){
                
                $lastID = $this->contactModel->getInsertID();
                
                $arrayData = [
                    "contacts_id" => $lastID,
                    "address" => $address
                ];
                
                $this->userAddressModel->insert($arrayData);
            }
            
            $response = [
                "message" => "success"  
            ];
            
            return $this->respond($response, 200);
        }
        
    }

}
