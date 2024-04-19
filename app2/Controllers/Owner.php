<?php

namespace App\Controllers;

helper('tools_helper');

use Hermawan\DataTables\DataTable;

class Owner extends BaseController
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
    private $addressModel;
    private $locationModel;
    private $alasanModel;
    private $deliveryModel;
    private $deliveryItemModel;
    private $statusModel;
    private $buysModel;
    private $buyItemsModel;
    private $insentifModel;
    private $staggingDOModel;
    private $productPriceModel;
    private $branchModel;

    public function __construct()
    {
        $this->session = \Config\Services::session();

        $this->db = \Config\Database::connect();
        $this->validation =  \Config\Services::validation();

        $this->adminModel = new \App\Models\Administrator();

        $this->staggingDOModel = new \App\Models\staggingDO();
        $this->productCategoriesModel = new \App\Models\Category();
        $this->productModel = new \App\Models\Product();
        $this->statusModel = new \App\Models\Status();
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
        $this->addressModel = new \App\Models\Address();
        $this->locationModel = new \App\Models\Location();
        $this->alasanModel = new \App\Models\Alasan();
        $this->deliveryModel = new \App\Models\Delivery();
        $this->deliveryItemModel = new \App\Models\DeliveryItem();
        $this->buysModel = new \App\Models\Buy();
        $this->buyItemsModel = new \App\Models\BuyItem();
        $this->insentifModel = new \App\Models\Insentif();
        $this->branchModel = new \App\Models\Branch();

        if ($this->session->login_id == null) {
            $this->session->setFlashdata('msg', 'Maaf, Silahkan login terlebih dahulu!');
            header("location:" . base_url('/'));
            exit();
        } else {
            if (config("Login")->loginRole != 7) {
                header("location:" . base_url('/dashboard'));
                exit();
            }
        }
    }

    public function approve_do()
    {
        $stages = $this->db->table('staggingdo');
        $stages->select([
            'staggingdo.id',
            'sales.number as sale_number',
            'staggingdo.date as submit_date',
            'administrators.name as admin_name',
        ]);
        $stages->join('sales', 'staggingdo.sale_id = sales.id', 'left');
        $stages->join('administrators', 'staggingdo.admin_id = administrators.id', 'left');
        $stages->where('trash', 0);
        $stages->orderBy('staggingdo.id', 'asc');
        $stages = $stages->get();
        $stages = $stages->getResultObject();

        $data = ([
            'db'   => $this->db,
            'stages'   => $stages,
        ]);

        return view('owner/approve_do', $data);
    }

    public function approve_do_manage($id)
    {
        $stages = $this->db->table('staggingdo');
        $stages->select([
            'staggingdo.id',
            'staggingdo.image_path',
            'staggingdo.reason',
            'sales.number as sale_number',
            'contacts.name as contact_name',
            'staggingdo.date as submit_date',
            'administrators.name as admin_name',
            'contacts.address as contact_address',
        ]);
        $stages->join('sales', 'staggingdo.sale_id = sales.id', 'left');
        $stages->join('contacts', 'sales.contact_id = contacts.id', 'left');
        $stages->join('administrators', 'staggingdo.admin_id = administrators.id', 'left');
        $stages->where('staggingdo.id', $id);
        $stages = $stages->get();
        $stages = $stages->getFirstRow();


        $data = ([
            'db'    => $this->db,
            'stages'   => $stages,
        ]);

        return view('owner/approve_do_manage', $data);
    }

    public function approve_do_check($id)
    {
        $this->staggingDOModel->where('id', $id)
            ->set([
                "status" => 1,
            ])->update();

        $approve = $this->staggingDOModel->where('id', $id)->get()->getFirstRow();

        if ($approve->status > 0) {
            $this->deliveryModel->where('sale_id', $approve->sale_id)
                ->set(['print' => 0])->update();
        }

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data Pengajuan Print Ulang Berhasil Disetujui');

        return redirect()->back();
    }

    public function perubahan_data()
    {
        $alasan = $this->statusModel
            ->select([
                'administrators.name as admin_name',
                'buys.number as buy_number',
                'contacts.name as contact_name',
                'products.name as product_name',
                'status_pd.alasan as alasan_perubahan',
                'status_pd.buy_id', 'status_pd.id',
            ])
            ->join('administrators', 'status_pd.admin_id = administrators.id', 'left')
            ->join('buys', 'status_pd.buy_id = buys.id', 'left')
            ->join('contacts', 'status_pd.contact_id = contacts.id', 'left')
            ->join('products', 'status_pd.product_id = products.id', 'left')
            ->where('status_pd.ready', 0)
            ->orderBy('status_pd.id', 'desc')
            ->get()->getResultObject();

        $data = ([
            'alasan' => $alasan,
            'db' => $this->db,
        ]);

        return view('owner/perubahan_data_pd', $data);
    }

    public function perubahan_data_manage($id)
    {
        $alasan = $this->statusModel
            ->select([
                'administrators.name as admin_name',
                'buys.number as buy_number',
                'contacts.name as contact_name',
                'products.name', 'buy_items.id as item_id',
                'status_pd.alasan as alasan_perubahan',
                'status_pd.buy_id', 'status_pd.id',
            ])
            ->join('administrators', 'status_pd.admin_id = administrators.id', 'left')
            ->join('buy_items', 'status_pd.buy_id = buy_items.buy_id', 'left')
            ->join('buys', 'status_pd.buy_id = buys.id', 'left')
            ->join('contacts', 'status_pd.contact_id = contacts.id', 'left')
            ->join('products', 'status_pd.product_id = products.id', 'left')
            ->where('status_pd.id', $id)
            ->where('status_pd.ready', 0)
            ->orderBy('status_pd.id', 'desc')
            ->get()->getFirstRow();

        $products = $this->statusModel
            ->select([
                'administrators.name as admin_name',
                'products.name as product_name',
                'status_pd.stok_awal', 'stok_sekarang',
                'status_pd.id', 'status_pd.buy_id',
            ])
            ->join('administrators', 'status_pd.admin_id = administrators.id', 'left')
            ->join('products', 'status_pd.product_id = products.id', 'left')
            ->where('status_pd.id', $id)
            ->where('status_pd.ready', 0)
            ->get()->getResultObject();

        $data = ([
            'alasan' => $alasan,
            'products' => $products,
            'db' => $this->db,
        ]);

        return view('owner/perubahan_data_manage', $data);
    }

    public function approve_perubahan_data($buy_id, $buyItemID)
    {
        $this->statusModel->where('status_pd.id', $buy_id)
            ->set([
                "ready" => 1,
            ])->update();

        $approved = $this->statusModel->where('status_pd.id', $buy_id)->orderBy('id', 'desc')->first();

        if ($approved->ready > 0) {
            $this->buyItemsModel
                ->where('buy_items.id', $approved->buy_item_id)
                ->set([
                    'quantity' => $approved->stok_sekarang,
                    'need_approve' => 3,
                    'approve_status' => 1,
                    'admin_approve_id' => $this->session->login_id,
                ])->update();

            $this->productStockModel
                ->where('product_stocks.buy_item_id', $approved->buy_item_id)
                ->set(['quantity' => $approved->stok_sekarang])->update();
        }

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data Berhasil Disetujui');

        return redirect()->to(base_url('owner/perubahan_data'));
    }

    public function perubahan_status()
    {
        $alasan = $this->alasanModel
            ->select([
                'status_so.id',
                'sales.number as sale_number',
                'status_so.sale_id',
                'administrators.name as admin_name',
                'contacts.name as contact_name',
                'status_so.status_awal',
                'status_so.need_approve',
                'status_so.alasan_status as alasan',
                'status_so.approve_status',
                'status_so.admin_approve_id',
            ])
            ->join('contacts', 'status_so.contact_id = contacts.id', 'left')
            ->join('administrators', 'status_so.admin_id = administrators.id', 'left')
            ->join('sales', 'status_so.sale_id = sales.id', 'left')
            ->where('status_so.approve_status', 0)
            ->orderBy('status_so.id', 'desc')
            ->findAll();

        $data = ([
            'db' => $this->db,
            'alasan' => $alasan,
        ]);

        return view('owner/perubahan_status', $data);
    }

    public function perubahan_status_manage($id)
    {
        $alasan = $this->alasanModel
            ->select([
                'status_so.id',
                'status_so.product_id',
                'status_so.qty_edit', 'harga_edit',
                'sales.number as sale_number',
                'status_so.sale_id',
                'administrators.name as admin_name',
                'contacts.name as contact_name',
                'status_so.status_awal',
                'status_so.need_approve',
                'status_so.alasan_status as alasan',
                'status_so.approve_status',
                'status_so.admin_approve_id',
            ])
            ->join('contacts', 'status_so.contact_id = contacts.id', 'left')
            ->join('administrators', 'status_so.admin_id = administrators.id', 'left')
            ->join('sales', 'status_so.sale_id = sales.id', 'left')
            ->where('status_so.id', $id)
            ->orderBy('status_so.id', 'desc')
            ->get()->getResultObject();

        $datas = $this->alasanModel
            ->select([
                'sales.number as sale_number',
                'contacts.name as contact_name',
                'contacts.address as addresses',
                'status_so.alasan_status as alasan',
                'administrators.name as admin_name',
            ])
            ->join('sales', 'status_so.sale_id = sales.id', 'left')
            ->join('contacts', 'status_so.contact_id = contacts.id', 'left')
            ->join('administrators', 'status_so.admin_id = administrators.id', 'left')
            ->where('status_so.id', $id)
            ->get()->getFirstRow();

        $data = ([
            'db' => $this->db,
            'datas' => $datas,
            'alasan' => $alasan,
        ]);
        return view('owner/perubahan_status_manage', $data);
    }

    public function approve_perubahan($id)
    {

        $this->alasanModel->where('status_so.sale_id', $id)
            ->set([
                "approve_status" => 1,
            ])->update();

        $approve = $this->alasanModel->where('sale_id', $id)->get()->getFirstRow();

        if ($approve->approve_status > 0) {
            $this->saleModel->where('sales.id', $approve->sale_id)
                ->set(['status' => 2])->update();
        }

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data perubahan so berhasil di setujui');

        return redirect()->to(base_url('owner/perubahan_status'));
    }

    public function unapprove_perubahan($id)
    {
        $this->alasanModel->where("status_so.sale_id", $id)
            ->set([
                "approve_status" => 2,
            ])->update();

        $unapprove = $this->alasanModel->where('sale_id', $id)->get()->getFirstRow();

        if ($unapprove->approve_status > 0) {
            $this->saleModel->where('sales.id', $unapprove->sale_id)
                ->set(['status' => 3])->update();

            $this->saleItemModel->where("sale_id", $id)
                ->set([
                    "approve_status" => 2,
                    "need_approve" => 3,
                    "admin_approve_id" => 12,
                ])->update();
        }

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'SO tidak disetujui');

        return redirect()->to(base_url('owner/perubahan_status'));
    }

    public function delivery_orders()
    {
        $items = $this->saleItemModel
            ->findAll();

        $data = ([
            "items" => $items,
            "db" => $this->db,
        ]);

        return view('owner/delivery_orders', $data);
    }


    public function products_locations()
    {
        $products = $this->productModel->where("trash", 0)->orderBy("name", "asc")->findAll();
        $warehouses = $this->warehouseModel
            ->where("trash", 0)
            ->orderBy("name", "asc")
            ->findAll();

        $categories = $this->productCategoriesModel
            ->where("trash", 0)
            ->orderBy("name", "asc")
            ->findAll();

        $codes = $this->codeModel
            ->where("trash", 0)
            ->orderBy("name", "asc")
            ->findAll();
        $prices = $this->productPriceModel
            ->orderBy("code", "asc")
            ->findAll();

        $data = ([
            "products"  => $products,
            "warehouses"          => $warehouses,
            "categories"          => $categories,
            "codes"          => $codes,
            "prices"          => $prices,
            "db" => $this->db,
        ]);

        return view("owner/product_locations", $data);
    }

    public function products()
    {
        $products = $this->productModel
            ->where("trash", 0)
            ->orderBy("name", "asc")
            ->get()
            ->getResultObject();

        $data = ([
            "db"                => $this->db,
            "products"       => $products,
        ]);

        return view('owner/products', $data);
    }
    public function products_manage($id)
    {
        $product = $this->productModel->where("id", $id)->where("trash", 0)->first();


        $category = $this->productCategoriesModel->where("id", $product->category_id)->first();
        $code = $this->codeModel->where("id", $product->code_id)->first();

        // d($category);

        $categories = $this->productCategoriesModel
            ->where("trash", 0)
            ->orderBy("name", "asc")
            ->findAll();

        $codes = $this->codeModel
            ->where("trash", 0)
            ->orderBy("name", "asc")
            ->findAll();

        $data = ([
            "product"   => $product,
            "thisCategory"   => $category,
            "thisCode"   => $code,
            "categories"   => $categories,
            "codes"   => $codes,
            "db"        => $this->db,
        ]);

        return view("owner/product_manage", $data);
    }

    public function product_price_set($price, $product, $status)
    {
        $this->productPriceModel
            ->where("id", $price)
            ->set([
                "approve_owner_status" => $status,
                "owner_id" => $this->session->login_id,
                "date_owner_approve"   => date("Y-m-d")
            ])->update();

        if ($status == 2) {
            $this->session->setFlashdata('message_type', 'success');
            $this->session->setFlashdata('message_content', 'Harga berhasil disetujui');

            return redirect()->to(base_url('owner/products/' . $product . '/manage'));
        } else {
            $this->session->setFlashdata('message_type', 'success');
            $this->session->setFlashdata('message_content', 'Harga berhasil tidak disetujui');
            return redirect()->to(base_url('owner/products/' . $product . '/manage'));
        }
    }

    public function price_approval()
    {
        $prices = $this->db->table("product_prices");
        $prices->select("product_prices.level as 'price_level'");
        $prices->select("product_prices.percentage as 'price_percentage'");
        $prices->select("products.id as 'product_id'");
        $prices->select("products.name as 'product_name");
        $prices->select("products.price as 'product_price");
        $prices->select("products.sku_number as 'product_sku_number'");
        $prices->select("categories.name as 'code_name'");
        $prices->join("products", "products_prices.product_id=products.id", "left");
        $prices->join("categories','products.categorY_id=categories.id", "left");
        $prices->join("codes", "products.code_id=codes.id", "left");
        $prices->orderBy("product_prices.level", "desc");
        $prices->orderBy("product_prices.date_created", "desc");
        $prices->orderBy("product_prices.id", "desc");
        $prices = $prices->get();
        $prices = $prices->getResultObject();
        $data = ([
            "prices"          => $prices,
        ]);
        return view("owner/price_approval", $data);
    }

    public function getSalesOrder()
    {
        $allow_warehouses = !empty(cek_session($this->session->get('login_id'))['allow_warehouses']) ? cek_session($this->session->get('login_id'))['allow_warehouses'] : '"1","2","3","4","5","6","7","8","9","10"';

        $builder = $this->db->table('sales')
            ->select('sales.id, number, transaction_date, administrators.name as admin_name, contacts.name as contact_name, contacts.phone as contact_phone')
            ->join('administrators', 'sales.admin_id = administrators.id')
            ->join('contacts', 'sales.contact_id = contacts.id')
            ->where("sales.id in(
            select sale_id from sale_items as AA
            inner join product_stocks as BB on AA.id=BB.sale_item_id 
            where BB.warehouse_id in($allow_warehouses)
        )")
            ->where('sales.trash', 0)
            ->orderBy('sales.id', 'desc');

        return DataTable::of($builder)
            ->setSearchableColumns(["sales.number", "sales.transaction_date", "contacts.name", "administrators.name"])
            ->toJson(true);
    }

    public function sales()
    {
        $allow_warehouses = !empty(cek_session($this->session->get('login_id'))['allow_warehouses']) ? cek_session($this->session->get('login_id'))['allow_warehouses'] : '"1","2","3","4","5","6","7","8","9","10"';

        $sales = $this->db->table('sale_items as a');
        $sales->select([
            'b.id',
            'b.transaction_date',
            'e.name as admin_name',
            'c.name as contact_name',
            'b.number as sale_number',
            'f.name as tag_name',
        ]);
        $sales->join('sales as b', 'a.sale_id = b.id', 'left');
        $sales->join('contacts as c', 'b.contact_id = c.id', 'left');
        $sales->join('product_stocks as d', 'a.id = d.sale_item_id', 'left');
        $sales->join('administrators as e', 'b.admin_id = e.id', 'left');
        $sales->join('tags as f', 'b.tags = f.id', 'left');
        $sales->where('b.contact_id !=', NULL);
        $sales->where('b.payment_id !=', NULL);
        $sales->where('b.trash', 0);
        $sales->whereNotIn('d.warehouse_id', [$allow_warehouses]);
        $sales->orderBy('b.transaction_date', 'desc');
        $sales->groupBy('b.id');
        $sales = $sales->get();
        $sales = $sales->getResultObject();

        $data = ([
            'sales' => $sales,
            'db'  => $this->db,
        ]);

        return view('owner/sales', $data);
    }

    public function sales_manage($id)
    {
        $sale = $this->saleModel->where("id", $id)->first();
        $delivery = $this->deliveryModel->where('deliveries.id', $id)->get()->getFirstRow();
        $branch = $this->branchModel->findAll();

        if ($sale == NULL) {
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', 'Data tidak ditemukan');
            return redirect()->to(base_url('dashboard'));
        }

        $locations = $this->locationModel
            ->where("trash", 0)
            ->orderBy("name", "asc")
            ->findAll();

        $contacts = $this->contactModel
            ->where('contacts.name !=', "")
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
            ->where('tags.active', 0)
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
            ->where('contacts.name !=', "")
            ->where("id", $sale->contact_id)
            ->first();

        $warehouses = $this->warehouseModel
            ->where("trash", 0)
            ->orderBy("name", "asc")
            ->findAll();

        $payment = $this->paymentModel
            ->where("id", $sale->payment_id)
            ->first();

        $data = ([
            "db"    => $this->db,
            "contacts"  => $contacts,
            "contact"  => $contact,
            "locations" => $locations,
            "admin"  => $admin,
            "warehouse" => $warehouse,
            "payments" => $payments,
            "tags" => $tags,
            "products" => $products,
            "sale"  => $sale,
            "items" => $items,
            "promos" => $promos,
            "thisContact"   => $contact,
            "payment" => $payment,
            "warehouses"          => $warehouses,
            "delivery" => $delivery,
            "branch" => $branch
        ]);

        if ($sale->status >= 4) {
            return view("owner/sales_manage_fix", $data);
        } else {
            if ($sale->admin_id == $this->session->login_id) {
                return view("owner/sales_own_manage", $data);
            } else {
                if ($sale->contact_id == NULL) {
                    $this->session->setFlashdata('message_type', 'error');
                    $this->session->setFlashdata('message_content', 'Data tidak ditemukan');

                    return redirect()->to(base_url('dashboard'));
                }
                if ($sale->payment_id == NULL) {
                    $this->session->setFlashdata('message_type', 'error');
                    $this->session->setFlashdata('message_content', 'Data tidak ditemukan');

                    return redirect()->to(base_url('dashboard'));
                }
                return view("owner/sales_manage", $data);
            }
        }
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

        return view("owner/target", $data);
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

        return redirect()->to(base_url('owner/target'));
    }

    public function addresses()
    {
        $addresses = $this->addressModel->orderBy("name", "asc")->findAll();
        $data = ([
            "addresses" => $addresses
        ]);
        return view("owner/addresses", $data);
    }

    public function addresses_add()
    {
        $name = $this->request->getPost('name');
        $ip = $this->request->getPost('ip');
        $address = $this->addressModel->where("address", $ip)->first();

        if ($address) {
            $this->session->setFlashdata('message_type', 'warning');
            $this->session->setFlashdata('message_content', 'Alamat IP ' . $ip . ' Sudah Ada');

            return redirect()->to(base_url('owner/addresses'));
        } else {
            $this->addressModel->insert([
                "name"              => $name,
                "address"           => $ip,
                "date_insert"       => date("Y-m-d")
            ]);

            $this->session->setFlashdata('message_type', 'success');
            $this->session->setFlashdata('message_content', 'Alamat IP Berhasil Ditambah');
            return redirect()->to(base_url('owner/addresses'));
        }
    }

    public function addresses_save()
    {
        $id = $this->request->getPost('id');
        $name = $this->request->getPost('name');
        $ip = $this->request->getPost('ip');

        $address = $this->addressModel->where("address", $ip)->first();

        if ($address) {
            $this->addressModel->where("id", $id)->set([
                "name"              => $name,
            ])->update();
            $this->session->setFlashdata('message_type', 'success');
            $this->session->setFlashdata('message_content', 'Alamat IP ' . $ip . ' Berhasil Disimpan');
            return redirect()->to(base_url('owner/addresses'));
        } else {
            $this->addressModel->where("id", $id)->set([
                "name"              => $name,
                "address"           => $ip,
            ])->update();

            $this->session->setFlashdata('message_type', 'success');
            $this->session->setFlashdata('message_content', 'Alamat IP Berhasil Disimpan');
            return redirect()->to(base_url('owner/addresses'));
        }
    }

    public function addresses_delete($id)
    {
        $this->addressModel->delete($id);

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Alamat IP Berhasil Dihapus');

        return redirect()->to(base_url('owner/addresses'));
    }

    public function sales_need_approval()
    {
        $items = $this->saleItemModel
            ->select("sales.id as sale_id")
            // ->select("sales.contact_id")
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
            ->where("sale_items.need_approve >", 0)
            ->where("sale_items.admin_approve_id", 0)
            ->where("sales.status", 1)
            ->where("sales.contact_id !=", NULL)
            ->where("sales.payment_id !=", NULL)
            ->orderBy("sales.transaction_date", "desc")
            ->orderBy("sales.id", "desc")
            ->findAll();

        $data = ([
            "db" => $this->db,
            "items" => $items,
            // "contact_id" => $contact,
        ]);

        return view("owner/sales_need_approval", $data);
    }

    public function sales_item_approve($sale, $item)
    {
        $this->saleItemModel->where("id", $item)
            ->set([
                "approve_status" => 1,
                "need_approve" => 3,
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
        } else {
            $this->saleModel->where("id", $sale)
                ->set(["status" => 1])->update();
        }

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Item berhasil disetujui');
        return redirect()->to(base_url('owner/sales/' . $sale . '/manage'));
    }

    public function sales_item_unapprove($sale, $item)
    {
        $this->saleItemModel->where("id", $item)
            ->set([
                "approve_status" => 2,
                "need_approve" => 3,
                "admin_approve_id" => $this->session->login_id,
                "ready" => 0
            ])->update();

        $this->saleModel->where("id", $sale)
            ->set(["status" => 3])->update();

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Item berhasil tidak disetujui');

        return redirect()->to(base_url('owner/sales/' . $sale . '/manage'));
    }

    public function insentif_karyawan()
    {


        $role = config("App")->roles;

        $data = ([
            "db" => $this->db,
            "insentif" => $this->insentifModel->whereIn("role", [2, 3, 4, 5])->findAll(),
            "sale" => $this->saleItemModel->findAll(),
            "rumus" => $this->productPriceModel->findAll(),
            "role" => $role,
            "validation" => $this->validation,
        ]);

        return view("owner/insentif", $data);
    }

    public function insentif_add()
    {
        $Check = $this->validate([
            "keterangan" => [
                "rules" => "required",
                "errors" => [
                    "required" => "Keterangan Harus Diisi"
                ],
            ],
        ]);

        if (!$Check) {
            return redirect()->back()->withInput();
        }

        $roles = $this->request->getPost("role");
        $harga = $this->request->getPost("price_id");

        if ($harga == "custom") {
            $customIncentive = $this->request->getPost('custom_incentive');
            $incentive = $customIncentive;

            $data = [
                "keterangan" => $this->request->getPost("keterangan"),
                "price_id" => "11",
                "code" => $incentive,
            ];
        } else {
            $rumus = explode("|", $harga);
            $thisPriceId = $rumus[0];
            $thisPriceCode = $rumus[1];

            $data = [
                "keterangan" => $this->request->getPost("keterangan"),
                "price_id" => $thisPriceId,
                "code" => $thisPriceCode,
            ];
        }

        if ($roles == 1) {
            $data["nama"] = "Administrator";
            $data["role"] = $roles;
            $this->insentifModel->insert($data);
        } elseif ($roles == 2) {
            $data["nama"] = "Sales Retail";
            $data["role"] = $roles;
            $this->insentifModel->insert($data);
        } elseif ($roles == 3) {
            $data["nama"] = "Sales Grosir";
            $data["role"] = $roles;
            $this->insentifModel->insert($data);
        } elseif ($roles == 4) {
            $data["nama"] = "Supervisor Retail";
            $data["role"] = $roles;
            $this->insentifModel->insert($data);
        } elseif ($roles == 5) {
            $data["nama"] = "Supervisor Grosir";
            $data["role"] = $roles;

            $this->insentifModel->insert($data);
        } elseif ($roles == 6) {
            $data["nama"] = "Gudang";
            $data["role"] = $roles;
            $this->insentifModel->insert($data);
        } elseif ($roles == 7) {
            $data["nama"] = "Owner";
            $data["role"] = $roles;
            $this->insentifModel->insert($data);
        } elseif ($roles == 8) {
            $data["nama"] = "Audit";
            $data["role"] = $roles;
            $this->insentifModel->insert($data);
        }

        $get = $this->insentifModel->where("role", $roles)->orderBy('id', 'DESC')->first();

        $coba = $get->id;

        return redirect()->to(base_url("owner/insentif/" . $coba . "/manage"));
    }

    public function insentif_manage($id)
    {

        $data = ([
            "insentif" => $this->insentifModel->where("id", $id)->first(),
            "db"    => $this->db,
        ]);

        return view("owner/insentif_manage", $data);
    }

    public function insentif_save()
    {
        $price_id = $this->request->getPost('price_id');
        $id = $this->request->getPost("id");

        if ($price_id != 11) {

            $Check = $this->validate([
                "level_2" => [
                    "rules" => "required",
                    "errors" => [
                        "required" => "Harus Diisi"
                    ],
                ],
                "level_3" => [
                    "rules" => "required",
                    "errors" => [
                        "required" => "Harus Diisi"
                    ],
                ],
                "level_4" => [
                    "rules" => "required",
                    "errors" => [
                        "required" => "Harus Diisi"
                    ],
                ],
                "level_5" => [
                    "rules" => "required",
                    "errors" => [
                        "required" => "Harus Diisi"
                    ],
                ],
                "level_6" => [
                    "rules" => "required",
                    "errors" => [
                        "required" => "Harus Diisi"
                    ],
                ],
                "level_7" => [
                    "rules" => "required",
                    "errors" => [
                        "required" => "Harus Diisi"
                    ],
                ],
                "level_8" => [
                    "rules" => "required",
                    "errors" => [
                        "required" => "Harus Diisi"
                    ],
                ],
                "level_9" => [
                    "rules" => "required",
                    "errors" => [
                        "required" => "Harus Diisi"
                    ],
                ],
                "level_10" => [
                    "rules" => "required",
                    "errors" => [
                        "required" => "Harus Diisi"
                    ],
                ],
            ]);

            if (!$Check) {
                return redirect()->back()->withInput();
            }

            $data = $this->request->getPost([
                "level_2",
                "level_3",
                "level_4",
                "level_5",
                "level_6",
                "level_7",
                "level_8",
                "level_9",
                "level_10"
            ]);
        } else {
            $data = $this->request->getPost([
                "custom_price"
            ]);
        }



        $this->insentifModel->update($id, $data);

        return redirect()->to(base_url("owner/insentif"));
    }

    public function insentif_delete($id)
    {
        $this->insentifModel->delete($id);
        $this->session->setFlashdata("delete", "Data Deleted!");

        return redirect()->to(base_url("owner/insentif"));
    }
}
