<?php

namespace App\Controllers;

class Cashier extends BaseController
{
    protected $db;
    protected $session;
    protected $validation;
    protected $adminModel;

    private $productModel;
    private $contactModel;

    private $userPointModel;
    private $userRedeemModel;
    private $redeemItemModel;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->db = \Config\Database::connect();
        $this->validation =  \Config\Services::validation();

        $this->productModel = new \App\Models\Product();
        $this->contactModel = new \App\Models\Contact();

        $this->userPointModel = new \App\Models\UserPoint();
        $this->userRedeemModel = new \App\Models\userRedeem();
        $this->redeemItemModel = new \App\Models\RedeemItem();

        if ($this->session->login_id == null) {
            $this->session->setFlashdata('msg', 'Maaf, Silahkan login terlebih dahulu!');
            header("location:" . base_url('/'));
            exit();
        } else {
            if (config("Login")->loginRole != 9) {
                header("location:" . base_url('/dashboard'));
                exit();
            }
        }
    }

    public function user_point()
    {
        $user = $this->userPointModel
            ->select([
                'user_point.id',
                'user_point.contact_id',
                'sum(point_in) as points',
                'user_point.date as point_date',
                'contacts.name as contact_name',
            ])
            ->join('contacts', 'user_point.contact_id = contacts.id', 'left')
            ->where('contacts.is_member !=', NULL)
            ->groupBy('contacts.id')->get()->getResultObject();

        $data = ([
            'user'  => $user,
            'db'    => $this->db,
        ]);

        return view('modules/user_point', $data);
    }

    public function products()
    {
        $items = $this->db->table('products');
        $items->select([
            'products.sku_number',
            'products.name as product_name',
            'products.unit as product_unit',
        ]);
        $items->where('products.trash', 0);
        $items->orderBy('products.name', 'asc');
        $items = $items->get();
        $items = $items->getFirstRow();

        $data = ([
            'db' => $this->db,
            'items' => $items,
        ]);

        return view('cashier/products', $data);
    }

    public function user_redeems()
    {
        $user = $this->userPointModel
            ->select([
                'user_point.contact_id',
                'sum(point_in) as points',
                'user_point.id',
                'user_point.point_in',
                'contacts.name as contact_name',
                'user_point.date as point_date',
            ])
            ->join('contacts', 'user_point.contact_id = contacts.id', 'left')
            ->where('contacts.is_member !=', NULL)
            ->groupBy('contacts.id')->get()->getResultObject();

        $value = $this->db->table('user_redeem');
        $value->select([
            'user_redeem.id',
            'user_redeem.dates',
            'user_redeem.number',
            'contacts.name as contact_name',
            'administrators.name as admin_name',
        ]);
        $value->join('contacts', 'user_redeem.contact_id = contacts.id', 'left');
        $value->join('administrators', 'user_redeem.admin_id = administrators.id', 'left');
        $value->orderBy('user_redeem.dates', 'desc');
        $value = $value->get();
        $value = $value->getResultObject();

        $data = ([
            'user'  => $user,
            'db'    => $this->db,
            'value' => $value,
        ]);

        return view('cashier/redeem_points', $data);
    }

    public function redeem_item_manage($id)
    {

        $datas = $this->db->table('user_redeem');
        $datas->select([
            'user_redeem.id',
            'contacts.address',
            'user_redeem.dates',
            'user_redeem.number',
            'user_redeem.contact_id',
            'user_redeem.user_point_id',
            'contacts.name as contact_name',
            'administrators.name as admin_name',
        ]);
        $datas->join('contacts', 'user_redeem.contact_id = contacts.id', 'left');
        $datas->join('administrators', 'user_redeem.admin_id = administrators.id', 'left');
        $datas->orderBy('user_redeem.id', 'desc');
        $datas->where('user_redeem.id', $id);
        $datas = $datas->get();
        $datas = $datas->getFirstRow();

        echo $datas->number;
    }

    public function add_member_redeem()
    {
        $user_redeem = $this->db->table('user_redeem');
        $user_redeem->selectMax('id');
        $user_redeem = $user_redeem->get();
        $user_redeem = $user_redeem->getFirstRow();
        $user_redeem = $user_redeem->id;

        $id = $user_redeem + 1;

        $number_redeem = "RDM" . date("dmy") . $id;
        $dates = $this->request->getPost('dates');

        $customers = $this->request->getPost('customers');

        $this->userRedeemModel
            ->insert([
                'dates'     => $dates,
                'number'    => $number_redeem,
                'admin_id'  => $this->session->login_id,
                'contact_id'    => $customers,
            ]);

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Berhasil Menambahkan Data!');

        return redirect()->to(base_url('user/redeem/' . $id));
    }

    public function contacts()
    {
        $contacts = $this->db->table('contacts');
        $contacts->select([
            'contacts.id',
            'contacts.name',
            'contacts.type',
            'contacts.email',
            'contacts.phone',
            'contacts.address',
        ]);
        $contacts->where('contacts.name !=', '');
        $contacts->where('contacts.trash', 0);
        $contacts->orderBy('name', 'asc');
        $contacts = $contacts->get();
        $contacts = $contacts->getResultObject();

        $data = ([
            'db'    => $this->db,
            'contacts'  => $contacts,
        ]);

        return view('cashier/cashier_contacts', $data);
    }
}
