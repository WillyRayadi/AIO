<?php

namespace App\Controllers;

class Supervisor extends BaseController
{
    protected $session;
    protected $validation;
    protected $db;

    protected $adminModel;

    private $productCategoriesModel;
    private $productModel;
    private $productStocksModel;
    private $productRepairModel;
    private $productLocationModel;
    private $productStockModel;
    private $codeModel;
    private $customerModel;
    private $warehouseModel;
    private $promoModel;
    private $contactModel;
    private $saleModel;
    private $saleItemModel;
    private $tagModel;
    private $paymentModel;
    private $vehicleModel;
    private $insentifModel;
    private $teamModel;
    private $locationModel;
    private $productPriceModel;
    private $saleItemBundlingModel;
    private $brandModel;
    private $capacityModel;

    public function __construct()
    {
        $this->session = \Config\Services::session();

        $this->db = \Config\Database::connect();
        $this->validation =  \Config\Services::validation();

        $this->adminModel = new \App\Models\Administrator();
        $this->capacityModel = new \App\Models\Capacity();
        $this->productCategoriesModel = new \App\Models\Category();
        $this->productModel = new \App\Models\Product();
        $this->productPriceModel = new \App\Models\ProductPrice();
        $this->productStocksModel = new \App\Models\Stock();
        $this->productRepairModel = new \App\Models\ProductRepair();
        $this->productLocationModel = new \App\Models\ProductLocation();
        $this->productStockModel = new \App\Models\ProductStock();
        $this->codeModel = new \App\Models\Code();
        $this->customerModel = new \App\Models\Customer();
        $this->warehouseModel = new \App\Models\Warehouse();
        $this->promoModel = new \App\Models\Promo();
        $this->contactModel = new \App\Models\Contact();
        $this->saleModel = new \App\Models\Sale();
        $this->saleItemModel = new \App\Models\SaleItem();
        $this->tagModel = new \App\Models\Tag();
        $this->paymentModel = new \App\Models\PaymentTerm();
        $this->vehicleModel = new \App\Models\Vehicle();
        $this->insentifModel = new \App\Models\Insentif();
        $this->teamModel = new \App\Models\Team();
        $this->locationModel = new \App\Models\Location();
        $this->saleItemBundlingModel = new \App\Models\SaleItemBundling();
        $this->brandModel = new \App\Models\Brands();

        if ($this->session->login_id == null) {
            $this->session->setFlashdata('msg', 'Maaf, Silahkan login terlebih dahulu!');
            header("location:" . base_url('/'));
            exit();
        } else {
            if (config("Login")->loginRole != 4) {
                if (config("Login")->loginRole != 5) {
                    header("location:" . base_url('/dashboard'));
                    exit();
                }
            }
        }
    }
    
    public function custom_insentif(){
        $insentiv = $this->db->table('sales');
        $insentiv->select([
            'sales.id sales_id',
            'sales.number as sale_number',
            'contacts.name as contact_name',
            'administrators.name as admin_name',
            'sales.transaction_date as sale_date',
        ]);
        $insentiv->join('contacts','sales.contact_id = contacts.id','left');
        $insentiv->join('administrators','sales.admin_id = administrators.id','left');
        $insentiv->where('sales.contact_id !=', NULL);
        $insentiv->where('sales.status', 6);
        $insentiv->orderBy('sales.transaction_date', 'desc');
        $insentiv = $insentiv->get();
        $insentiv = $insentiv->getResultObject();

        $data = ([
            'db'    => $this->db,
            'insentiv'  => $insentiv,
        ]);

        return view('modules/custom_insentif', $data);
    }
    
    public function getInsentif()
    {
        $price_id = $this->request->getVar('price_id');
        $price = $this->request->getVar('price');
        $user = $this->request->getVar('user');
        
        
        $role = $this->adminModel->select('role')->where('id', $user)->first();
        $rumus = $this->productPriceModel->where('id', $price_id)->first();

        
        if($role->role == 2 || $role->role == 3) {
            $sales = $this->insentifModel->where("role", $role->role)->where("price_id", $rumus->id)->first();
            
            $levelSales = [
                0,
                $sales->level_1,
                $sales->level_2,
                $sales->level_3,
                $sales->level_4,
                $sales->level_5,
                $sales->level_6,
                $sales->level_7,
                $sales->level_8,
                $sales->level_9,
                $sales->level_10
            ];
            
            $margins = ([
                0, // 0
                $rumus->plus_one, // margin ke-1
                $rumus->plus_two, // margin ke-2
                $rumus->plus_three, // margin ke-3
                $rumus->plus_four, // margin ke-4
                $rumus->plus_five, // margin ke-5
                $rumus->plus_six, // margin ke-6
                $rumus->plus_seven, // margin ke-7
                $rumus->plus_eight, // margin ke-8
                $rumus->plus_nine, // margin ke-9
                $rumus->plus_ten, // margin ke-10
            ]);
            
            $arrayPrices = ([0]);
            $dataInsentif = [];

            $thisPrice = floatval($price);
            array_push($arrayPrices,$thisPrice);

            
            for($p = 2; $p <= 10; $p++){
                $thisPrice += $margins[$p];
                array_push($arrayPrices, $thisPrice);
            }
            
            for($x = 4; $x <= 10; $x++) {
                $insentifLevel = floatval($levelSales[$x]);
                $insentif = ($arrayPrices[$x] * $insentifLevel) / 100;
                
                $salesInsentif = "($x)"." - "."Rp.".number_format($insentif, 0, ",", ".");
                
                $dataInsentif[] = $salesInsentif;
            }
            
            return $this->response->setJSON($dataInsentif);
        }

    }

    public function custom_insentif_manage($id){
        $items = $this->db->table('sale_items');
        $items->select([
            'sale_items.price',
            'sale_items.quantity',
            'sale_items.bonus_sales',
            'sale_items.id as item_id',
            'products.id as product_id',
            'products.name as product_name',
            'products.price_id as product_price',
            'products.price as prices'
        ]);
        $items->join('products', 'sale_items.product_id = products.id','left');
        $items->where('sale_items.sale_id', $id);
        $items->orderBy('sale_items.id','desc');
        $items = $items->get();
        $items = $items->getResultObject();
        
        $dataItem = $this->db->table('sale_items');
        $dataItem->select([
            'sale_items.id as item_id',
        ]);
        $dataItem->where('sale_items.sale_id', $id);
        $dataItem->orderBy('sale_items.id','desc');
        $dataItem = $dataItem->get();
        $dataItem = $dataItem->getFirstRow();

        $sales = $this->db->table('sales');
        $sales->select([
            'sales.transaction_date',
            'sales.number as sale_number',
            'contacts.name as contact_name',
            'administrators.name as admin_name',
            'sales.admin_id as user_id',
            'sales.id as sale_id'
        ]);
        $sales->join('contacts','sales.contact_id = contacts.id','left');
        $sales->join('administrators','sales.admin_id = administrators.id','left');
        $sales->where('sales.id', $id);
        $sales = $sales->get();
        $sales = $sales->getFirstRow();

        $data = ([
            'db' => $this->db,
            'items' => $items,
            'sales' => $sales,
            'dataItem'  => $dataItem,
        ]);

        return view('modules/custom_insentif_manage', $data);
    }

    public function set_custom_insentif(){
        $id_items = $this->request->getPost('item_id');
        $insentif = $this->request->getPost('insentif');
        
        $this->saleItemModel
        ->where('sale_items.id',$id_items)
        ->set([
            'bonus_sales'   => $insentif,
        ])->update();

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Insentif berhasil diubah');

        return redirect()->back();
    }
    
    public function getProducts()
    {
        
        $data = $this->fetchProducts();
        
        $products = $data["products"];
        $warehouses = $data["warehouses"];
        $categoryQuery  = $data["categories"];
        $productStocks = $data["product_stocks"];
        $productSales = $data["product_sales"];
        // $productRepairs = $data["product_repairs"];
        // $productReturns = $data["product_returns"];
        

        $processData = $this->prepareData($products, $warehouses, $productSales,$categoryQuery, $productStocks);
        // $json = json_encode($processData);
        
  
        return $processData;
    }

    public function sales_delete($id)
    {
        $sale = $this->saleModel->where("id", $id)->first();

        if ($sale->status >= 6) {
            $this->session->setFlashdata('message_type', 'warning');
            $this->session->setFlashdata('message_content', 'Penjualan (SO) gagal dihapus');

            return redirect()->to(base_url('supervisor/sales/' . $id . '/manage'));
        }

        $items = $this->saleItemModel
            ->where("sale_id", $id)
            ->findAll();

        foreach ($items as $item) {
            $thisItem = $this->saleItemModel->where("id", $item->id)->first();

            $this->saleItemModel->where("id", $item->id)->delete();
            $this->productStockModel->where("sale_item_id", $item->id)->delete();
        }

        $this->saleModel->delete($id);
        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Penjualan (SO) berhasil dihapus');

        return redirect()->to(base_url('supervisor/sales/'));
    }

    public function sales_item_delete($sale, $item)
    {
        $thisSale = $this->saleModel->where("id", $sale)->first();

        if ($thisSale->status >= 6) {
            $this->session->setFlashdata('message_type', 'warning');
            $this->session->setFlashdata('message_content', 'Item Penjualan (SO) gagal dihapus');

            return redirect()->to(base_url('supervisor/sales/' . $sale . '/manage'));
        }

        $thisItem = $this->saleItemModel->where("id", $item)->first();

        $this->saleItemModel->where("id", $item)->delete();
        $this->productStockModel->where("sale_item_id", $item)->delete();

        $items = $this->saleItemModel->where("sale_id", $sale)->findAll();

        $saleReady = 1;
        foreach ($items as $item) {
            $saleReady = $saleReady * $item->ready;
        }

        if ($saleReady == 1) {
            $this->saleModel->where("id", $sale)
                ->set(["status" => 2])->update();
        } else {
            $this->saleModel->where("id", $sale)
                ->set(["status" => 1])->update();
        }

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Barang berhasil dihapus dari daftar penjualan');

        if (config("Login")->loginRole == 7) {
            return redirect()->to(base_url('    /sales/' . $sale . '/manage'));
        } else {
            return redirect()->to(base_url('supervisor/penjualan/' . $sale . '/manage'));
        }
    }

    public function sales()
    {
        $team = $this->teamModel->select(["team_member_id"])->where("leader_id", $this->session->login_id)->findAll();
        
        if($team){
            $sales = $this->saleModel
                ->select([
                    'sales.id as sale_id',
                    'sales.number as sale_number',
                    'sales.admin_id as sale_admin_id',
                    'sales.contact_id as sale_contact_id',
                    'sales.payment_id as sale_payment_id',
                    'sales.warehouse_id as sale_warehouse_id',
                    'sales.transaction_date as sale_transaction_date',
                    'sales.expired_date as sale_expired_date',
                    "sales.tags as sale_tags",
                    'sales.status as sale_status',
                ])
                ->join("administrators", "sales.admin_id=administrators.id", "left")
                ->whereIn("sales.admin_id", array_column($team, "team_member_id"))
                ->where("sales.contact_id !=", NULL)
                ->where("sales.payment_id !=", NULL)
                ->orderBy("sales.transaction_date", "desc")
                ->orderBy("sales.id", "desc")->findAll();
        }else{
            $sales = [];
        }
        
        // if (config("Login")->loginRole == 4) {
        //     $sales = $this->saleModel
        //         ->select("sales.id as sale_id")
        //         ->select("sales.number as sale_number")
        //         ->select("sales.admin_id as sale_admin_id")
        //         ->select("sales.contact_id as sale_contact_id")
        //         ->select("sales.payment_id as sale_payment_id")
        //         ->select("sales.warehouse_id as sale_warehouse_id")
        //         ->select("sales.transaction_date as sale_transaction_date")
        //         ->select("sales.expired_date as sale_expired_date")
        //         ->select("sales.tags as sale_tags")
        //         ->select("sales.status as sale_status")
        //         ->join("administrators", "sales.admin_id=administrators.id", "left")
        //         ->where("administrators.role", 2)
        //         ->where("sales.contact_id !=", NULL)
        //         ->where("sales.payment_id !=", NULL)
        //         ->orderBy("sales.transaction_date", "desc")
        //         ->orderBy("sales.id", "desc")->findAll();
        // } elseif (config("Login")->loginRole == 5) {
        //     $sales = $this->saleModel
        //         ->select("sales.id as sale_id")
        //         ->select("sales.number as sale_number")
        //         ->select("sales.admin_id as sale_admin_id")
        //         ->select("sales.contact_id as sale_contact_id")
        //         ->select("sales.payment_id as sale_payment_id")
        //         ->select("sales.warehouse_id as sale_warehouse_id")
        //         ->select("sales.transaction_date as sale_transaction_date")
        //         ->select("sales.expired_date as sale_expired_date")
        //         ->select("sales.tags as sale_tags")
        //         ->select("sales.status as sale_status")
        //         ->join("administrators", "sales.admin_id=administrators.id", "left")
        //         ->where("administrators.role", 3)
        //         ->orderBy("sales.transaction_date", "desc")
        //         ->where("sales.contact_id !=", NULL)
        //         ->where("sales.payment_id !=", NULL)
        //         ->orderBy("sales.id", "desc")->findAll();
        // }

        $data = ([
            "sales" => $sales,
            "db"    => $this->db,
        ]);

        return view("supervisor/sales", $data);
    }
    public function sales_manage($id)
    {
        $sale = $this->saleModel
            ->where("id", $id)
            ->first();

        if ($sale == NULL) {
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', 'Data tidak ditemukan');

            return redirect()->to(base_url('dashboard'));
        }

        if ($sale->contact_id == NULL) {
            // $this->session->setFlashdata('message_type', 'error');
            // $this->session->setFlashdata('message_content', 'Data tidak ditemukan');

            // return redirect()->to(base_url('dashboard'));
        }
        if ($sale->payment_id == NULL) {
            // $this->session->setFlashdata('message_type', 'error');
            // $this->session->setFlashdata('message_content', 'Data tidak ditemukan');

            // return redirect()->to(base_url('dashboard'));
        }

        $contact = $this->contactModel
            ->where("id", $sale->contact_id)
            ->first();

        $admin = $this->adminModel
            ->where("id", $sale->admin_id)
            ->first();

        if (config("Login")->loginRole == 4) {
            if ($admin->role != 2) {
                $this->session->setFlashdata('message_type', 'error');
                $this->session->setFlashdata('message_content', 'Data tidak ditemukan');

                return redirect()->to(base_url('dashboard'));
            }
        } elseif (config("Login")->loginRole == 5) {
            if ($admin->role != 3) {
                $this->session->setFlashdata('message_type', 'error');
                $this->session->setFlashdata('message_content', 'Data tidak ditemukan');

                return redirect()->to(base_url('dashboard'));
            }
        }

        $warehouse = $this->warehouseModel
            ->where("id", $sale->warehouse_id)
            ->first();

        $payment = $this->paymentModel
            ->where("id", $sale->payment_id)
            ->first();

        $items = $this->saleItemModel
            ->where("sale_id", $id)
            ->findAll();

        $data = ([
            "db"    => $this->db,
            "contact"  => $contact,
            "admin"  => $admin,
            "warehouse" => $warehouse,
            "payment" => $payment,
            "sale"  => $sale,
            "items" => $items,
        ]);

        return view("supervisor/sales_manage", $data);
    }
    public function sales_need_approval()
    {
        if (config("Login")->loginRole == 4) {
            $items = $this->saleItemModel
                ->select("sales.id as sale_id")
                ->select("sales.number as sale_number")
                ->select("sales.transaction_date as sale_date")
                ->select("products.name as product_name")
                ->select("sale_items.id as sale_item_id")
                ->select("sale_items.price_level as item_price_level")
                ->select("sale_items.price as item_price")
                ->select("administrators.name as admin_name")
                ->select("contacts.name as contact_name")
                ->join("products", "sale_items.product_id=products.id", "left")
                ->join("sales", "sale_items.sale_id=sales.id", "left")
                ->join("administrators", "sales.admin_id=administrators.id", "left")
                ->join("contacts", "sales.contact_id=contacts.id", "left")
                ->where("sale_items.need_approve", 1)
                ->where("sale_items.admin_approve_id", 0)
                ->where("sales.status", 1)
                ->findAll();
        } elseif (config("Login")->loginRole == 5) {
            $items = $this->saleItemModel
                ->select("sales.id as sale_id")
                ->select("sales.number as sale_number")
                ->select("sales.transaction_date as sale_date")
                ->select("products.name as product_name")
                ->select("sale_items.id as sale_item_id")
                ->select("sale_items.price_level as item_price_level")
                ->select("sale_items.price as item_price")
                ->select("administrators.name as admin_name")
                ->select("contacts.name as contact_name")
                ->join("products", "sale_items.product_id=products.id", "left")
                ->join("sales", "sale_items.sale_id=sales.id", "left")
                ->join("administrators", "sales.admin_id=administrators.id", "left")
                ->join("contacts", "sales.contact_id=contacts.id", "left")
                ->where("sale_items.need_approve", 2)
                ->where("sale_items.admin_approve_id", 0)
                ->where("sales.status", 1)
                ->orderBy("sales.transaction_date", "desc")
                ->orderBy("sales.id", "desc")
                ->findAll();
        }

        $data = ([
            "db" => $this->db,
            "items" => $items,
        ]);

        return view("supervisor/sales_need_approval", $data);
    }
    public function sales_item_approve($sale, $item)
    {
        $this->saleItemModel->where("id", $item)
            ->set([
                "approve_status" => 1,
                "admin_approve_id" => $this->session->login_id,
                "ready" => 1
            ])->update();

        $items = $this->saleItemModel->where("sale_id", $sale)->findAll();

        $saleReady = 1;
        foreach ($items as $item) {
            $saleReady = $saleReady * $item->ready;
        }

        if ($saleReady == 1) {
            $this->saleModel->where("id", $sale)
                ->set(["status" => 2])->update();
        }

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Item berhasil disetujui');

        return redirect()->to(base_url('supervisor/sales/' . $sale . '/manage'));
    }
    public function sales_item_unapprove($sale, $item)
    {
        $this->saleItemModel->where("id", $item)
            ->set([
                "approve_status" => 2,
                "admin_approve_id" => $this->session->login_id,
                "ready" => 0
            ])->update();

        $this->saleModel->where("id", $sale)
            ->set(["status" => 3])->update();

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Item berhasil tidak disetujui');

        return redirect()->to(base_url('supervisor/sales/' . $sale . '/manage'));
    }
    public function target()
    {
        $admins = $this->adminModel
            ->where("role >=", 2)
            ->where("role <=", 5)
            ->orderBy("name", "asc")
            ->findAll();

        $data = ([
            "admins" => $admins
        ]);

        return view("supervisor/target", $data);
    }
    public function target_save()
    {
        $id = $this->request->getPost('id');
        $target = $this->request->getPost('target');

        $this->adminModel->where("id", $id)->set([
            "sale_target" => $target
        ])->update();
        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Target penjualan berhasil disimpan');

        return redirect()->to(base_url('supervisor/target'));
    }

    public function sales_add()
    {
        $maxId = $this->db->table("sales");
        $maxId->selectMax("id");
        $maxId = $maxId->get();
        $maxId = $maxId->getFirstRow();
        $maxId = $maxId->id;

        $thisID = $maxId + 1;

        $transaction_number = "SO/" . date("y") . "/" . date("m") . "/" . $thisID;

        // $firstWarehouse = $this->warehouseModel->where("trash",0)->orderBy("name","asc")->first();

        $this->saleModel
            ->insert([
                "id"    => $thisID,
                "number"    => $transaction_number,
                "admin_id"    => $this->session->login_id,
                // "member_id"    => $this->session->login_id,
                "contact_id"    => NULL,
                "location_id"   => NULL,
                // "warehouse_id"=> $firstWarehouse->id,
                "invoice_address" => NULL,
                "sales_notes" => NULL,
                "transaction_date"  => date("Y-m-d"),
                "expired_date"  => date("Y-m-d", strtotime("+1 days")),
                "payment_id"    => NULL,
                "customer_reference_code" => "-",
                "tags"  => NULL,
                "status"    => 1,
            ]);

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Pesanan penjualan berhasil dibuat');

        return redirect()->to(base_url('supervisor/penjualan/' . $thisID . '/manage'));
    }

    public function sales_supervisor_manage($id)
    {
        $sale = $this->saleModel->where("id", $id)->where("admin_id", $this->session->login_id)->first();

        $team = $this->teamModel
            ->join('administrators', 'team.team_member_id = administrators.id', 'left')
            ->where('administrators.active', 1)
            ->where('leader_id', $this->session->login_id)
            ->findAll();

        $contacts = $this->contactModel
            ->where("type", 2)
            ->where("trash", 0)
            ->orderBy("name", "asc")
            ->findAll();

        $contact = $this->contactModel
            ->where("id", $sale->contact_id)->first();

        $admin = $this->adminModel
            ->where("id", $sale->admin_id)->first();

        $warehouse = $this->warehouseModel
            ->where("id", $sale->warehouse_id)
            ->first();

        $payments = $this->paymentModel
            ->where("trash", 0)
            ->orderBy("name", "asc")
            ->findAll();

        $tags = $this->tagModel
            ->orderBy("name", "asc")
            ->findAll();

        $products = $this->productModel
            ->where("trash", 0)
            ->orderBy("name", "asc")
            ->findAll();

        $items = $this->saleItemModel
            ->select("sale_items.*,B.quantity as QtyKeluar")
            ->join("delivery_items as B", "sale_items.id=B.sale_item_id", "left")
            ->where("sale_id", $id)
            ->findAll();

        $promos = $this->promoModel
            ->where("date_start <=", date("Y-m-d"))
            ->where("date_end >=", date("Y-m-d"))
            ->findAll();

        $contact = $this->contactModel
            ->where("id", $sale->contact_id)
            ->first();

        $warehouses = $this->warehouseModel
            ->where("trash", 0)
            ->orderBy("name", "asc")
            ->findAll();

        $payment = $this->paymentModel
            ->where("id", $sale->payment_id)
            ->first();

        $locations = $this->locationModel
            ->where("trash", 0)
            ->findAll();

        $goods = $this->saleItemModel
            ->select(["products.name as product_name", "products.id"])
            ->join('products', 'sale_items.product_id = products.id', 'left')
            ->where('sale_id', $id)
            ->orderBy('products.name', 'asc')
            ->findAll();

        $data = ([
            "db"    => $this->db,
            "contacts"  => $contacts,
            "contact"  => $contact,
            "goods"  => $goods,
            "admin"  => $admin,
            "payments" => $payments,
            "tags" => $tags,
            "products" => $products,
            "sale"  => $sale,
            "items" => $items,
            "promos" => $promos,
            "thisContact"   => $contact,
            "payment" => $payment,
            "locations" => $locations,
            "warehouses" => $warehouses,
            "team" => $team,
        ]);

        return view("supervisor/sales_manage_supervisor", $data);
    }

    public function sales_delete_penjualan($id)
    {
        $sale = $this->saleModel->where("id", $id)->first();
        if ($sale->status >= 6) {
            $this->session->setFlashdata('message_type', 'warning');
            $this->session->setFlashdata('message_content', 'Penjualan (SO) gagal dihapus');
            return redirect()->to(base_url('sales/sales/' . $id . '/manage'));
        }

        $items = $this->saleItemModel
            ->where("sale_id", $id)
            ->findAll();

        foreach ($items as $item) {
            $thisItem = $this->saleItemModel->where("id", $item->id)->first();
            $this->saleItemModel->where("id", $item->id)->delete();
            $this->productStockModel->where("sale_item_id", $item->id)->delete();
        }

        $this->saleModel->delete($id);
        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Penjualan (SO) berhasil dihapus');

        return redirect()->to(base_url('supervisor/sales/'));
    }

    public function ajax_sales_add_contact_data()
    {
        $id = $this->request->getPost('id');
        $row = $this->contactModel->where("id", $id)->first();
        echo json_encode($row);
    }

    public function ajax_sales_add_expired_data()
    {
        $id = $this->request->getPost('id');
        $row = $this->paymentModel->where("id", $id)->first();

        echo date("Y-m-d", strtotime("+" . $row->due_date . " days"));
    }

    public function ajax_sale_product_promos()
    {
        $product = $this->request->getPost('product');
        $price_level = $this->request->getPost('price_level');

        $promos = $this->db->table('promos');
        $promos->where("product_id", $product);
        $promos->where("price_level", $price_level);
        $promos->where("date_start <=", date('Y-m-d'));
        $promos->where("date_end >=", date('Y-m-d'));
        $promos->orderBy('code', 'asc');

        $promos = $promos->get();
        $promos = $promos->getResultObject();

        foreach ($promos as $promo) {
            echo "<option value='" . $promo->id . "'>" . $promo->code . "</option>";
        }
    }

    public function ajax_sale_product_all(){
        $product = $this->request->getPost('product');
        $warehouse = $this->request->getPost('warehouse');

        $stocks = $this->db->table("warehouses A");
        $stocks->select('A.id,A.name,sum(if(B.quantity is null,0,B.quantity)) as QTY');
        $stocks->join('product_stocks B','(A.id=B.warehouse_id and B.product_id="'.$product.'")','left');
        $stocks->groupBy('A.id');
        $stocks = $stocks->get();
        $stocks = $stocks->getResultArray();

        echo '<option value="">--Pilih Gudang--</option>';
        

        foreach($stocks as $row){
        $stok_qty = $row['QTY'];
        
        if($row['QTY'] > 10){
            $stok_qty = '10+';
        }

        if( $row['QTY'] > 0){
            echo "<option value='".$row['id']."'  >".$row['name']."  (".$stok_qty." Unit)"."</option>";
        }else{
            if($row['id'] == '6') {

                 echo "<option value='".$row['id']."'  >".$row['name']."  (".$stok_qty." Unit)"."</option>";

            }
           
        }
        
        }
    }

    public function ajax_sale_product_stocks()
    {
        $product = $this->request->getPost('product');
        $warehouse = $this->request->getPost('warehouse');

        $stocks = $this->db->table("product_stocks");
        $stocks->selectSum("product_stocks.quantity");
        $stocks->select("products.unit as 'product_unit'");
        $stocks->join("products", "product_stocks.product_id=products.id", "right");
        $stocks->where("product_stocks.product_id", $product);
        $stocks->where("product_stocks.warehouse_id", 1);

        $stocks = $stocks->get();
        $stocks = $stocks->getFirstRow();

        if ($stocks->quantity <= 0) {
            echo "0~" . $stocks->product_unit;
        } else {
            echo $stocks->quantity . "~" . $stocks->product_unit;
        }
    }

    public function sales_save()
    {
        $id = $this->request->getPost('id');
        $member = $this->request->getPost('member_id');
        $contact = $this->request->getPost('contact');
        // $warehouse = $this->request->getPost('warehouse');
        $invoice_address = $this->request->getPost('invoice_address');
        $sales_notes = $this->request->getPost('sales_notes');
        $transaction_date = $this->request->getPost('transaction_date');
        $expired_date = $this->request->getPost('expired_date');
        $payment = $this->request->getPost('payment');
        $location_id = $this->request->getPost('location_id');
        $order_id = $this->request->getPost('order_id');
        $cabang_id = $this->request->getPost('cabang_id');
        // $reference = $this->request->getPost('reference');
        // $tags = $this->request->getPost('tags');

        $thisTags = NULL;

        if ($this->request->getPost('tags')) {
            $tags = $this->request->getPost('tags');
            foreach ($tags as $tag) {
                $thisTags .= "#" . $tag;
            }
        } else {
        }
        // echo $thisTag;

        if ($this->request->getPost('sales_notes')) {
            $sales_notes = $this->request->getPost('sales_notes');
        } else {
            $sales_notes = NULL;
        }

        $this->saleModel
            ->where("id", $id)
            ->set([
                "cabang_id" => $cabang_id,
                "contact_id"    => $contact,
                "invoice_address" => $invoice_address,
                "sales_notes" => $sales_notes,
                "transaction_date"  => $transaction_date,
                "expired_date"  => $expired_date,
                "payment_id"    => $payment,
                "location_id"   => $location_id,
                "customer_reference_code" => "-",
                "tags"  => $thisTags,
                "sales_notes" => $sales_notes,
                "order_id" => $order_id,
                'member_id' => $member
            ])->update();

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Pesanan penjualan berhasil disimpan');

        return redirect()->to(base_url('supervisor/penjualan/' . $id . '/manage'));
    }


    public function ajax_sale_product_prices()
    {
        $id = $this->request->getPost('product');

        $product = $this->productModel->where("id", $id)->first();

        $rumus = $this->productPriceModel->where("id", $product->price_id)->first();

        $level = $this->adminModel->where("id", $this->session->login_id)->first();


        $supervisor = $this->insentifModel->where('role', $level->role)->where('price_id', $rumus->id)->first();

        $level_harga_supervisor = [
            0,
            $supervisor->level_1,
            $supervisor->level_2,
            $supervisor->level_3,
            $supervisor->level_4,
            $supervisor->level_5,
            $supervisor->level_6,
            $supervisor->level_7,
            $supervisor->level_8,
            $supervisor->level_9,
            $supervisor->level_10,
        ];

        $margins = ([
            0, // 0
            $rumus->plus_one, // margin ke-1
            $rumus->plus_two, // margin ke-2
            $rumus->plus_three, // margin ke-3
            $rumus->plus_four, // margin ke-4
            $rumus->plus_five, // margin ke-5
            $rumus->plus_six, // margin ke-6
            $rumus->plus_seven, // margin ke-7
            $rumus->plus_eight, // margin ke-8
            $rumus->plus_nine, // margin ke-9
            $rumus->plus_ten, // margin ke-10
        ]);


        $arrayPrices = ([0]);
        $thisPrice = floatval($product->price);
        array_push($arrayPrices, $thisPrice);



        for ($p = 2; $p <= 10; $p++) {
            $thisPrice += $margins[$p];


            array_push($arrayPrices, $thisPrice);
        }

        for ($x = 1; $x <= 10; $x++) {

            $level_supervisor = floatval($level_harga_supervisor[$x]);
            $insentif_supervisor = ($arrayPrices[$x] * $level_supervisor) / 100;

            echo "<option value='" . $x . "-" . $arrayPrices[$x] . "-" . $insentif_supervisor . "'>($x) Rp. " . number_format($arrayPrices[$x], 0, ",", ".") . ' (Rp. ' . number_format($insentif_supervisor, 0, ",", ".") . ')' . "</option>";
        }
    }

    public function sale_item_add()
    {
        $sale = $this->request->getPost('sale');
        $warehouse = $this->request->getPost('warehouse');
        $product = $this->request->getPost('product');
        $price = $this->request->getPost('price');
        $qty = $this->request->getPost('qty');
        $tax = $this->request->getPost('tax');
        //$discount = $this->request->getPost('discount');
        $promo = $this->request->getPost('promo');
        $thisSale = $this->saleModel->where("id", $sale)->first();


        if (config("Login")->loginRole == 4 || config("Login")->loginRole == 5) {
            $explodePrice = explode("-", $price);
            $thisPriceLevel = $explodePrice[0];
            $thisPriceValue = $explodePrice[1];
          
            if(count($explodePrice) >= 3)
            {
                $thisPriceBonusSpv = $explodePrice[2];
            }else{
                $thisPriceBonusSpv = "";
            }

            if ($this->request->getPost("custom_price")) {
                $admin = $this->adminModel->where('id', $this->session->login_id)->first();
                $role = $admin->role;
                $custom_price = $this->request->getPost("custom_price");
                $custom = $this->insentifModel->where('role', $role)->where('price_id', 11)->first();

                // if ($custom) {
                //     $harga = floatval($custom->custom_price);
                //     $incentive = ($custom_price * $harga) / 100;
                // } else {
                //     $incentive = 0;
                // }


                $dataInsert = ([
                    "sale_id"   => $sale,
                    "product_id"   => $product,
                    "quantity" => $qty,
                    "price" => $custom_price,
                    // "bonus_supervisor" => $incentive,
                    "price_level" => 11,
                    "tax"   => $tax,
                    //"discount"   => $discount,
                    "promo_id"   => $promo,
                    "need_approve" => 3,
                    "ready" => 0,
                    "date" => date('Y,m,d')
                ]);
            } elseif ($thisPriceLevel == 2) {
                $dataInsert = ([
                    "sale_id"   => $sale,
                    "product_id"   => $product,
                    "quantity" => $qty,
                    "price" => $thisPriceValue,
                    "price_level" => $thisPriceLevel,

                    "bonus_supervisor" => $thisPriceBonusSpv,
                    "tax"   => $tax,
                    //"discount"   => $discount,
                    "promo_id"   => $promo,
                    "need_approve" => 0,
                    "ready" => 1,
                    "date" => date('Y,m,d')
                ]);
            } else {
                $dataInsert = ([
                    "sale_id"   => $sale,
                    "product_id"   => $product,
                    "quantity" => $qty,
                    "price" => $thisPriceValue,
                    "price_level" => $thisPriceLevel,
                    "tax"   => $tax,
                    //"discount"   => $discount,
                    "promo_id"   => $promo,
                    "need_approve" => 0,
                    "ready" => 1
                ]);
            }

            if ($thisPriceLevel == 3) {
                $dataInsert = ([
                    "sale_id"   => $sale,
                    "product_id"   => $product,
                    "quantity" => $qty,
                    "price" => $thisPriceValue,
                    "price_level" => $thisPriceLevel,

                    "bonus_supervisor" => $thisPriceBonusSpv,
                    "tax"   => $tax,
                    //"discount"   => $discount,
                    "promo_id"   => $promo,
                    "need_approve" => 0,
                    "approve_status" => 1,
                    "ready" => 1
                ]);
            }

            if ($thisPriceLevel == 4) {
                $dataInsert = ([
                    "sale_id"   => $sale,
                    "product_id"   => $product,
                    "quantity" => $qty,
                    "price" => $thisPriceValue,
                    "price_level" => $thisPriceLevel,

                    "bonus_supervisor" => $thisPriceBonusSpv,
                    "tax"   => $tax,
                    //"discount"   => $discount,
                    "promo_id"   => $promo,
                    "need_approve" => 0,
                    "approve_status" => 1,
                    "ready" => 1
                ]);
            }

            if ($thisPriceLevel == 5) {
                $dataInsert = ([
                    "sale_id"   => $sale,
                    "product_id"   => $product,
                    "quantity" => $qty,
                    "price" => $thisPriceValue,
                    "price_level" => $thisPriceLevel,

                    "bonus_supervisor" => $thisPriceBonusSpv,
                    "tax"   => $tax,
                    //"discount"   => $discount,
                    "promo_id"   => $promo,
                    "need_approve" => 0,
                    "approve_status" => 1,
                    "ready" => 1
                ]);
            }

            if ($thisPriceLevel == 6) {
                $dataInsert = ([
                    "sale_id"   => $sale,
                    "product_id"   => $product,
                    "quantity" => $qty,
                    "price" => $thisPriceValue,
                    "price_level" => $thisPriceLevel,

                    "bonus_supervisor" => $thisPriceBonusSpv,
                    "tax"   => $tax,
                    //"discount"   => $discount,
                    "promo_id"   => $promo,
                    "need_approve" => 0,
                    "approve_status" => 1,
                    "ready" => 1
                ]);
            }

            if ($thisPriceLevel == 7) {
                $dataInsert = ([
                    "sale_id"   => $sale,
                    "product_id"   => $product,
                    "quantity" => $qty,
                    "price" => $thisPriceValue,
                    "price_level" => $thisPriceLevel,

                    "bonus_supervisor" => $thisPriceBonusSpv,
                    "tax"   => $tax,
                    //"discount"   => $discount,
                    "promo_id"   => $promo,
                    "need_approve" => 0,
                    "approve_status" => 1,
                    "ready" => 1
                ]);
            }

            if ($thisPriceLevel == 8) {
                $dataInsert = ([
                    "sale_id"   => $sale,
                    "product_id"   => $product,
                    "quantity" => $qty,
                    "price" => $thisPriceValue,
                    "price_level" => $thisPriceLevel,

                    "bonus_supervisor" => $thisPriceBonusSpv,
                    "tax"   => $tax,
                    //"discount"   => $discount,
                    "promo_id"   => $promo,
                    "need_approve" => 0,
                    "approve_status" => 1,
                    "ready" => 1
                ]);
            }

            if ($thisPriceLevel == 9) {
                $dataInsert = ([
                    "sale_id"   => $sale,
                    "product_id"   => $product,
                    "quantity" => $qty,
                    "price" => $thisPriceValue,
                    "price_level" => $thisPriceLevel,

                    "bonus_supervisor" => $thisPriceBonusSpv,
                    "tax"   => $tax,
                    //"discount"   => $discount,
                    "promo_id"   => $promo,
                    "need_approve" => 0,
                    "approve_status" => 1,
                    "ready" => 1
                ]);
            }

            if ($thisPriceLevel == 10) {
                $dataInsert = ([
                    "sale_id"   => $sale,
                    "product_id"   => $product,
                    "quantity" => $qty,
                    "price" => $thisPriceValue,
                    "price_level" => $thisPriceLevel,

                    "bonus_supervisor" => $thisPriceBonusSpv,
                    "tax"   => $tax,
                    //"discount"   => $discount,
                    "promo_id"   => $promo,
                    "need_approve" => 0,
                    "approve_status" => 1,
                    "ready" => 1
                ]);
            }
        } else {
            if (config("Login")->loginRole == 7) {
                if ($this->request->getPost("custom_price")) {
                    $custom_price = $this->request->getPost("custom_price");
                    $dataInsert = ([
                        "sale_id"   => $sale,
                        "product_id"   => $product,
                        "quantity" => $qty,
                        "price" => $custom_price,
                        "price_level" => 11,
                        "tax"   => $tax,
                        //"discount"   => $discount,
                        "promo_id"   => $promo,
                        "need_approve" => 0,
                        "ready" => 1
                    ]);
                } else {
                    $explodePrice = explode("-", $price);
                    $thisPriceLevel = $explodePrice[0];
                    $thisPriceValue = $explodePrice[1];
                    $dataInsert = ([
                        "sale_id"   => $sale,
                        "product_id"   => $product,
                        "quantity" => $qty,
                        "price" => $thisPriceValue,
                        "price_level" => $thisPriceLevel,
                        "tax"   => $tax,
                        //"discount"   => $discount,
                        "promo_id"   => $promo,
                        "need_approve" => 0,
                        "ready" => 1
                    ]);
                }
            } else {
                if ($this->request->getPost("custom_price")) {
                    $custom_price = $this->request->getPost("custom_price");
                    $dataInsert = ([
                        "sale_id"   => $sale,
                        "product_id"   => $product,
                        "quantity" => $qty,
                        "price" => $custom_price,
                        "price_level" => 11,
                        "tax"   => $tax,
                        //"discount"   => $discount,
                        "promo_id"   => $promo,
                        "need_approve" => 3,
                        "ready" => 0,
                        "date" => date('Y,m,d')

                    ]);
                } else {
                    $explodePrice = explode("-", $price);
                    $thisPriceLevel = $explodePrice[0];
                    $thisPriceValue = $explodePrice[1];
                    $thisPriceBonus = $explodePrice[2];
                    

                    if (config("Login")->loginRole == 4) {
                        if ($thisPriceLevel == 4) {
                            $dataInsert = ([
                                "sale_id"   => $sale,
                                "product_id"   => $product,
                                "quantity" => $qty,
                                "price" => $thisPriceValue,
                                "price_level" => $thisPriceLevel,

                                "bonus_supervisor" => $thisPriceBonusSpv,
                                "tax"   => $tax,
                                //"discount"   => $discount,
                                "promo_id"   => $promo,
                                "need_approve" => 1,
                                "ready" => 0,
                                "date" => date('Y,m,d')
                            ]);
                        } elseif ($thisPriceLevel <= 3) {
                            $dataInsert = ([
                                "sale_id"   => $sale,
                                "product_id"   => $product,
                                "quantity" => $qty,
                                "price" => $thisPriceValue,
                                "price_level" => $thisPriceLevel,

                                "bonus_supervisor" => $thisPriceBonusSpv,
                                "tax"   => $tax,
                                //"discount"   => $discount,
                                "promo_id"   => $promo,
                                "need_approve" => 3,
                                "ready" => 0,
                                "date" => date('Y,m,d')
                            ]);
                        } else {
                            $dataInsert = ([
                                "sale_id"   => $sale,
                                "product_id"   => $product,
                                "quantity" => $qty,
                                "price" => $thisPriceValue,
                                "price_level" => $thisPriceLevel,

                                "bonus_supervisor" => $thisPriceBonusSpv,
                                "tax"   => $tax,
                                // "discount"   => $discount,
                                "promo_id"   => $promo,
                                "need_approve" => 0,
                                "ready" => 1
                            ]);
                        }

                        if ($thisPriceLevel == 5) {
                            $dataInsert = ([
                                "sale_id"   => $sale,
                                "product_id"   => $product,
                                "quantity" => $qty,
                                "price" => $thisPriceValue,
                                "price_level" => $thisPriceLevel,

                                "bonus_supervisor" => $thisPriceBonusSpv,
                                "tax"   => $tax,
                                //"discount"   => $discount,
                                "promo_id"   => $promo,
                                "need_approve" => 0,
                                "approve_status" => 1,
                                "ready" => 1
                            ]);
                        }

                        if ($thisPriceLevel == 6) {
                            $dataInsert = ([
                                "sale_id"   => $sale,
                                "product_id"   => $product,
                                "quantity" => $qty,
                                "price" => $thisPriceValue,
                                "price_level" => $thisPriceLevel,

                                "bonus_supervisor" => $thisPriceBonusSpv,
                                "tax"   => $tax,
                                //"discount"   => $discount,
                                "promo_id"   => $promo,
                                "need_approve" => 0,
                                "approve_status" => 1,
                                "ready" => 1
                            ]);
                        }

                        if ($thisPriceLevel == 7) {
                            $dataInsert = ([
                                "sale_id"   => $sale,
                                "product_id"   => $product,
                                "quantity" => $qty,
                                "price" => $thisPriceValue,
                                "price_level" => $thisPriceLevel,

                                "bonus_supervisor" => $thisPriceBonusSpv,
                                "tax"   => $tax,
                                //"discount"   => $discount,
                                "promo_id"   => $promo,
                                "need_approve" => 0,
                                "approve_status" => 1,
                                "ready" => 1
                            ]);
                        }

                        if ($thisPriceLevel == 8) {
                            $dataInsert = ([
                                "sale_id"   => $sale,
                                "product_id"   => $product,
                                "quantity" => $qty,
                                "price" => $thisPriceValue,
                                "price_level" => $thisPriceLevel,

                                "bonus_supervisor" => $thisPriceBonusSpv,
                                "tax"   => $tax,
                                //"discount"   => $discount,
                                "promo_id"   => $promo,
                                "need_approve" => 0,
                                "approve_status" => 1,
                                "ready" => 1
                            ]);
                        }

                        if ($thisPriceLevel == 9) {
                            $dataInsert = ([
                                "sale_id"   => $sale,
                                "product_id"   => $product,
                                "quantity" => $qty,
                                "price" => $thisPriceValue,
                                "price_level" => $thisPriceLevel,

                                "bonus_supervisor" => $thisPriceBonusSpv,
                                "tax"   => $tax,
                                //"discount"   => $discount,
                                "promo_id"   => $promo,
                                "need_approve" => 0,
                                "approve_status" => 1,
                                "ready" => 1
                            ]);
                        }

                        if ($thisPriceLevel == 10) {
                            $dataInsert = ([
                                "sale_id"   => $sale,
                                "product_id"   => $product,
                                "quantity" => $qty,
                                "price" => $thisPriceValue,
                                "price_level" => $thisPriceLevel,

                                "bonus_supervisor" => $thisPriceBonusSpv,
                                "tax"   => $tax,
                                //"discount"   => $discount,
                                "promo_id"   => $promo,
                                "need_approve" => 0,
                                "approve_status" => 1,
                                "ready" => 1
                            ]);
                        }
                    } elseif (config("Login")->loginRole == 5) {
                        if ($thisPriceLevel == 2) {
                            $dataInsert = ([
                                "sale_id"   => $sale,
                                "product_id"   => $product,
                                "quantity" => $qty,
                                "price" => $thisPriceValue,
                                "price_level" => $thisPriceLevel,

                                "bonus_supervisor" => $thisPriceBonusSpv,
                                "tax"   => $tax,
                                //"discount"   => $discount,
                                "promo_id"   => $promo,
                                "need_approve" => 2,
                                "ready" => 0,
                                "date" => date('Y,m,d')
                            ]);
                        } else {
                            $dataInsert = ([
                                "sale_id"   => $sale,
                                "product_id"   => $product,
                                "quantity" => $qty,
                                "price" => $thisPriceValue,
                                "price_level" => $thisPriceLevel,

                                "bonus_supervisor" => $thisPriceBonusSpv,
                                "tax"   => $tax,
                                //"discount"   => $discount,
                                "promo_id"   => $promo,
                                "need_approve" => 0,
                                "ready" => 1
                            ]);
                        }

                        if ($thisPriceLevel == 3) {
                            $dataInsert = ([
                                "sale_id"   => $sale,
                                "product_id"   => $product,
                                "quantity" => $qty,
                                "price" => $thisPriceValue,
                                "price_level" => $thisPriceLevel,

                                "bonus_supervisor" => $thisPriceBonusSpv,
                                "tax"   => $tax,
                                //"discount"   => $discount,
                                "promo_id"   => $promo,
                                "need_approve" => 0,
                                "approve_status" => 1,
                                "ready" => 1
                            ]);
                        }

                        if ($thisPriceLevel == 4) {
                            $dataInsert = ([
                                "sale_id"   => $sale,
                                "product_id"   => $product,
                                "quantity" => $qty,
                                "price" => $thisPriceValue,
                                "price_level" => $thisPriceLevel,

                                "bonus_supervisor" => $thisPriceBonusSpv,
                                "tax"   => $tax,
                                //"discount"   => $discount,
                                "promo_id"   => $promo,
                                "need_approve" => 0,
                                "approve_status" => 1,
                                "ready" => 1
                            ]);
                        }

                        if ($thisPriceLevel == 5) {
                            $dataInsert = ([
                                "sale_id"   => $sale,
                                "product_id"   => $product,
                                "quantity" => $qty,
                                "price" => $thisPriceValue,
                                "price_level" => $thisPriceLevel,

                                "bonus_supervisor" => $thisPriceBonusSpv,
                                "tax"   => $tax,
                                //"discount"   => $discount,
                                "promo_id"   => $promo,
                                "need_approve" => 0,
                                "approve_status" => 1,
                                "ready" => 1
                            ]);
                        }

                        if ($thisPriceLevel == 6) {
                            $dataInsert = ([
                                "sale_id"   => $sale,
                                "product_id"   => $product,
                                "quantity" => $qty,
                                "price" => $thisPriceValue,
                                "price_level" => $thisPriceLevel,

                                "bonus_supervisor" => $thisPriceBonusSpv,
                                "tax"   => $tax,
                                //"discount"   => $discount,
                                "promo_id"   => $promo,
                                "need_approve" => 0,
                                "approve_status" => 1,
                                "ready" => 1
                            ]);
                        }

                        if ($thisPriceLevel == 7) {
                            $dataInsert = ([
                                "sale_id"   => $sale,
                                "product_id"   => $product,
                                "quantity" => $qty,
                                "price" => $thisPriceValue,
                                "price_level" => $thisPriceLevel,

                                "bonus_supervisor" => $thisPriceBonusSpv,
                                "tax"   => $tax,
                                //"discount"   => $discount,
                                "promo_id"   => $promo,
                                "need_approve" => 0,
                                "approve_status" => 1,
                                "ready" => 1
                            ]);
                        }

                        if ($thisPriceLevel == 8) {
                            $dataInsert = ([
                                "sale_id"   => $sale,
                                "product_id"   => $product,
                                "quantity" => $qty,
                                "price" => $thisPriceValue,
                                "price_level" => $thisPriceLevel,

                                "bonus_supervisor" => $thisPriceBonusSpv,
                                "tax"   => $tax,
                                //"discount"   => $discount,
                                "promo_id"   => $promo,
                                "need_approve" => 0,
                                "approve_status" => 1,
                                "ready" => 1
                            ]);
                        }

                        if ($thisPriceLevel == 9) {
                            $dataInsert = ([
                                "sale_id"   => $sale,
                                "product_id"   => $product,
                                "quantity" => $qty,
                                "price" => $thisPriceValue,
                                "price_level" => $thisPriceLevel,

                                "bonus_supervisor" => $thisPriceBonusSpv,
                                "tax"   => $tax,
                                //"discount"   => $discount,
                                "promo_id"   => $promo,
                                "need_approve" => 0,
                                "approve_status" => 1,
                                "ready" => 1
                            ]);
                        }

                        if ($thisPriceLevel == 10) {
                            $dataInsert = ([
                                "sale_id"   => $sale,
                                "product_id"   => $product,
                                "quantity" => $qty,
                                "price" => $thisPriceValue,
                                "price_level" => $thisPriceLevel,
                                "bonus_supervisor" => $thisPriceBonusSpv,
                                "tax"   => $tax,
                                //"discount"   => $discount,
                                "promo_id"   => $promo,
                                "need_approve" => 0,
                                "approve_status" => 1,
                                "ready" => 1
                            ]);
                        }
                    }
                }
            }
        }

        $this->saleItemModel->insert($dataInsert);

        $saleItemID = $this->saleItemModel->getInsertID();

        $qtyStock = 0 - $qty;
        $this->productStockModel->insert([
            "product_id"    => $product,
            "warehouse_id" => $warehouse,
            "sale_item_id" => $saleItemID,
            "date"  => date("Y-m-d"),
            "quantity"  => $qtyStock,
        ]);

        if ($promo != 0) {
            $gifts = $this->db->table("bundlings");
            $gifts->select("bundlings.product_id as bundling_product_id");
            $gifts->select("bundlings.price as price");
            $gifts->select("bundlings.price_level as price_level");
            $gifts->select("bundlings.id as bundling_id");
            $gifts->select("products.name as product_name");
            $gifts->join("products", "bundlings.product_id=products.id", "left");
            $gifts->where("promo_id", $promo);
            $gifts = $gifts->get();
            $gifts = $gifts->getResultObject();

            if ($gifts != NULL) {
                foreach ($gifts as $gift) {
                    $giftStocks = $this->db->table("product_stocks");
                    $giftStocks->selectSum("product_stocks.quantity");
                    $giftStocks->join("products", "product_stocks.product_id=products.id", "right");
                    $giftStocks->where("product_stocks.product_id", $gift->bundling_product_id);
                    $giftStocks->where("product_stocks.warehouse_id", $warehouse);

                    $giftStocks = $giftStocks->get();
                    $giftStocks = $giftStocks->getFirstRow();

                    if ($giftStocks->quantity >= $qty) {
                        $qtyGiftStock = 0 - $qty;
                        $this->productStockModel->insert([
                            "product_id"    => $gift->bundling_product_id,
                            "warehouse_id" => $warehouse,
                            "sale_item_id" => $saleItemID,
                            "date"  => date("Y-m-d"),
                            "quantity"  => $qtyGiftStock,
                        ]);

                        $this->saleItemBundlingModel->insert([
                            "promo_id" => $promo,
                            "price" => $gift->price,
                            "sale_item_id" => $saleItemID,
                            "product_id" => $gift->bundling_product_id,
                            "quantity" => $qty,
                        ]);
                    }
                }
            }
        }

        $items = $this->saleItemModel->where("sale_id", $sale)->findAll();
        $saleReady = 1;
        foreach ($items as $item) {
            $saleReady = $saleReady * $item->ready;
        }

        if ($saleReady == 1) {
            $this->saleModel->where("id", $sale)
                ->set(["status" => 2])->update();
        } else {
            $this->saleModel->where("id", $sale)
                ->set(["status" => 1])->update();
        }

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Barang berhasil ditambahkan ke dalam pesanan penjualan');

        return redirect()->back();
    }
}
