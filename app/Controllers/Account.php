<?php

namespace App\Controllers;

class Account extends Admin
{
    
    private $roleModel;
    private $warehouseModel;
    
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->db = \Config\Database::connect();
        $this->validation =  \Config\Services::validation();
        
        
        $this->roleModel = new \App\Models\Roles();
        $this->adminModel = new \App\Models\Administrator();
        $this->warehouseModel = new \App\Models\Warehouse();

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
    
    public function management_role_account(){
        $roles = $this->roleModel->get()->getResultObject();

        $data = ([
            'roles' => $roles,
            'db'    => $this->db,
        ]);

        return view('modules/roles', $data);
    }

    public function role_fitur_add($id){

        $buat_purchase_checkbox = $this->request->getPost('buat_purchase_checkbox');
        $lihat_purchase_checkbox = $this->request->getPost('lihat_purchase_checkbox');
        $edit_purchase_checkbox = $this->request->getPost('edit_purchase_checkbox');
        $hapus_purchase_checkbox = $this->request->getPost('hapus_purchase_checkbox');

        $buat_sales_checkbox = $this->request->getPost('buat_sales_checkbox');
        $lihat_sales_checkbox = $this->request->getPost('lihat_sales_checkbox');
        $edit_sales_checkbox = $this->request->getPost('edit_sales_checkbox');
        $hapus_sales_checkbox = $this->request->getPost('hapus_sales_checkbox');

        $buat_delivery_checkbox = $this->request->getPost('buat_delivery_checkbox');
        $lihat_delivery_checkbox = $this->request->getPost('lihat_delivery_checkbox');
        $edit_delivery_checkbox = $this->request->getPost('edit_delivery_checkbox');
        $hapus_delivery_checkbox = $this->request->getPost('hapus_delivery_checkbox');

        $buat_transfer_checkbox = $this->request->getPost('buat_transfer_checkbox');
        $lihat_transfer_checkbox = $this->request->getPost('lihat_transfer_checkbox');
        $edit_transfer_checkbox = $this->request->getPost('edit_transfer_checkbox');
        $hapus_transfer_checkbox = $this->request->getPost('hapus_transfer_checkbox');

        $buat_retur_checkbox = $this->request->getPost('buat_retur_checkbox');
        $lihat_retur_checkbox = $this->request->getPost('lihat_retur_checkbox');
        $edit_retur_checkbox = $this->request->getPost('edit_retur_checkbox');
        $hapus_retur_checkbox = $this->request->getPost('hapus_retur_checkbox');

        $buat_manifest_checkbox = $this->request->getPost('buat_manifest_checkbox');
        $lihat_manifest_checkbox = $this->request->getPost('lihat_manifest_checkbox');
        $edit_manifest_checkbox = $this->request->getPost('edit_manifest_checkbox');
        $hapus_manifest_checkbox = $this->request->getPost('hapus_manifest_checkbox');

        $buat_stokopname_checkbox = $this->request->getPost('buat_stokopname_checkbox');
        $lihat_stokopname_checkbox = $this->request->getPost('lihat_stokopname_checkbox');
        $edit_stokopname_checkbox = $this->request->getPost('edit_stokopname_checkbox');
        $hapus_stokopname_checkbox = $this->request->getPost('hapus_stokopname_checkbox');

        $buat_products_checkbox = $this->request->getPost('buat_products_checkbox');
        $lihat_products_checkbox = $this->request->getPost('lihat_products_checkbox');
        $edit_products_checkbox = $this->request->getPost('edit_products_checkbox');
        $hapus_products_checkbox = $this->request->getPost('hapus_products_checkbox');

        $buat_agreement_checkbox = $this->request->getPost('buat_agreement_checkbox');
        $lihat_agreement_checkbox = $this->request->getPost('lihat_agreement_checkbox');
        $edit_agreement_checkbox = $this->request->getPost('edit_agreement_checkbox');
        $hapus_agreement_checkbox = $this->request->getPost('hapus_agreement_checkbox');

        $this->roleModel
        ->where('administrator_role.id', $id)
        ->set([
            
            // purchase order insert
            'purchase_order_buat'   => $buat_purchase_checkbox,
            'purchase_order_lihat'  => $lihat_purchase_checkbox,
            'purchase_order_edit'   => $edit_purchase_checkbox,
            'purchase_order_hapus'  => $hapus_purchase_checkbox,

            // sales order insert
            'sales_order_buat'   => $buat_sales_checkbox,
            'sales_order_lihat'  => $lihat_sales_checkbox,
            'sales_order_edit'   => $edit_sales_checkbox,
            'sales_order_hapus'  => $hapus_sales_checkbox,

            // delivery order insert
            'delivery_order_buat'   => $buat_delivery_checkbox,
            'delivery_order_lihat'  => $lihat_delivery_checkbox,
            'delivery_order_edit'   => $edit_delivery_checkbox,
            'delivery_order_hapus'  => $hapus_delivery_checkbox,

            // transfer warehouse insert
            'transfer_warehouse_buat'   => $buat_transfer_checkbox,
            'transfer_warehouse_lihat'  => $lihat_transfer_checkbox,
            'transfer_warehouse_edit'   => $edit_transfer_checkbox,
            'transfer_warehouse_hapus'  => $hapus_transfer_checkbox,

            // Retur Produk insert
            'retur_product_buat'   => $buat_retur_checkbox,
            'retur_product_lihat'  => $lihat_retur_checkbox,
            'retur_product_edit'   => $edit_retur_checkbox,
            'retur_product_hapus'  => $hapus_retur_checkbox,

            // Manifest insert
            'manifest_so_buat'   => $buat_manifest_checkbox,
            'manifest_so_lihat'  => $lihat_manifest_checkbox,
            'manifest_so_edit'   => $edit_manifest_checkbox,
            'manifest_so_hapus'  => $hapus_manifest_checkbox,

            // Stokopname insert
            'stokopname_buat'   => $buat_stokopname_checkbox,
            'stokopname_lihat'  => $lihat_stokopname_checkbox,
            'stokopname_edit'   => $edit_stokopname_checkbox,
            'stokopname_hapus'  => $hapus_stokopname_checkbox,

            // Products insert
            'products_buat'   => $buat_products_checkbox,   
            'products_lihat'  => $lihat_products_checkbox,
            'products_edit'   => $edit_products_checkbox,
            'products_hapus'  => $hapus_products_checkbox,

            // Agreement insert
            'agreement_buat'   => $buat_agreement_checkbox,
            'agreement_lihat'  => $lihat_agreement_checkbox,
            'agreement_edit'   => $edit_agreement_checkbox,
            'agreement_hapus'  => $hapus_agreement_checkbox,


        ])->update(); 

        return redirect()->back();
    }

    public function role_account_manage($id){

        $roles = $this->roleModel
        ->select([
            'administrator_role.id',
            'administrator_role.role_name',
            'administrator_role.purchase_order_buat',
            'administrator_role.purchase_order_lihat',
            'administrator_role.purchase_order_edit',
            'administrator_role.purchase_order_hapus',
            'administrator_role.sales_order_buat',
            'administrator_role.sales_order_lihat',
            'administrator_role.sales_order_edit',
            'administrator_role.sales_order_hapus',
            'administrator_role.delivery_order_buat',
            'administrator_role.delivery_order_lihat',
            'administrator_role.delivery_order_edit',
            'administrator_role.delivery_order_hapus',
            'administrator_role.transfer_warehouse_buat',
            'administrator_role.transfer_warehouse_lihat',
            'administrator_role.transfer_warehouse_edit',
            'administrator_role.transfer_warehouse_hapus',
            'administrator_role.retur_product_buat',
            'administrator_role.retur_product_lihat',
            'administrator_role.retur_product_edit',
            'administrator_role.retur_product_hapus',
            'administrator_role.manifest_so_buat',
            'administrator_role.manifest_so_lihat',
            'administrator_role.manifest_so_edit',
            'administrator_role.manifest_so_hapus',
            'administrator_role.stokopname_buat',
            'administrator_role.stokopname_lihat',
            'administrator_role.stokopname_edit',
            'administrator_role.stokopname_hapus',
            'administrator_role.products_buat',
            'administrator_role.products_lihat',
            'administrator_role.products_edit',
            'administrator_role.products_hapus',
            'administrator_role.agreement_buat',
            'administrator_role.agreement_lihat',
            'administrator_role.agreement_edit',
            'administrator_role.agreement_hapus'
        ])
        ->where('administrator_role.id', $id)
        ->orderBy('administrator_role.role_name','asc')
        ->get()->getFirstRow();

        $data = ([
            'roles' => $roles,
            'db'    => $this->db,
        ]);

        return view('modules/roles_account_manage', $data);
    }

    public function account()
    {
        $accounts = $this->adminModel
          	->where('active',1)
            ->orderBy("name", "asc")
            ->get()
            ->getResultObject();


        $data = ([
            "accounts"       => $accounts,
        ]);

        return view('modules/account', $data);
    }

    public function view_add_account()
    {
        $data = [
            'validation' => \Config\Services::validation(),
        ];

        return view('modules/account_add', $data);
    }

    public function account_add()
    {
        if (!$this->validate([
            'email'          => [
                'rules' => 'required|is_unique[administrators.email]',
                'errors' => [
                    'required' => 'Masukkan email terlebih dahulu',
                    'is_unique' => 'e-mail sudah terdaftar !',
                ],
            ],
            'password'      => [
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required' => 'Masukkan password terlebih dahulu',
                    'min_length' => 'password terlalu pendek',
                ],
            ],
            'confirm_password'      => [
                'confpassword'  => 'matches[password]',
                'errors' => [
                    'matches' => 'konfirmasi password yang anda masukan salah'
                ],
            ]
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->to('account/view_add_account')->withInput()->with('validation', $validation);
        }

        $name = $this->request->getPost("name");
        $cabang = $this->request->getPost("cabang");
        $address = $this->request->getPost("address");
        $phone = $this->request->getPost("phone");
        $email = $this->request->getPost("email");
        $username = $this->request->getPost("username");
        $password = $this->request->getPost("password");
        $role = $this->request->getPost("role");

        $dataInsert = ([
            "name"                      => $name,
      		"cabang"                    => $cabang,
            "address"                   => $address,
            "phone"                     => $phone,
            "email"                     => $email,
            "username"                  => $username,
            "password"                  => password_hash($password, PASSWORD_BCRYPT),
            "role"                      => $role,
            "active"                    => 1,
        ]);

        $this->adminModel->insert($dataInsert);

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Akun : <b>' . $name . '</b> berhasil ditambahkan');

        return redirect()->to(base_url('account'));
    }

    public function view_edit_account($id)
    {
        $warehouses = $this->warehouseModel->where('trash',0)->findAll();
        $admins = $this->adminModel->where('administrators.id',$id)->get()->getFirstRow();
        
        $data = [
            'admins'     => $admins,
            'warehouses' => $warehouses,
            'validation' => \Config\Services::validation(),
            'dataAccount' => $this->adminModel->where("id", $id)->first(),
        ];

        return view('modules/account_edit', $data);
    }

    public function account_edit()
    {
        $id = $this->request->getPost("id");
        $name = $this->request->getPost("name");
      	$cabang = $this->request->getPost("cabang");
        $address = $this->request->getPost("address");
        $phone = $this->request->getPost("phone");
        $email = $this->request->getPost("email");
        $username = $this->request->getPost("username");
        $role = $this->request->getPost("role");
        $status = $this->request->getPost("status");

        $thiswarehouses = NULL;

        if ($this->request->getPost('warehouses')) {
        $warehouses = $this->request->getPost('warehouses');
        $thiswarehouses = "";
        $lastIndex = count($warehouses) - 1;
    
        foreach ($warehouses as $index => $warehouse) {
            $thiswarehouses .= '"' . $warehouse . '"';
        
            if ($index !== $lastIndex) {
                $thiswarehouses .= ",";
            }
        }
        
        } else {

        }


        $this->adminModel->update($id, ([
            "name"                      => $name,
          	"cabang"                    => $cabang,
            "address"                   => $address,
            "phone"                     => $phone,
            "email"                     => $email,
            "username"                  => $username,
            "role"                      => $role,
            "active"                    => $status,
            "allow_warehouses"          => $thiswarehouses,
        ]));

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Akun : <b>' . $name . '</b> berhasil diubah');

        return redirect()->to(base_url('account/view_edit_account/' . $id));
    }

    public function account_reset_password()
    {
        $id = $this->request->getPost('id');
        $name = $this->request->getPost('name');
        $password = $this->request->getPost('password');

        if (!$this->validate([
            'password'      => [
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required' => 'Masukkan password terlebih dahulu',
                    'min_length' => 'password terlalu pendek',
                ],
            ],
            'confirm_password'      => [
                'confpassword'  => 'matches[password]',
                'errors' => [
                    'matches' => 'konfirmasi password yang anda masukan salah'
                ],
            ]
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->to('account/view_edit_account/' . $id . '/?active=password')->withInput()->with('validation', $validation);
        }

        $this->adminModel->update($id, ([
            "password"  => password_hash($password, PASSWORD_BCRYPT),
        ]));

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Akun : <b>' . $name . '</b> berhasil reset password');

        return redirect()->to(base_url('account/view_edit_account/' . $id));
    }
}
