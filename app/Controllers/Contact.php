<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class Contact extends BaseController
{
    private $contactModel;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->db = \Config\Database::connect();
        $this->validation =  \Config\Services::validation();

        $this->contactModel = new \App\Models\Contact();
        helper("form");

        if($this->session->login_id == null){            
            $this->session->setFlashdata('msg', 'Maaf, Silahkan login terlebih dahulu!');
            header("location:".base_url('/'));
            exit();
        }else{
            if(config("Login")->loginRole > 3){
                if(config("Login")->loginRole != 7){
                    header("location:".base_url('/dashboard'));
                    exit();
                }
            }
        }
    }
    
    public function export_contacts_customer(){
        $contacts = $this->db->table('contacts as a');
        $contacts->select([
            'a.type as contact_type',
            'a.name as contact_name',
            'a.email as contact_email',
            'a.phone as contact_phone',
            'a.address as contact_address',
        ]);
        $contacts->where('a.trash', 0);
        $contacts->where('a.name !=', "");
        $contacts->where('a.type', 2);
        $contacts = $contacts->orderBy('a.name', 'asc')->get();
        $result = $contacts->getResultObject();

        $spreadsheet = new Spreadsheet(); 
        
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'DATA CONTACT CUSTOMER AIO');
        $sheet->mergeCells('A1:E1'); 
    
        $spreadsheet->getActiveSheet()
        ->getStyle('A1:E1')
        ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A4','Name Contact');
        $sheet->setCellValue('B4','Contact Phone');
        $sheet->setCellValue('C4','Contact Type');
        $sheet->setCellValue('D4','Contact Email');
        $sheet->setCellValue('E4','Contacts Address');
        
        $column = 5;
        foreach($result as $contact){
            $sheet->setCellValue('A'.$column, $contact->contact_name);
            $sheet->setCellValue('B'.$column, $contact->contact_phone);
            $sheet->setCellValue('C'.$column, 'Customer');
            $sheet->setCellValue('D'.$column, $contact->contact_email);
            $sheet->setCellValue('E'.$column, $contact->contact_address);
 
            $column++;
        }
        
        $sheet->getStyle('A4:E4')->getFont()->setBold(true);
        $sheet->getColumnDimension('A')->setWidth('42');
        $sheet->getColumnDimension('B')->setWidth('15');
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename=Data Customer AIO.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }
    
    public function export_contacts_supplier(){
        
        $contacts = $this->db->table('contacts as a');
        $contacts->select([
            'a.type as contact_type',
            'a.name as contact_name',
            'a.email as contact_email',
            'a.phone as contact_phone',
            'a.address as contact_address',
        ]);
        $contacts->where('a.trash', 0);
        $contacts->where('a.name !=',"");
        $contacts->where('a.type', 1);
        $contacts = $contacts->orderBy('a.name', 'asc')->get();
        $result = $contacts->getResultObject();

        $spreadsheet = new Spreadsheet(); 
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1','Data Supplier AIO');
        $sheet->mergeCells('A1:E1'); 
    
        $spreadsheet->getActiveSheet()
        ->getStyle('A1:E1')
        ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A4','Name Contact');
        $sheet->setCellValue('B4','Contact Phone');
        $sheet->setCellValue('C4','Contact Type');
        $sheet->setCellValue('D4','Contact Email');
        $sheet->setCellValue('E4','Contacts Address');
        
        $column = 5;
        foreach($result as $contact){
            $sheet->setCellValue('A'.$column, $contact->contact_name);
            $sheet->setCellValue('B'.$column, $contact->contact_phone);
            $sheet->setCellValue('C'.$column, 'Supplier');
            $sheet->setCellValue('D'.$column, $contact->contact_email);
            $sheet->setCellValue('E'.$column, $contact->contact_address);
 
            $column++;
        }
        
        $sheet->getStyle('A4:E4')->getFont()->setBold(true);
        $sheet->getColumnDimension('A')->setWidth('42');
        $sheet->getColumnDimension('B')->setWidth('15');
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename=Data Supplier AIO.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }

    public function contact(){
        $contacts = $this->contactModel
        ->where('contacts.name !=', "")
        ->where("trash", 0)
        ->orderBy("name", "asc")
        ->get()
        ->getResultObject();

        $data = ([
            "contacts"       => $contacts,
        ]);

        return view('modules/contacts', $data);
    }
    
    private function isContactExists($name)
    {
        $existingContact = $this->contactModel
        ->where('name', $name)
        ->first();

        return $existingContact !== null;
    }
    
    private function isContactName($name) {
        $existingContact = $this->contactModel
        ->where('name', $name)
        ->first();

        return $existingContact !== null;
    }

    private function isContactPhone($phone) {
        $existingContact = $this->contactModel
        ->where('phone', $phone)
        ->first();

        return $existingContact !== null;
    }

    public function contact_add()
    {
        $name = $this->request->getPost('name');
        $type = $this->request->getPost('type');
        $phone = $this->request->getPost('phone');
        // $email = $this->request->getPost('email');
        $address = $this->request->getPost('address');
        // $reference = $this->request->getPost('reference');
        
        if ($this->isContactName($name)) {
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', 'Kontak dengan nama '.$name.' sudah ada!');
            return redirect()->to(base_url('contacts'));

        }elseif ($this->isContactPhone($phone)){
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', 'Kontak dengan nomer telp '.$phone.' sudah ada!');
            return redirect()->to(base_url('contacts'));
        }
        
        $this->contactModel->insert([
            "type"          => $type,
            "name"          => strtoupper($name),
            "phone"          => $phone,
            "email"          => "-",
            "address"       => $address,
            "no_reference"       => "-",
            "trash"          => 0,
        ]);
        
        $id = $this->contactModel->getInsertID();
        $contacts = $this->contactModel->where('id', $id)->first();
        
        $token = $this->getLatestToken();
        
        if($type == 2) {
            $response = $this->client->request('POST', 'https://api.product.prieds.com/priedsoa/open-api/v1/public/customer/save', [
                 'headers' => [
                    'x-prieds-token' => $token,
                    'x-prieds-username' => 'AIO_INTEGRATION'
                 ],
                 'json' => [
                     'request' => [
                          'salesman_code' => "PELANGGAN",
                          'customer_id' => $contacts->id,
                          'customer_name' => strtoupper($contacts->name),
                          'kuota' => 0,
                          'born_day' => '',
                          'pic' => '-',
                          'contact_no' => $contacts->phone,
                          'customer_email' => '',
                          'address' => $contacts->address,
                          'region' => '',
                          'city' => '',
                          'province' => '',
                          'postal_code' => ''
                      ]
                 ]
            ]);
        }else {
            $response = $this->client->request('POST', 'https://api.product.prieds.com/priedsoa/open-api/v1/public/supplier/save', [
                 'headers' => [
                    'x-prieds-token' => $token,
                    'x-prieds-username' => 'AIO_INTEGRATION'
                 ],
                 'json' => [
                     'request' => [
                          'supplier_id' => $contacts->id,
                          'supplier_name' => strtoupper($contacts->name),
                          'supplier_email' => '-',
                          'supplier_contact_no' => $contacts->phone,
                          'remark' => '',
                          'fax_no' => '',
                          'address' => $contacts->address,
                          'region' => '',
                          'supplier_pic' => '-',
                      ]
                 ]
            ]);
        }

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Kontak <b>' . $name . '</b> berhasil ditambahkan');

        return redirect()->to(base_url('contacts'));
    }

    public function contact_add_direct_buy_add()
    {
        $name = $this->request->getPost('name');
        $type = $this->request->getPost('type');
        $phone = $this->request->getPost('phone');
        // $email = $this->request->getPost('email');
        $address = $this->request->getPost('address');
        // $reference = $this->request->getPost('reference');
        
        if ($this->isContactExists($name)) {
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', 'Kontak dengan nama <b>' . $name . '</b> sudah ada!');
            return redirect()->to(base_url('products/buys'));
        }elseif ($this->isContactPhone($phone)) {
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', 'Kontak dengan nomer telp <b>' . $phone . '</b> sudah ada!');
            return redirect()->to(base_url('products/buys'));
        }

        $this->contactModel->insert([
            "type"          => $type,
            "name"          => $name,
            "phone"          => $phone,
            "email"          => "-",
            "address"       => $address,
            "no_reference"       => "-",
            "trash"          => 0,
        ]);

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Kontak <b>' . $name . '</b> berhasil ditambahkan');

        return redirect()->to(base_url('products/buys'));
    }
    public function contact_add_direct_buy_manage()
    {
        $buy = $this->request->getPost('buy');
        $name = $this->request->getPost('name');
        $type = $this->request->getPost('type');
        $phone = $this->request->getPost('phone');
        // $email = $this->request->getPost('email');
        $address = $this->request->getPost('address');
        // $reference = $this->request->getPost('reference');
        
        if ($this->isContactName($name)) {
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', 'Kontak dengan nama <b>' . $name . '</b> sudah ada!');
            return redirect()->to(base_url('products/buys/manage/'.$buy));
        }elseif ($this->isContactPhone($phone)) {
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', 'Kontak dengan nomer telp <b>' . $phone . '</b> sudah ada!');
            return redirect()->to(base_url('products/buys/manage/'.$buy));
        }

        $this->contactModel->insert([
            "type"          => $type,
            "name"          => $name,
            "phone"          => $phone,
            "email"          => "-",
            "address"       => $address,
            "no_reference"       => "-",
            "trash"          => 0,
        ]);

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Kontak <b>' . $name . '</b> berhasil ditambahkan');

        return redirect()->to(base_url('products/buys/manage/'.$buy));
    }

    public function contact_edit(){
        $id = $this->request->getPost("id");
        $type = $this->request->getPost("type");
        $name = $this->request->getPost("name");
        $phone = $this->request->getPost("phone");
        $email = $this->request->getPost("email");
        $address = $this->request->getPost("address");
        $reference = $this->request->getPost("reference");

        $this->contactModel->update($id, ([
            "type"          => $type,
            "name"          => $name,
            "phone"          => $phone,
            "email"          => $email,
            "address"       => $address,
            "no_reference"       => $reference,
            "trash"          => 0,
        ]));

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Kontak <b>' . $name . '</b> berhasil diubah');

        return redirect()->to(base_url('contacts'));
    }

    public function contact_delete($id)
    {
        $contact = $this->contactModel->where("id", $id)->first();
        if ($contact) {
            
            $token = $this->getLatestToken();
            
            // Cek Tipe Kontak (Pelanggan / Pemasok)
            if($contact->type == 2) {
                
                // Request endpoint pelanggan
                $response = $this->client->request('POST', 'https://api.product.prieds.com/priedsoa/open-api/v1/public/customer/delete', [
                     'headers' => [
                        'x-prieds-token' => $token,
                        'x-prieds-username' => 'AIO_INTEGRATION'
                     ],
                     'json' => [
                        'request' => [
                             'customer_id' => $contact->id
                         ] 
                     ]
                ]);
            }else{
                
                // Request endpoint pemasok
                $response = $this->client->request('POST', 'https://api.product.prieds.com/priedsoa/open-api/v1/public/supplier/delete', [
                     'headers' => [
                        'x-prieds-token' => $token,
                        'x-prieds-username' => 'AIO_INTEGRATION'
                     ],
                     'json' => [
                        'request' => [
                             'supplier_id' => $contact->id
                         ] 
                     ]
                ]);
            }
            
            $this->contactModel->update($id, ([
                "trash"          => 1,
            ]));
            
            $this->session->setFlashdata('message_type', 'success');
            $this->session->setFlashdata('message_content', 'Kontak <b>' . $contact->name . '</b> berhasil dihapus');

            return redirect()->to(base_url('contacts'));
        } else {
            $this->session->setFlashdata('message_type', 'warning');
            $this->session->setFlashdata('message_content', 'Data tidak ditemukan');

            return redirect()->to(base_url('contacts'));
        }
    }
}
