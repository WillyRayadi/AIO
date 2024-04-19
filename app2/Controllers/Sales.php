<?php

namespace App\Controllers;

use com_exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

use Hermawan\DataTables\DataTable;

class Sales extends BaseController
{
    protected $session;
    protected $validation;
    protected $db;

    protected $adminModel;

    private $saleReturModel;
    private $saleReturnItemModel;
    private $productCategoriesModel;
    private $alasanModel;
    private $productModel;
    private $deliveryModel;
    private $deliveryItemModel;
    private $productPriceModel;
    private $productStocksModel;
    private $productRepairModel;
    private $productLocationModel;
    private $productStockModel;
    private $codeModel;
    private $customerModel;
    private $contactModel;
    private $warehouseModel;
    private $vehicleModel;
    private $paymentModel;
    private $saleModel;
    private $saleItemModel;
    private $tagModel;
    private $promoModel;
    private $locationModel;
    private $bundlingModel;
    private $saleItemBundlingModel;
    private $warehouseTransferModel;
    private $warehouseTransfersItemsModel;
    private $insentifModel;
    private $teamModel;
    private $pointModel;
    private $branchModel;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->db = \Config\Database::connect();
        $this->validation =  \Config\Services::validation();

        $this->saleReturnItemModel = new \App\Models\saleReturnItem();
        $this->saleReturModel = new \App\Models\saleRetur();
        $this->adminModel = new \App\Models\Administrator();
        $this->alasanModel = new \App\Models\Alasan();
        $this->deliveryModel = new \App\Models\Delivery();
        $this->deliveryItemModel = new \App\Models\DeliveryItem();
        $this->productCategoriesModel = new \App\Models\Category();
        $this->productModel = new \App\Models\Product();
        $this->productPriceModel = new \App\Models\ProductPrice();
        $this->productStocksModel = new \App\Models\Stock();
        $this->productRepairModel = new \App\Models\ProductRepair();
        $this->productLocationModel = new \App\Models\ProductLocation();
        $this->productStockModel = new \App\Models\ProductStock();
        $this->codeModel = new \App\Models\Code();
        $this->customerModel = new \App\Models\Customer();
        $this->contactModel = new \App\Models\Contact();
        $this->warehouseModel = new \App\Models\Warehouse();
        $this->vehicleModel = new \App\Models\Vehicle();
        $this->paymentModel = new \App\Models\PaymentTerm();
        $this->saleModel = new \App\Models\Sale();
        $this->saleItemModel = new \App\Models\SaleItem();
        $this->tagModel = new \App\Models\Tag();
        $this->promoModel = new \App\Models\Promo();
        $this->locationModel = new \App\Models\Location();
        $this->bundlingModel = new \App\Models\Bundling();
        $this->saleItemBundlingModel = new \App\Models\SaleItemBundling();
        $this->warehouseTransferModel = new \App\Models\WarehouseTransfer();
        $this->warehouseTransfersItemsModel = new \App\Models\WarehouseTransfersItems();
        $this->insentifModel = new \App\Models\Insentif();
        $this->teamModel = new \App\Models\Team();
        $this->pointModel = new \App\Models\UserPoint();
        $this->branchModel = new \App\Models\Branch();

        if ($this->session->login_id == null) {
            $this->session->setFlashdata('msg', 'Maaf, Silahkan login terlebih dahulu!');
            header("location:" . base_url('/'));
            exit();
        } else {
            if (config("Login")->loginRole != 1) {
                if (config("Login")->loginRole != 2) {
                    if (config("Login")->loginRole != 3) {
                        if (config("Login")->loginRole != 6) {
                            if (config("Login")->loginRole != 8) {
                                if (config("Login")->loginRole != 7) {
                                    header("location:" . base_url('/dashboard'));
                                    exit();
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function export_activity_approval()
    {
        $tanggalawal = $this->request->getGet('tanggalawal');
        $tanggalakhir = $this->request->getGet('tanggalakhir');

        $sale = $this->saleItemModel
            ->select('sale_items.date as date')
            ->select('sale_items.price')
            ->select('sale_items.price_level')
            ->select('sales.number as sale_number')
            ->select('products.name as product_name')
            ->select('administrators.name as admin_name')
            ->select('sales.transaction_date as transaction_date')
            ->join('sales', 'sale_items.sale_id = sales.id', 'left')
            ->join('products', 'sale_items.product_id = products.id', 'left')
            ->join('administrators', 'sale_items.admin_approve_id = administrators.id', 'left')
            ->orderBy('sale_items.id', 'desc')
            ->where("sale_items.ready", 1)
            ->where("sale_items.need_approve >", 0)
            ->where("sales.transaction_date >=", $tanggalawal)
            ->where("sales.transaction_date <=", $tanggalakhir)
            ->get()
            ->getResultObject();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'AIO Store');
        $sheet->mergeCells('A1:E1');

        $sheet->setCellValue('A2', 'Aktifitas Persetujuan ' . $tanggalawal . " s/d " . $tanggalakhir);
        $sheet->mergeCells('A2:E2');
        $sheet->mergeCells('A3:E3');

        $spreadsheet->getActiveSheet()
            ->getStyle('A1:A2')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $spreadsheet->getActiveSheet()
            ->getStyle('A:E')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $spreadsheet->getActiveSheet()
            ->getStyle("A1:A2")
            ->getFont()
            ->setSize(14);

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue("A4", 'Nama Approve');
        $sheet->setCellValue("B4", 'Nomer Sales Order');
        $sheet->setCellValue("C4", 'Nama Produk');
        $sheet->setCellValue("D4", 'Harga Produk');
        $sheet->setCellValue("E4", 'Waktu Approve');

        $column = 5;
        $no = 1;
        foreach ($sale as $key => $value) {

            $sheet->setCellValue('A' . $column, $value->admin_name);
            $sheet->setCellValue('B' . $column, $value->sale_number);
            $sheet->setCellValue('C' . $column, $value->product_name);
            $sheet->setCellValue('D' . $column, 'Rp.' . number_format($value->price) . ' (' . $value->price_level . ')');
            $sheet->setCellValue('E' . $column, $value->date);

            $column++;
        }

        $sheet->getStyle("A4:E4")->getFont()->setBold(true);
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSIze(true);
        $sheet->getColumnDimension('D')->setAutoSIze(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename=Data Aktifitas Persetujuan.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }

    public function perubahan_status()
    {
        $alasan = $this->alasanModel
            ->select([
                'contacts.name as contact_name',
                'status_so.sale_id as sale_id',
                'sales.number as sale_number',
                'administrators.name as admin_name',
                'status_so.status_awal as status_awal',
                'status_so.alasan_status as alasan',
            ])
            ->join('contacts', 'status_so.contact_id = contacts.id', 'left')
            ->join('sales', 'status_so.sale_id = sales.id', 'left')
            ->join('administrators', 'status_so.admin_id = administrators.id', 'left')
            ->where("sales.id !=", NULL)
            ->where("status_so.admin_id", $this->session->login_id)
            ->orderBy('status_so.id', 'desc')->get()->getResultObject();

        $data = ([
            "alasan" => $alasan,
            "db"    => $this->db,
        ]);
        return view('sales/perubahan_status', $data);
    }

    public function sales_comment_add()
    {
        $alasan_status = $this->request->getPost('alasan_status');
        $sale_id = $this->request->getPost('sale_id');
        $admin_id = $this->request->getPost('admin_id');
        $customer = $this->request->getPost('customer');
        $status = $this->request->getPost('status');
        $harga_edit = $this->request->getPost('harga_edit');
        $qty_edit = $this->request->getPost('qty_edit');
        $product_id = $this->request->getPost('product_id');

        $alasan = $this->alasanModel->orderBy('id', 'desc')->first();

        $this->alasanModel->insert([
            'harga_edit' => $harga_edit,
            'qty_edit'   => $qty_edit,
            'sale_id'    => $sale_id,
            'admin_id'   => $admin_id,
            'status_awal' => $status,
            'need_approve' => 3,
            'admin_approve_id' => 9,
            "product_id"  => $product_id,
            'contact_id'  => $customer,
            'alasan_status' => $alasan_status,
        ]);

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Perubahan berhasil diterapkan');

        return redirect()->to(base_url('sales/sales/' . $sale_id . '/manage'));
    }

    public function sales_return()
    {
        $warehouses = $this->warehouseModel->where('warehouses.trash', 0)->orderBy('warehouses.name')->get()->getFirstRow();

        $getReturnSales = [$this->session->login_id, "104"];

        $stocks = $this->saleReturModel
            ->select([
                'return_sales.id',
                'return_sales.date',
                'sales.id as sale_id',
                'sales.contact_id',
                'return_sales.number as retur_number',
                'return_sales.alasan',
                'sales.number as sale_number',
            ])
            ->join('sales', 'return_sales.sale_id = sales.id', 'left')
            ->where('sales.admin_id', $this->session->login_id)
            ->orderBy('return_sales.id', 'desc')
            ->get()->getResultObject();

        $sales = $this->saleModel
            ->where('admin_id', $this->session->login_id)
            ->where("status >=", 4)
            ->orderBy('sales.id', 'desc')
            ->get()->getResultObject();

        $data = ([
            "sales" => $sales,
            "stocks" => $stocks,
            "warehouses" => $warehouses,
        ]);

        return view('sales/sale_return', $data);
    }

    public function sales_return_add()
    {
        $sales_retur = $this->db->table('return_sales');
        $sales_retur->selectMax('id');
        $sales_retur = $sales_retur->get();
        $sales_retur = $sales_retur->getFirstRow();

        $sales_retur = $sales_retur->id;
        $id = $sales_retur + 1;
        $number_retur = "SR/" . date("y") . "/" . $id;

        $date = $this->request->getPost('date');
        $alasan = $this->request->getPost('alasan');
        $sale_id = $this->request->getPost('sale_id');

        $this->saleReturModel->insert([
            'date' => $date,
            'alasan' => $alasan,
            'sale_id' => $sale_id,
            'number' => $number_retur,
            'admin_id' => $this->session->login_id,
        ]);

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', "Data Retur Berhasil Ditambahkan");

        return redirect()->to(base_url('sales/sale/retur'));
    }

    public function sales_return_manage($id)
    {
        $data_retur = $this->saleReturModel->where(['return_sales.id' => $id])->first();

        if ($data_retur != NULL) {
            $goods = $this->productModel->where('trash', 0)->orderBy('products.name', 'asc')->findAll();
            $warehouses = $this->warehouseModel->where('trash', 0)->orderBy('warehouses.name', 'asc')->findAll();

            $good_retur = $this->saleReturModel
                ->select([
                    'return_sales.id',
                    'sales.contact_id', 'alasan',
                    'sales.number as sales_number',
                    'return_sales.date as retur_date',
                    'administrators.name as admin_name',
                    'return_sales.number as retur_number',
                ])
                ->join('sales', 'return_sales.sale_id = sales.id', 'left')
                ->join('administrators', 'return_sales.admin_id = administrators.id', 'left')
                ->where('return_sales.id', $id)->get()->getFirstRow();

            $sales = $this->saleModel->orderBy('sales.id', 'desc')->get()->getFirstRow();

            $items = $this->saleItemModel
                ->select([
                    'sale_items.id',
                    'sale_items.quantity',
                    'sale_items.product_id',
                    'products.name as product_name',
                ])
                ->join('products', 'sale_items.product_id = products.id', 'left')
                ->where('sale_items.sale_id', $data_retur->sale_id)
                ->orderBy('sale_items.id', 'desc')->get()->getResultObject();

            $retur_item = $this->saleReturnItemModel
                ->select([
                    'return_item.id',
                    'return_item.quantity',
                    'return_item.retur_id',
                    'return_item.sale_item_id',
                    'products.name as product_name',
                    'warehouses.name as warehouse_name',
                ])
                ->join('products', 'return_item.product_id = products.id', 'left')
                ->join('warehouses', 'return_item.warehouse_id = warehouses.id', 'left')
                ->where('return_item.retur_id', $id)
                ->get()->getResultObject();

            $data = ([
                'db' => $this->db,
                'goods' => $goods,
                'warehouses' => $warehouses,
                'good_retur' => $good_retur,
                'sales' => $sales,
                'items' => $items,
                'retur_item' => $retur_item,
            ]);

            return view('sales/return_manage', $data);
        } else {
            $this->session->setFlashdata('message_type', 'success');
            $this->session->setFlashdata('message_content', 'Data tidak ditemukan');
            return redirect()->to(base_url('sales/sale/retur'));
        }
    }

    public function sales_return_add_items()
    {
        $date = $this->request->getPost('date');
        $retur_id = $this->request->getPost('retur_id');
        $sale_item_id = $this->request->getPost('sale_item_id');
        $quantity = $this->request->getPost('quantity');
        $warehouses = $this->request->getPost('warehouses');

        $saleItems = $this->saleItemModel->where('sale_items.id', $sale_item_id)->get()->getFirstRow();

        $this->saleReturnItemModel->insert([
            'quantity'   => $quantity,
            'retur_id'   => $retur_id,
            'warehouse_id' => $warehouses,
            'sale_item_id' => $sale_item_id,
            'product_id' => $saleItems->product_id,
        ]);

        $returID = $this->saleReturnItemModel->getInsertID();

        $this->productStockModel->insert([
            'date' => $date,
            'product_id' => $saleItems->product_id,
            'quantity'  => $quantity,
            'product_return_id' => $returID,
            "warehouse_id" => $warehouses,
        ]);

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data berhasil ditambahkan');

        return redirect()->to(base_url('sales/sale/retur/manage') . '/' . $retur_id);
    }


    public function sales_retur_print($good_retur)
    {
        $data_returs = $this->saleReturModel
            ->select([
                'return_sales.admin_id', 'return_sales.date',
                'sales.number as sale_number', 'alasan',
                'return_sales.number as retur_number',
                'return_sales.admin_id', 'sales.contact_id'
            ])
            ->join('sales', 'return_sales.sale_id = sales.id', 'left')
            ->where('return_sales.id', $good_retur)->get()->getFirstRow();

        $item_returs = $this->saleReturnItemModel
            ->select(['return_item.sale_item_id', 'products.name as product_name', 'return_item.quantity', 'warehouses.name as warehouse_name'])
            ->join('products', 'return_item.product_id = products.id', 'left')
            ->join('warehouses', 'return_item.warehouse_id = warehouses.id', 'left')
            ->where('return_item.retur_id', $good_retur)
            ->get()->getResultObject();

        $administrator = $this->adminModel->where('administrators.id', $data_returs->admin_id)->first();
        $contacts = $this->contactModel->where('contacts.id', $data_returs->contact_id)->first();

        $data = ([
            'db' => $this->db,
            'contacts'  => $contacts,
            'data_returs' => $data_returs,
            'item_returs' => $item_returs,
            'administrator' => $administrator,
        ]);

        return view('sales/retur_print', $data);
    }

    public function sales_return_delete_items($id, $items)
    {
        $goodReturItem = $this->saleReturnItemModel->find($items);

        if ($goodReturItem) {
            $this->saleReturnItemModel->where('return_item.id', $items)->delete();
            $this->productStockModel->where('product_return_id', $items)->delete();

            $this->session->setFlashdata('message_type', 'success');
            $this->session->setFlashdata('message_content', 'Produk Berhasil Di Hapus');

            return redirect()->to(base_url('sales/sale/retur/manage/' . $id));
        } else {
            $this->session->setFlashdata('message_type', 'success');
            $this->session->setFlashdata('message_content', 'Produk gagal dihapus');

            return redirect()->to(base_url('sales/sale/retur/manage/' . $id));
        }
    }

    public function sales_return_delete($id)
    {
        $items = $this->saleReturnItemModel
            ->where("retur_id", $id)
            ->findAll();

        foreach ($items as $item) {
            $this->saleReturnItemModel->where("id", $item->id)->delete();
            $this->productStockModel->where("product_return_id", $item->id)->delete();
        }

        $this->saleReturModel->delete($id);
        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Retur berhasil dihapus');

        return redirect()->to(base_url('sales/sale/retur/'));
    }

    public function products_transfers()
    {
        $data_transfers = $this->warehouseTransferModel
            ->where('admin_id', $this->session->login_id)
            ->orderBy('warehouse_transfers.id', 'desc')
            ->findAll();

        $warehouses = $this->warehouseModel->where("trash", 0)->orderBy("warehouses.name", "asc")->findAll();

        $admins = $this->adminModel
            ->where("role >=", 2)
            ->where("role <=", 3)
            ->where("active !=", 0)
            ->orderBy("administrators.name", "asc")
            ->findAll();

        $data = ([
            'db' => $this->db,
            'warehouses'  => $warehouses,
            'admins'   => $admins,
            'data_transfers' => $data_transfers,
        ]);

        return view('sales/products_transfers', $data);
    }

    public function products_transfers_insert_data_awal()
    {
        $data_transfers_awal = $this->db->table('warehouse_transfers');
        $data_transfers_awal->selectMax('id');
        $data_transfers_awal = $data_transfers_awal->get();
        $data_transfers_awal = $data_transfers_awal->getFirstRow();

        $data_transfers_awal = $data_transfers_awal->id;

        $no_doc = $data_transfers_awal + 1;

        $number_document = "TF/" . date("y") . "/" . date("m") . "/" . $no_doc;

        $date = $this->request->getPost('date');
        $number = $this->request->getPost('number');
        $details = $this->request->getPost('details');
        $admin_id = $this->request->getPost('admin_id');
        $to_warehouse = $this->request->getPost('to_warehouse');
        $from_warehouse = $this->request->getPost('from_warehouse');

        $this->warehouseTransferModel->insert([
            "date"  => $date,
            "number"   => $number_document,
            "details"  => $details,
            "admin_id" => $admin_id,
            "warehouse_to_id" => $to_warehouse,
            "warehouse_from_id" => $from_warehouse,
        ]);

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data transfer barang berhasil ditambah');

        return redirect()->to(base_url('sales/products_transfers'));
    }

    public function products_transfers_items()
    {
        $date = $this->request->getPost('date');
        $details = $this->request->getPost('details');
        $quantity = $this->request->getPost('quantity');
        $product_id = $this->request->getPost('product_id');
        $to_warehouse = $this->request->getPost('to_warehouse');
        $from_warehouse = $this->request->getPost('from_warehouse');
        $warehouse_transfers_id = $this->request->getPost('warehouse_transfers_id');

        $goodTransfers = $this->warehouseTransferModel->where(['id' => $warehouse_transfers_id])->first();
        $goodData = $this->productModel->where(['id' => $product_id])->first();

        $this->warehouseTransfersItemsModel
            ->insert([
                'quantity' => $quantity,
                'product_id' => $product_id,
                'warehouse_transfers_id' => $warehouse_transfers_id,
            ]);

        $idGoodItem = $this->warehouseTransfersItemsModel->getInsertID();

        $this->productStockModel
            ->insert([
                'date' => $date,
                'details' => $details,
                'product_id' => $product_id,
                'quantity' => (0 - $quantity),
                'warehouse_id' => $from_warehouse,
                'warehouse_transfer_id' => $idGoodItem,
            ]);

        $this->productStockModel
            ->insert([
                'date' => $date,
                'details' => $details,
                'quantity' => $quantity,
                'product_id' => $product_id,
                'warehouse_id' => $to_warehouse,
                'warehouse_transfer_id' => $idGoodItem,
            ]);

        $stockGood = $this->productModel->where(['id' => $product_id])->first();

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data <b>' . $stockGood->name . '</b> berhasil ditambahkan');
        return redirect()->to(base_url('sales/product_transfers_manage') . '/' . $warehouse_transfers_id);
    }

    public function product_transfers_manage($warehouse_transfers_id)
    {
        $data_transfers = $this->warehouseTransferModel->get()->getFirstRow();

        $admins = $this->adminModel
            ->where("role >=", 2)
            ->where("role <=", 3)
            ->where("active !=", 0)
            ->orderBy("administrators.name", "asc")
            ->findAll();

        $users = $this->adminModel->select(["id", "role"])->where("id", $this->session->login_id)->first();

        if ($data_transfers != NULL) {
            $goods = $this->productModel->where(['trash' => 0])->orderBy('name', 'asc')->findAll();
            $warehouses = $this->warehouseModel->where('trash', 0)->orderBy('warehouses.name', 'desc')->findAll();

            $good_transfers = $this->warehouseTransferModel
                ->join('administrators', 'warehouse_transfers.admin_id = administrators.id', 'left')
                ->select([
                    'warehouse_transfers.id as id',
                    'warehouse_transfers.admin_id',
                    'warehouse_transfers.date as date',
                    'administrators.name as admin_name',
                    'warehouse_transfers.number as number',
                    'warehouse_transfers.details as details',
                    'warehouse_transfers.warehouse_to_id as warehouse_to_id',
                    'warehouse_transfers.warehouse_from_id as warehouse_from_id',
                ])

                ->where('warehouse_transfers.id', $warehouse_transfers_id)
                ->get()->getFirstRow();

            $good_transfers_items = $this->warehouseTransfersItemsModel
                ->join('products', 'warehouse_transfers_items.product_id = products.id', 'left')
                ->select([
                    'warehouse_transfers_items.id',
                    'products.name as product_name',
                    'warehouse_transfers_items.quantity',
                    'warehouse_transfers_items.warehouse_transfers_id',
                ])
                ->where('warehouse_transfers_id', $warehouse_transfers_id)
                ->get()->getResultObject();

            $data = ([
                'products' => $goods,
                'db'    => $this->db,
                'admins'   => $admins,
                'warehouses'    => $warehouses,
                'users' => $users,
                'good_transfers' => $good_transfers,
                'data_transfers' => $data_transfers,
                'good_transfers_items' => $good_transfers_items,
            ]);

            return view('sales/product_transfers_manage', $data);
        } else {
            $this->session->setFlashdata('message_type', 'warning');
            $this->session->setFlashdata('message_content', 'Data Tidak Ditemukan');
            return redirect()->to(base_url('sales/products_transfers'));
        }
    }

    public function product_transfers_edit()
    {
        $transfer_id = $this->request->getPost('transfer_id');
        $number = $this->request->getPost('number');

        $admin_id = $this->request->getPost('admin_id');
        $date = $this->request->getPost('date');
        $details = $this->request->getPost('details');

        $data = [
            'admin_id' => $admin_id,
            'date' => $date,
            'details' => $details,
        ];

        $this->warehouseTransferModel->update($transfer_id,  $data);
        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_title', 'Success');
        $this->session->setFlashdata('message_content', 'Data dokumen <b>' . $number . '</b> berhasil diubah');
        return redirect()->to(base_url('sales/product_transfers_manage') . '/' . $transfer_id);
        // dd($_POST);
    }

    public function product_transfers_delete_items($id, $warehouse_items)
    {
        $goodTransfersItems = $this->warehouseTransfersItemsModel->find($warehouse_items);

        if ($goodTransfersItems) {
            $this->warehouseTransfersItemsModel->delete($warehouse_items);
            $this->session->setFlashdata('message_type', 'success');
            $this->session->setFlashdata('message_content', 'Data berhasil dihapus');
            $this->productStockModel->where("warehouse_transfer_id", $warehouse_items)->delete();
            return redirect()->to(base_url('products/transfers/manage/' . $id));
        } else {
            $this->session->setFlashdata('message_type', 'danger');
            $this->session->setFlashdata('message_content', 'Data gagal dihapus');
            return redirect()->to(base_url('products/transfers/manage/' . $id));
        }
    }

    public function delivery_orders()
    {
        $sales = $this->saleModel
            ->select([
                'sales.id',
                'sales.status',
                'sales.admin_id',
                'sales.contact_id',
                'sales.number as sale_number',
                'locations.name as location_name',
                'sales.transaction_date as sale_transaction',
            ])
            ->join('locations', 'sales.location_id = locations.id', 'left')
            ->join('administrators', 'sales.admin_id = administrators.id', 'left')
            ->where('administrators.role', config("Login")->loginRole = 3)
            ->where("contact_id !=", NULL)
            ->where("payment_id !=", NULL)
            ->where("status <=", 5)
            ->where("status >=", 4)
            ->where('is_saved', 1)
            ->orderBy("transaction_date", "desc")
            ->orderBy("id", "desc")->findAll();

        $data = ([
            "sales" => $sales,
            "db"    => $this->db,
        ]);

        return view('sales/delivery_orders', $data);
    }

    public function delivery_order_manage($id)
    {
        $sale = $this->saleModel->where("id", $id)->first();

        if ($sale == NULL) {
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', 'Data tidak ditemukan');

            return redirect()->to(base_url('dashboard'));
        }

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

        if ($sale->is_saved == 0) {
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', 'Data penjualan belum disimpan');

            return redirect()->to(base_url('dashboard'));
        }

        $contact = $this->contactModel
            ->where("id", $sale->contact_id)
            ->first();

        $warehouse = $this->warehouseModel
            ->where("id", $sale->warehouse_id)
            ->first();

        $payment = $this->paymentModel
            ->where("id", $sale->payment_id)
            ->first();

        $vehicles = $this->vehicleModel
            ->where("trash", 0)
            ->orderBy("brand", "asc")
            ->findAll();

        $items = $this->saleItemModel
            ->where("sale_id", $id)
            ->findAll();

        $admin = $this->adminModel
            ->where("id", $sale->admin_id)
            ->first();

        $deliveries = $this->deliveryModel
            ->where("sale_id", $id)
            ->orderBy("sent_date", "desc")
            ->orderBy("id", "desc")
            ->findAll();

        $saleItem = $this->saleItemModel
            ->orderBy('id', 'desc')
            ->first();

        $stocks = $this->saleItemModel
            ->selectSum('product_stocks.quantity')
            ->join('sales', 'sale_items.sale_id = sales.id', 'left')
            ->join('product_stocks', 'sale_items.id = product_stocks.sale_item_id', 'left')
            ->get()->getFirstRow();

        $data = ([
            "db"    => $this->db,
            "contact"  => $contact,
            "admin"  => $admin,
            "warehouse" => $warehouse,
            "payment" => $payment,
            "sale"  => $sale,
            "items" => $items,
            "vehicles" => $vehicles,
            "deliveries" => $deliveries,
            "saleItem" => $saleItem,
            "stocks" => $stocks,
        ]);

        return view("sales/delivery_manage", $data);
    }

    public function status_approve()
    {
        $sales = $this->saleModel
            ->select([
                'sales.id',
                'sales.status',
                'sales.admin_id',
                'sales.contact_id',
                'sales.number as sale_number',
                'locations.name as location_name',
                'sales.transaction_date as sale_transaction',
            ])
            ->join('locations', 'sales.location_id = locations.id', 'left')
            ->join('administrators', 'sales.admin_id = administrators.id', 'left')
            ->where("sales.admin_id", $this->session->login_id)
            ->where("contact_id !=", NULL)
            ->where("payment_id !=", NULL)
            ->where('sales.status', 2)
            ->orderBy("transaction_date", "desc")
            ->orderBy("id", "desc")->findAll();

        $data = ([
            "sales" => $sales,
            "db"    => $this->db,
        ]);

        return view('sales/status_approve', $data);
    }

    public function status_dikirim_sebagian()
    {
        $sales = $this->saleModel
            ->select([
                'sales.id',
                'sales.status',
                'sales.admin_id',
                'sales.contact_id',
                'sales.number as sale_number',
                'locations.name as location_name',
                'sales.transaction_date as sale_transaction',
            ])
            ->join('locations', 'sales.location_id = locations.id', 'left')
            ->join('administrators', 'sales.admin_id = administrators.id', 'left')
            ->where('sales.admin_id', $this->session->login_id)
            ->where("contact_id !=", NULL)
            ->where("payment_id !=", NULL)
            ->where('sales.status', 4)
            ->orderBy("transaction_date", "desc")
            ->orderBy("id", "desc")->findAll();

        $data = ([
            "sales" => $sales,
            "db"    => $this->db,
        ]);

        return view('sales/sales_dikirim_sebagian', $data);
    }

    public function status_dikirim()
    {
        $sales = $this->saleModel
            ->select([
                'sales.id',
                'sales.status',
                'sales.admin_id',
                'sales.contact_id',
                'sales.number as sale_number',
                'locations.name as location_name',
                'sales.transaction_date as sale_transaction',
            ])
            ->join('locations', 'sales.location_id = locations.id', 'left')
            ->join('administrators', 'sales.admin_id = administrators.id', 'left')
            ->where('sales.admin_id', $this->session->login_id)
            ->where("contact_id !=", NULL)
            ->where("payment_id !=", NULL)
            ->where('sales.status', 5)
            ->orderBy("transaction_date", "desc")
            ->orderBy("id", "desc")->findAll();

        $data = ([
            "sales" => $sales,
            "db"    => $this->db,
        ]);

        return view('sales/sales_dikirim', $data);
    }

    public function status_selesai()
    {
        $sales = $this->saleModel
            ->select([
                'sales.id',
                'sales.status',
                'sales.admin_id',
                'sales.contact_id',
                'sales.number as sale_number',
                'locations.name as location_name',
                'sales.transaction_date as sale_transaction',
            ])
            ->join('locations', 'sales.location_id = locations.id', 'left')
            ->join('administrators', 'sales.admin_id = administrators.id', 'left')
            ->where('sales.admin_id', $this->session->login_id)
            ->where("contact_id !=", NULL)
            ->where("payment_id !=", NULL)
            ->where('sales.status', 6)
            ->orderBy("transaction_date", "desc")
            ->orderBy("id", "desc")->findAll();

        $data = ([
            "sales" => $sales,
            "db"    => $this->db,
        ]);

        return view('sales/sales_selesai', $data);
    }

    public function export_penggunaan_harga()
    {
        $tanggalawal = $this->request->getGet('tanggalawal');
        $tanggalakhir = $this->request->getGet('tanggalakhir');

        $admins = $this->adminModel
            ->where('role >=', 2)
            ->where('role <=', 3)
            ->where('active !=', 0)
            ->orderBy('name', 'asc')
            ->get()
            ->getResultObject();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Data Penggunaan Harga ' . $tanggalawal . " s/d " . $tanggalakhir);
        $sheet->mergeCells('A1:K1');

        $spreadsheet->getActiveSheet()
            ->getStyle('A1')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $spreadsheet->getActiveSheet()
            ->getStyle('A1')
            ->getFont()
            ->setSize(14);

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A2', 'Nama Sales');
        $sheet->setCellValue('B2', 'Harga Ke-2');
        $sheet->setCellValue('C2', 'Harga Ke-3');
        $sheet->setCellValue('D2', 'Harga Ke-4');
        $sheet->setCellValue('E2', 'Harga Ke-5');
        $sheet->setCellValue('F2', 'Harga Ke-6');
        $sheet->setCellValue('G2', 'Harga Ke-7');
        $sheet->setCellValue('H2', 'Harga Ke-8');
        $sheet->setCellValue('I2', 'Harga Ke-9');
        $sheet->setCellValue('J2', 'Harga Ke-10');
        $sheet->setCellValue('K2', 'Harga Ke-11');

        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('B2')->getFont()->setBold(true);
        $sheet->getStyle('C2')->getFont()->setBold(true);
        $sheet->getStyle('D2')->getFont()->setBold(true);
        $sheet->getStyle('E2')->getFont()->setBold(true);
        $sheet->getStyle('F2')->getFont()->setBold(true);
        $sheet->getStyle('G2')->getFont()->setBold(true);
        $sheet->getStyle('H2')->getFont()->setBold(true);
        $sheet->getStyle('I2')->getFont()->setBold(true);
        $sheet->getStyle('J2')->getFont()->setBold(true);
        $sheet->getStyle('K2')->getFont()->setBold(true);

        $column = 3;
        foreach ($admins as $admin) {

            $sheet->setCellValue('A' . $column, $admin->name);
            $colomn_abjad = ['B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K'];

            $start_level = 2;
            for ($start_level; $start_level <= 11; $start_level++) {

                $price_level_data = $this->db->table('sales')
                    ->select('administrators.name,sale_items.price_level,count(sale_items.price_level) as jumlahLevel')
                    ->join('sale_items', 'sales.id=sale_items.sale_id', 'left')
                    ->join('administrators', 'administrators.id=sales.admin_id', 'left')
                    ->where(['sale_items.price_level' => $start_level, 'sales.admin_id' => $admin->id])
                    ->where('transaction_date >=', $tanggalawal)
                    ->where('transaction_date <=', $tanggalakhir)
                    ->groupBy('administrators.name,sale_items.price_level')->get();

                if ($price_level_data->getNumRows() > 0) {
                    $jumlahLevel = $price_level_data->getRow()->jumlahLevel;
                } else {
                    $jumlahLevel = '0';
                }

                $colomn_abjad_no = $start_level - 2;
                $col_no = $colomn_abjad[$colomn_abjad_no] . $column;

                $sheet->setCellValue($col_no, $jumlahLevel);
            }

            $column++;
        }

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);
        $sheet->getColumnDimension('J')->setAutoSize(true);
        $sheet->getColumnDimension('k')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename=Data Penggunaan Harga.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }

    public function export_selesai()
    {
        $tanggalawal = $this->request->getGet('tanggalawal');
        $tanggalakhir = $this->request->getGet('tanggalakhir');
        $sale = $this->saleModel
            ->select('sales.id as sales_id')
            ->select('sales.number as sales_number')
            ->select('sales.transaction_date as sales_date')
            ->select('administrators.name as sales_admin')
            ->select('sales.status as orderStatuses')
            ->select('sales.transaction_date as transaction_date')
            ->select('sales.expired_date as expired_date')
            ->select('sales.tags as tags')
            ->select('contacts.name as contact_name')
            ->join('administrators', 'sales.admin_id=administrators.id', 'left')
            ->join("contacts", "sales.contact_id=contacts.id", "left")
            ->where("sales.id !=", NULL)
            ->where("sales.number !=", NULL)
            ->where("sales.contact_id !=", NULL)
            ->where("sales.status", 6)
            ->where("transaction_date >=", $tanggalawal)
            ->where("expired_date <=", $tanggalakhir)
            ->orderBy('sales.id', 'desc')
            ->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Data Penjualan Yang Telah Selesai');
        $sheet->mergeCells('A1:F1');
        $spreadsheet->getActiveSheet()
            ->getStyle('A1')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $spreadsheet->getActiveSheet()
            ->getStyle('A1')
            ->getFont()
            ->setSize(14);

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A2', 'Nomer SO');
        $sheet->setCellValue('B2', 'Tanggal SO');
        $sheet->setCellValue('C2', "Nama Sales");
        $sheet->setCellValue('D2', "Nama Pelanggan");
        $sheet->setCellValue('E2', 'Status');
        $sheet->setCellValue('F2', 'Tag');

        $column = 3;
        foreach ($sale as $key => $value) {
            $sheet->setCellValue('A' . $column, $value->sales_number);
            $sheet->setCellValue('B' . $column, $value->transaction_date);
            $sheet->setCellValue('C' . $column, $value->sales_admin);
            $sheet->setCellValue('D' . $column, $value->contact_name);
            $sheet->setCellValue('E' . $column, config("App")->orderStatuses[$value->orderStatuses]);
            $sheet->setCellValue('F' . $column, $value->tags);
            $column++;
        }

        $sheet->getStyle('A2:F2')->getFont()->setBold(true);

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename=DatastatusSO_selesai.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }


    public function export_kirim()
    {
        $tanggalawal = $this->request->getGet('tanggalawal');
        $tanggalakhir = $this->request->getGet('tanggalakhir');
        $sale = $this->saleModel
            ->select('sales.id as sales_id')
            ->select('sales.number as sales_number')
            ->select('sales.transaction_date as sales_date')
            ->select('administrators.name as sales_admin')
            ->select('sales.status as orderStatuses')
            ->select('sales.transaction_date as transaction_date')
            ->select('sales.expired_date as expired_date')
            ->select('sales.tags as tags')
            ->select('contacts.name as contact_name')
            ->join('administrators', 'sales.admin_id=administrators.id', 'left')
            ->join("contacts", "sales.contact_id=contacts.id", "left")
            ->where("sales.id !=", NULL)
            ->where("sales.number !=", NULL)
            ->where("sales.contact_id !=", NULL)
            ->where("sales.status", 4)
            ->where("transaction_date >=", $tanggalawal)
            ->where("expired_date <=", $tanggalakhir)
            ->orderBy('sales.id', 'desc')
            ->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Data Penjualan Yang Sedang Dikirim');
        $sheet->mergeCells('A1:F1');
        $spreadsheet->getActiveSheet()
            ->getStyle('A1')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $spreadsheet->getActiveSheet()
            ->getStyle('A1')
            ->getFont()
            ->setSize(14);

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A2', 'Nomer SO');
        $sheet->setCellValue('B2', 'Tanggal SO');
        $sheet->setCellValue('C2', "Nama Sales");
        $sheet->setCellValue('D2', "Nama Pelanggan");
        $sheet->setCellValue('E2', 'Status');
        $sheet->setCellValue('F2', 'Tag');

        $column = 3;
        foreach ($sale as $key => $value) {
            $sheet->setCellValue('A' . $column, $value->sales_number);
            $sheet->setCellValue('B' . $column, $value->transaction_date);
            $sheet->setCellValue('C' . $column, $value->sales_admin);
            $sheet->setCellValue('D' . $column, $value->contact_name);
            $sheet->setCellValue('E' . $column, config("App")->orderStatuses[$value->orderStatuses]);
            $sheet->setCellValue('F' . $column, $value->tags);
            $column++;
        }

        $sheet->getStyle('A2:F2')->getFont()->setBold(true);

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename=DatastatusSO_dikirim.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }

    public function export_status()
    {
        $status = $this->request->getVar("status");
        $tanggalawal = $this->request->getGet('tanggalawal');
        $tanggalakhir = $this->request->getGet('tanggalakhir');
        $sale = $this->saleModel
            ->select('sales.id as sales_id')
            ->select('sales.number as sales_number')
            ->select('sales.transaction_date as sales_date')
            ->select('administrators.name as sales_admin')
            ->select('sales.status as orderStatuses')
            ->select('sales.transaction_date as transaction_date')
            ->select('sales.expired_date as expired_date')
            ->select('sales.tags as tags')
            ->select('contacts.name as contact_name')
            ->join('administrators', 'sales.admin_id=administrators.id', 'left')
            ->join("contacts", "sales.contact_id=contacts.id", "left")
            ->where("sales.id !=", NULL)
            ->where("sales.number !=", NULL)
            ->where("sales.contact_id !=", NULL)
            ->where("sales.status", $status)
            ->where("transaction_date >=", $tanggalawal)
            ->where("expired_date <=", $tanggalakhir)
            ->orderBy('sales.id', 'desc')
            ->findAll();

        if ($status == "2") {
            $fileName = "Disetujui";
        } elseif ($status == "4") {
            $fileName = "Dikirim Sebagian";
        } elseif ($status == "5") {
            $fileName = "Dikirim";
        } elseif ($status == "6") {
            $fileName = "Selesai";
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Data Penjualan Yang Telah ' . $fileName);
        $sheet->mergeCells('A1:F1');
        $spreadsheet->getActiveSheet()
            ->getStyle('A1')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $spreadsheet->getActiveSheet()
            ->getStyle('A1')
            ->getFont()
            ->setSize(14);

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A2', 'Nomer SO');
        $sheet->setCellValue('B2', 'Tanggal SO');
        $sheet->setCellValue('C2', "Nama Sales");
        $sheet->setCellValue('D2', "Nama Pelanggan");
        $sheet->setCellValue('E2', 'Status');
        $sheet->setCellValue('F2', 'Tag');

        $column = 3;
        foreach ($sale as $key => $value) {
            $sheet->setCellValue('A' . $column, $value->sales_number);
            $sheet->setCellValue('B' . $column, $value->transaction_date);
            $sheet->setCellValue('C' . $column, $value->sales_admin);
            $sheet->setCellValue('D' . $column, $value->contact_name);
            $sheet->setCellValue('E' . $column, config("App")->orderStatuses[$value->orderStatuses]);
            $sheet->setCellValue('F' . $column, $value->tags);
            $column++;
        }

        $sheet->getStyle('A2:F2')->getFont()->setBold(true);

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);


        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename=DatastatusSO_' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }


    public function export_id()
    {
        $adminname = $this->request->getGet('adminname');
        $role = $this->request->getGet("role");
        $tanggalawal = $this->request->getGet('tanggalawal');
        $tanggalakhir = $this->request->getGet('tanggalakhir');

        $sale = $this->saleModel
            ->select('sales.id as sales_id')
            ->select('sales.number as sales_number')
            ->select('sales.transaction_date as sales_date')
            ->select('administrators.name as sales_admin')
            ->select('sales.status as orderStatuses')
            ->select('sales.transaction_date as transaction_date')
            ->select('sales.expired_date as expired_date')
            ->select('sales.tags as tags')
            ->select('contacts.name as contact_name')
            ->join('administrators', 'sales.admin_id=administrators.id', 'left')
            ->join("contacts", "sales.contact_id=contacts.id", "left")
            ->where("sales.id !=", NULL)
            ->where("sales.number !=", NULL)
            ->where("sales.contact_id !=", NULL)
            ->where("transaction_date >=", $tanggalawal)
            ->where("expired_date <=", $tanggalakhir);

        if (!empty($role) && $role != "Pilih Role") {
            $sale->where("administrators.role", $role);
        }

        if (!empty($adminname) && $adminname != "Pilih Sales") {
            $admin = $this->adminModel->where("name", $adminname)->first();
            if ($admin != NULL) {
                $sale->where("sales.admin_id", $admin->id);
            }
        }

        $sale = $sale->orderBy('sales.id', 'desc');
        $sale = $sale->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Data Penjualan Per Sales');
        $sheet->mergeCells('A1:F1');
        $spreadsheet->getActiveSheet()
            ->getStyle('A1')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $spreadsheet->getActiveSheet()
            ->getStyle('A1')
            ->getFont()
            ->setSize(14);
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A2', 'Nomer SO');
        $sheet->setCellValue('B2', 'Tanggal SO');
        $sheet->setCellValue('C2', "Nama Sales");
        $sheet->setCellValue('D2', "Nama Pelanggan");
        $sheet->setCellValue('E2', 'Status');
        $sheet->setCellValue('F2', 'Tag');

        $column = 3;
        foreach ($sale as $key => $value) {
            $sheet->setCellValue('A' . $column, $value->sales_number);
            $sheet->setCellValue('B' . $column, $value->transaction_date);
            $sheet->setCellValue('C' . $column, $value->sales_admin);
            $sheet->setCellValue('D' . $column, $value->contact_name);
            $sheet->setCellValue('E' . $column, config("App")->orderStatuses[$value->orderStatuses]);
            $sheet->setCellValue('F' . $column, $value->tags);
            $column++;
        }

        $sheet->getStyle('A2:F2')->getFont()->setBold(true);

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename=DataSO.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }

    public function export()
    {
        $tanggalawal = $this->request->getGet('tanggalawal');
        $tanggalakhir = $this->request->getGet('tanggalakhir');

        $sale = $this->db->table('sale_items');
        $sale->select([
            'sales.number as sales_number',
            'administrators.name as sales_admin',
            'sales.status as orderStatuses',
            'sales.transaction_date as transaction_date',
            'sales.expired_date as expired_date',
            'sales.tags as tags',
            'contacts.name as contact_name',
            'products.name as product_name',
            'sale_items.price as sale_price',
            'sale_items.quantity as sale_qty',
        ]);
        $sale->join('products', 'sale_items.product_id = products.id', 'left');
        $sale->join('sales', 'sale_items.sale_id = sales.id', 'left');
        $sale->join('contacts', 'sales.contact_id = contacts.id', 'left');
        $sale->join('administrators', 'sales.admin_id = administrators.id', 'left');
        $sale->where('sales.contact_id !=', NULL);
        $sale->where('transaction_date >=', $tanggalawal);
        $sale->where('transaction_date <=', $tanggalakhir);
        $sale->orderBy('sales.id', 'desc');
        $sale->groupBy('sales.number'); // Mengelompokkan berdasarkan sales_number
        $sale = $sale->get();
        $sale = $sale->getResultObject();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Data Penjualan (SO)');
        $sheet->mergeCells('A1:F1');
        $spreadsheet->getActiveSheet()
            ->getStyle('A1')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $spreadsheet->getActiveSheet()
            ->getStyle('A1')
            ->getFont()
            ->setSize(14);

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A2', 'Nomer Sales Order');
        $sheet->setCellValue('B2', 'Nama Sales');
        $sheet->setCellValue('C2', 'Nama Pelanggan');
        $sheet->setCellValue('D2', 'Nama produk');
        $sheet->setCellValue('E2', 'Jumlah Produk');
        $sheet->setCellValue('F2', 'Harga Produk');
        $sheet->setCellValue('G2', 'Tanggal Transaksi');
        $sheet->setCellValue('H2', 'Tag Penjualan');
        $sheet->setCellValue('I2', 'Status Penjualan');

        $column = 3;
        foreach ($sale as $key => $value) {
            // Ambil semua item yang terkait dengan satu sales_number
            $items = $this->db->table('sale_items');
            $items->select([
                'products.name as product_name',
                'sale_items.price as sale_price',
                'sale_items.quantity as sale_qty',
            ]);
            $items->join('products', 'sale_items.product_id = products.id', 'left');
            $items->join('sales', 'sale_items.sale_id = sales.id', 'left');
            $items->where('sales.contact_id !=', NULL);
            $items->where('transaction_date >=', $tanggalawal);
            $items->where('transaction_date <=', $tanggalakhir);
            $items->where('sales.number', $value->sales_number);
            $items = $items->get()->getResultObject();

            // Menyusun hasil ke dalam spreadsheet
            $sheet->setCellValue('A' . $column, $value->sales_number);
            $sheet->setCellValue('B' . $column, $value->sales_admin);
            $sheet->setCellValue('C' . $column, $value->contact_name);
            foreach ($items as $item) {
                $sheet->setCellValue('D' . $column, $item->product_name);
                $sheet->setCellValue('E' . $column, $item->sale_qty);
                $sheet->setCellValue('F' . $column, $item->sale_price);
                $sheet->setCellValue('G' . $column, $value->transaction_date);
                $sheet->setCellValue('H' . $column, $value->tags);
                $sheet->setCellValue('I' . $column, config("App")->orderStatuses[$value->orderStatuses]);
                $column++;
            }
        }

        $sheet->getStyle('A2:I2')->getFont()->setBold(true);

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename=DataSO.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }

    public function getDataPerProducts($product_id, $tglAwal, $tglAkhir)
    {
        $sale = $this->saleModel
            ->select([
                "sale_items.price as sale_price",
                "sale_items.quantity as sale_quantity",
                "sales.number as sale_number",
                "sales.transaction_date as sale_date",
                "sale_items.product_id",
                "sale_items.id as sale_item_id"
            ])
            ->join('sale_items', 'sales.id = sale_items.sale_id', 'left')
            ->where('sales.transaction_date >=', $tglAwal)
            ->where('sales.transaction_date <=', $tglAkhir)
            ->where('sales.status >=', 5)
            ->where('sales.contact_id IS NOT NULL');

        if ($product_id != "Pilih Barang") {
            $sale->where('sale_items.product_id', $product_id);
        }

        $sale = $sale->orderBy('sales.transaction_date', 'desc')->findAll();

        $productIDs = array_column($sale, 'product_id');

        $products = $this->productModel
            ->select(['id', 'name', 'sku_number']);

        if ($product_id != "Pilih Barang") {
            $products->where('id', $product_id);
        } else {
            $products->whereIn('id', $productIDs);
        }
        $products = $products->findAll();

        $stocks = $this->productStockModel
            ->select(['product_id', 'warehouses.name'])
            ->join('warehouses', 'product_stocks.warehouse_id = warehouses.id', 'left');

        if ($product_id != "Pilih Barang") {
            $stocks->where('product_id', $product_id);
        } else {
            $stocks->whereIn('product_id', $productIDs);
        }
        $stocks = $stocks->findAll();

        $data = $this->prepareProducts($sale, $products, $stocks);

        return $data;
    }

    private function prepareProducts($sale, $products, $stocks)
    {
        $data = [];
        foreach ($sale as $item) {
            $rowData = [
                "sale_number" => $item->sale_number,
                "sale_date" => $item->sale_date,
                "sale_price" => $item->sale_price,
                "sale_quantity" => $item->sale_quantity,
                "products" => $this->findProducts($products, $item->product_id),
                "warehouse_name" => $this->findWarehouses($stocks, $item->product_id)
            ];

            $data[] = $rowData;
        }

        return $data;
    }

    private function findWarehouses($stocks, $id)
    {
        foreach ($stocks as $item) {
            if ($item->product_id == $id) {
                return $item->name;
            }
        }

        return "";
    }

    private function findProducts($products, $id)
    {
        foreach ($products as $product) {
            if ($product->id == $id) {
                return [
                    "sku_number" => $product->sku_number,
                    "product_name" => $product->name,
                ];
            }
        }

        return ['sku_number' => NULL, 'product_name' => NULL];
    }

    public function export_per_products()
    {
        $product_id = $this->request->getVar("products");
        $first = $this->request->getVar("tanggalawal");
        $last = $this->request->getVar("tanggalakhir");

        $data = $this->getDataPerProducts($product_id, $first, $last);

        // var_dump($data);
        // exit();

        // $sale = $this->saleItemModel
        // ->select([
        //     "sale_items.price as sale_price",
        //     "sale_items.quantity as sale_quantity",
        //     "sales.number as sale_number",
        //     "sales.transaction_date as sale_date",
        //     "products.name as product_name",
        //     "products.sku_number as product_number",
        //     "warehouses.name as warehouse_name"
        // ])
        // ->join("sales", "sale_items.sale_id = sales.id", "left")
        // ->join("products", "sale_items.product_id = products.id", "left")
        // ->join('product_stocks', 'sale_items.id = product_stocks.sale_item_id', 'left')
        // ->join('warehouses', 'product_stocks.warehouse_id = warehouses.id', 'left')
        // ->where("sales.status >=", 5)
        // ->where("sales.contact_id !=", NULL)
        // ->where("sales.transaction_date >=", $first)
        // ->where("sales.transaction_date <=", $last);

        // if (!empty($product_id) && $product_id != "Pilih Barang") {
        //     $sale->where("sale_items.product_id", $product_id);
        // }

        // $sale = $sale->orderBy("sales.transaction_date", "desc")->get();
        // $Result = $sale->getResultObject();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'PT. GLOBAL MITRATAMA CEMERLANG');
        $sheet->mergeCells('A1:H1');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getFont()->setSize(14);

        $sheet->setCellValue('A2', 'Laporan Penjualan Per Barang');
        $sheet->mergeCells('A2:H2');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2')->getFont()->setSize(14);

        $sheet->setCellValue('A3', "$first - $last");
        $sheet->mergeCells('A3:H3');
        $sheet->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A3')->getFont()->setSize(14);

        $sheet->setCellValue('A5', 'Kode Produk');
        $sheet->setCellValue('B5', 'Nama Produk');
        $sheet->setCellValue('C5', 'Nomor SO');
        $sheet->setCellValue('D5', 'Lokasi');
        $sheet->setCellValue('E5', 'Tanggal');
        $sheet->setCellValue('F5', 'Harga');
        $sheet->setCellValue('G5', 'Jumlah');
        $sheet->setCellValue('H5', 'Total');

        $column = 6;
        foreach ($data as $item) {
            $sheet->setCellValue('A' .  $column, $item['products']['sku_number']);
            $sheet->setCellValue('B' . $column, $item['products']['product_name']);
            $sheet->setCellValue('C' . $column, $item['sale_number']);
            $sheet->setCellValue('D' . $column, $item['warehouse_name']);
            $sheet->setCellValue('E' . $column, $item['sale_date']);
            $sheet->setCellValue('F' . $column, $item['sale_price']);
            $sheet->setCellValue('G' . $column, $item['sale_quantity']);
            $sheet->setCellValue('H' . $column, $item['sale_quantity'] * $item['sale_price']);
            $column++;
        }

        $sheet->getStyle('A5:H5')->getFont()->setBold(true);
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'Data Penjualan Per Barang.xlsx';
        $writer->save($filename);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        readfile($filename);
        exit();
    }

    public function sales()
    {
        $sales = $this->saleModel
            ->where("admin_id", $this->session->login_id)
            ->where("contact_id !=", NULL)
            ->where("payment_id !=", NULL)
            ->where('trash', 0)
            ->orderBy("transaction_date", "desc")
            ->orderBy("id", "desc")
            ->findAll();


        $data = ([
            "sales" => $sales,
            "db"    => $this->db,
        ]);

        return view("sales/sales", $data);
    }

    public function testPage()
    {
        $token = $this->getLatestToken();

        $checkToken = $this->checkToken($token);

        return view("modules/testPage");
    }

    public function getSales()
    {
        $sales = $this->saleModel
            ->select(["id", "number", "transaction_date", "status", "admin_id", "contact_id", "tags"])
            ->where("admin_id !=", null)
            ->where("contact_id !=", null)
            ->where("payment_id !=", null)
            ->orderBy("transaction_date", "desc")
            ->orderBy("id", "desc")
            ->findAll();

        $admins = $this->adminModel
            ->select(["id", "name"])
            ->whereIn("id", array_column($sales, "admin_id"))
            ->findAll();

        $contacts = $this->contactModel
            ->select(["id", "name", "phone"])
            ->whereIn("id", array_column($sales, "contact_id"))
            ->findAll();

        $prepare = $this->prepareSalesData($sales, $admins, $contacts);

        return $this->response->setJSON($prepare);
    }

    protected function prepareSalesData($sales, $admins, $contacts)
    {
        $data = [];
        foreach ($sales as $sale) {
            $rowData = [
                "id" => $sale->id,
                "number" => $sale->number,
                "transaction_date" => $sale->transaction_date,
                "status" => $sale->status,
                "tags" => $sale->tags,
                "admin" => $this->findAdminName($admins, $sale->admin_id),
                "pelanggan" => $this->findContactsName($contacts, $sale->contact_id),
            ];

            $data[] = $rowData;
        }

        return $data;
    }

    protected function findAdminName($data, $admin_id)
    {
        foreach ($data as $user) {
            if ($user->id == $admin_id) {
                return $user->name;
            }
        }

        return "";
    }

    protected function findContactsName($data, $contact_id)
    {
        foreach ($data as $user) {
            if ($user->id == $contact_id) {
                return [
                    "nama" => $user->name,
                    "no_hp" => $user->phone
                ];
            }
        }

        return "";
    }


    public function sales_grosir()
    {
        $sales = $this->saleModel
            ->select([
                'sales.id',
                'sales.number',
                'sales.contact_id',
                'sales.payment_id',
                'administrators.name',
                'sales.transaction_date',
                'sales.status', 'sales.tags',
            ])
            ->join('administrators', 'sales.admin_id = administrators.id', 'left')
            ->where('administrators.role', config("Login")->loginRole = 3)
            ->where('contact_id !=', NULL)
            ->where('payment_id !=', NULL)
            ->orderBy('transaction_date', 'desc')
            ->orderBy('sales.id', 'desc')->findAll();

        $data = ([
            "sales" => $sales,
            "db"    => $this->db,
        ]);

        return view('sales/sales_grosir', $data);
    }

    public function sales_add_old()
    {
        $contacts = $this->contactModel
            ->where("type", 2)
            ->where("trash", 0)
            ->orderBy("name", "asc")
            ->findAll();

        // $warehouses = $this->warehouseModel
        // ->where("trash",0)
        // ->orderBy("name","asc")
        // ->findAll();

        $payments = $this->paymentModel
            ->where("trash", 0)
            ->orderBy("name", "asc")
            ->findAll();

        $tags = $this->tagModel
            ->orderBy("name", "asc")
            ->findAll();

        $locations = $this->locationModel
            ->where('trash', 0)
            ->orderBy("name", "asc")
            ->findAll();

        $data = ([
            "contacts"  => $contacts,
            // "warehouses"=> $warehouses,
            "payments" => $payments,
            "tags" => $tags,
            "locations" => $locations,
        ]);

        return view("/sales/sales_add", $data);
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
                "contact_id"    => NULL,
                "location_id"   => NULL,
                // "warehouse_id"=> $firstWarehouse->id,
                "invoice_address" => NULL,
                "sales_notes" => NULL,
                "time_create"     => date("Y-m-d H:i:s"),
                "transaction_date"  => date("Y-m-d"),
                "expired_date"  => date("Y-m-d", strtotime("+1 days")),
                "payment_id"    => NULL,
                "customer_reference_code" => "-",
                "tags"  => NULL,
                "status"    => 1,
                'is_saved' => 0
            ]);

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Pesanan penjualan berhasil dibuat');

        if (config("Login")->loginRole == 3) {
            return redirect()->to(base_url('sales/sales/grosir/' . $thisID . '/manage'));
        }

        if (config("Login")->loginRole == 7) {
            return redirect()->to(base_url('owner/sales/' . $thisID . '/manage'));
        } else {
            return redirect()->to(base_url('sales/sales/' . $thisID . '/manage'));
        }
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

    public function ajaxGetUser()
    {
        $role = $this->request->getVar("role");
        $admins = [];

        $users = $this->adminModel->where("role", $role)->where("active", 1)->orderBy("name", "asc")->findAll();
        foreach ($users as $user) {
            $admins[] = $user->name;
        }

        $json = json_encode($admins);
        return $json;
    }

    public function sales_insert()
    {
        $contact = $this->request->getPost('contact');
        $invoice_address = $this->request->getPost('invoice_address');
        $sales_notes = $this->request->getPost('sales_notes');
        $transaction_date = $this->request->getPost('transaction_date');
        $expired_date = $this->request->getPost('expired_date');
        $payment = $this->request->getPost('payment');
        $location = $this->request->getPost('location');
        // $reference = $this->request->getPost('reference');       
        // $warehouse = $this->request->getPost('warehouse');

        $thisTags = NULL;

        if ($this->request->getPost('tags')) {
            $tags = $this->request->getPost('tags');
            foreach ($tags as $tag) {
                $thisTags .= "#" . $tag;
            }
        } else {
        }
        // echo $thisTag;


        $maxId = $this->db->table("sales");
        $maxId->selectMax("id");
        $maxId = $maxId->get();
        $maxId = $maxId->getFirstRow();
        $maxId = $maxId->id;

        $thisID = $maxId + 1;

        $transaction_number = "SO/" . date("y") . "/" . date("m") . "/" . $thisID;

        $this->saleModel
            ->insert([
                "id"    => $thisID,
                "number"    => $transaction_number,
                "admin_id"    => $this->session->login_id,
                "contact_id"    => $contact,
                "location_id"   => $location,
                // "warehouse_id"=> $warehouse,
                "invoice_address" => $invoice_address,
                "sales_notes"  => $sales_notes,
                "transaction_date"  => $transaction_date,
                "expired_date"  => $expired_date,
                "payment_id"    => $payment,
                "customer_reference_code" => "-",
                "tags"  => $thisTags,
                "status"    => 1,
            ]);

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Pesanan penjualan berhasil dibuat');

        if (config("Login")->loginRole == 3) {
            return redirect()->to(base_url('sales/sales/grosir/' . $thisID . '/manage'));
        }

        if (config("Login")->loginRole == 7) {
            return redirect()->to(base_url('owner/sales/' . $thisID . '/manage'));
        } else {
            return redirect()->to(base_url('sales/sales/' . $thisID . '/manage'));
        }
    }

    public function sales_manage($id)
    {
        $sale = $this->saleModel->where("id", $id)->where("admin_id", $this->session->login_id)->first();

        if ($sale == NULL) {
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', 'Data tidak ditemukan');

            return redirect()->to(base_url('dashboard'));
        }

        if ($sale->is_saved == NULL) {
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', 'Penjualan Belum Disimpan');
        }

        $branch = $this->branchModel->where('trash', 0)->findAll();

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
            ->where("contacts.name !=", "")
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
            "thisContact" => $contact,
            "payment" => $payment,
            "locations" => $locations,
            "warehouses" => $warehouses,
            "branch" => $branch
        ]);

        if ($sale->status < 4) {
            return view("sales/sales_manage", $data);
        } else {
            return view("sales/sales_manage_fix", $data);
        }
    }

    public function sales_manage_warehouse($id)
    {
        $sale = $this->saleModel->where("id", $id)->first();

        if ($sale == NULL) {
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', 'Data tidak ditemukan');

            return redirect()->to(base_url('dashboard'));
        }

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

        $contact = $this->contactModel
            ->where("id", $sale->contact_id)
            ->first();

        $warehouse = $this->warehouseModel
            ->where("id", $sale->warehouse_id)
            ->first();

        $payment = $this->paymentModel
            ->where("id", $sale->payment_id)
            ->first();

        $vehicles = $this->vehicleModel
            ->where("trash", 0)
            ->orderBy("brand", "asc")
            ->findAll();

        $items = $this->saleItemModel
            ->where("sale_id", $id)
            ->findAll();

        $admin = $this->adminModel
            ->where("id", $sale->admin_id)
            ->first();

        $deliveries = $this->deliveryModel
            ->where("sale_id", $id)
            ->orderBy("sent_date", "desc")
            ->orderBy("id", "desc")
            ->findAll();

        $saleItem = $this->saleItemModel
            ->orderBy('id', 'desc')
            ->first();

        $stocks = $this->productStockModel
            ->selectSum('quantity')
            ->where('product_id', $saleItem->product_id)
            ->first();

        $data = ([
            "db"    => $this->db,
            "contact"  => $contact,
            "admin"  => $admin,
            "warehouse" => $warehouse,
            "payment" => $payment,
            "sale"  => $sale,
            "items" => $items,
            "vehicles" => $vehicles,
            "deliveries" => $deliveries,
            "saleItem" => $saleItem,
            "stocks" => $stocks,
        ]);

        return view("sales/sales_warehouse_manage", $data);
    }


    public function sales_grosir_manage($id)
    {
        $sale = $this->saleModel->where("id", $id)->first();

        if ($sale == NULL) {
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', 'Data tidak ditemukan');

            return redirect()->to(base_url('dashboard'));
        }

        $contacts = $this->contactModel
            ->where("contacts.name !=", "")
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
            "goods" => $goods,
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
        ]);

        if ($sale->status < 4) {
            return view("sales/sales_grosir_manage", $data);
        } else {
            return view("sales/sales_manage_fix", $data);
        }
    }

    public function sales_save()
    {
        $id = $this->request->getPost('id');
        $contact = $this->request->getPost('contact');
        $warehouse = $this->request->getPost('warehouse');
        $invoice_address = $this->request->getPost('invoice_address');
        $sales_notes = $this->request->getPost('sales_notes');
        $transaction_date = $this->request->getPost('transaction_date');
        $expired_date = $this->request->getPost('expired_date');
        $payment = $this->request->getPost('payment');
        $location_id = $this->request->getPost('location_id');
        $order_id = $this->request->getPost('order_id');
        $cabang_id = $this->request->getPost('cabang_id');
        $tax = $this->request->getPost('tax');
        $total_discount = $this->request->getPost('total_disc');
        $transaction_type = $this->request->getPost('transaction_type');

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

        if ($this->request->getPost('sales_notes')) {
            $sales_notes = $this->request->getPost('sales_notes');
        } else {
            $sales_notes = NULL;
        }

        $this->saleModel
            ->where("id", $id)
            ->set([
                "tax"   => $tax,
                "cabang_id" => $cabang_id,
                "contact_id"    => $contact,
                "warehouse_id"    => $warehouse,
                "invoice_address" => strtoupper($invoice_address),
                "sales_notes" => $sales_notes ? strtoupper($sales_notes) : NULL,
                "transaction_type"  => $transaction_type,
                "transaction_date"  => $transaction_date,
                "expired_date"  => $expired_date,
                "payment_id"    => $payment,
                "location_id"   => $location_id,
                "customer_reference_code" => "-",
                "tags"  => $thisTags,
                "order_id" => $order_id,
                "total_discount"    => $total_discount,
            ])->update();

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Pesanan penjualan berhasil disimpan');

        if (config("Login")->loginRole == 3) {
            return redirect()->to(base_url('sales/sales/grosir/' . $id . '/manage'));
        }

        if (config("Login")->loginRole == 7) {
            return redirect()->to(base_url('owner/sales/' . $id . '/manage'));
        } else {
            return redirect()->to(base_url('sales/sales/' . $id . '/manage'));
        }
    }

    public function ajax_sale_product_all()
    {
        $product = $this->request->getPost('product');
        $warehouse = $this->request->getPost('warehouse_id');

        $stocks = $this->db->table("warehouses A")
            ->select('A.id, A.name, SUM(IF(B.quantity IS NULL, 0, B.quantity)) AS QTY')
            ->join('product_stocks B', '(A.id=B.warehouse_id and B.product_id="' . $product . '")', 'left')
            ->where("FIND_IN_SET($warehouse, A.branch_id)")
            ->groupBy('A.id')
            ->get()
            ->getResultArray();

        echo '<option value="">--Pilih Gudang--</option>';

        foreach ($stocks as $row) {
            $stok_qty = $row['QTY'];

            if ($row['QTY'] > 10) {
                $stok_qty = '10+';
            }

            if ($row['QTY'] > 0) {
                echo "<option value='" . $row['id'] . "'  >" . $row['name'] . "  (" . $stok_qty . " Unit)" . "</option>";
            } else {
                if ($row['id'] == '6') {
                    echo "<option value='" . $row['id'] . "'  >" . $row['name'] . "  (" . $stok_qty . " Unit)" . "</option>";
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
        $stocks->where("product_stocks.warehouse_id", $warehouse);
        $stocks = $stocks->get();
        $stocks = $stocks->getFirstRow();

        if ($stocks->quantity <= 0) {
            echo "0~" . $stocks->product_unit;
        } else {
            echo $stocks->quantity . "~" . $stocks->product_unit;
        }
    }

    public function ajax_sale_products_stocks_display()
    {
        $product = $this->request->getPost('product');
        $warehouse = $this->request->getPost('warehouse');

        $stocks = $this->db->table("product_stocks");
        $stocks->selectSum("product_stocks.quantity");
        $stocks->select("products.unit as 'product_unit'");
        $stocks->join("products", "product_stocks.product_id=products.id", "right");
        $stocks->where("product_stocks.product_id", $product);
        $stocks->where("product_stocks.warehouse_id", 2);

        $stocks = $stocks->get();
        $stocks = $stocks->getFirstRow();

        if ($stocks->quantity <= 0) {
            echo "0~" . $stocks->product_unit;
        } else {
            echo $stocks->quantity . "~" . $stocks->product_unit;
        }
    }

    public function ajax_sale_products_stocks_ass()
    {
        $product   = $this->request->getPost('product');
        $warehouse = $this->request->getPost('warehouse');

        $stocks = $this->db->table("product_stocks");
        $stocks->selectSum("product_stocks.quantity");
        $stocks->select("products.unit as 'product_unit'");
        $stocks->join("products", "product_stocks.product_id=products.id", "right");
        $stocks->where("product_stocks.product_id", $product);
        $stocks->where("product_stocks.warehouse_id", 3);

        $stocks = $stocks->get();
        $stocks = $stocks->getFirstRow();

        if ($stocks->quantity <= 0) {
            echo "0~" . $stocks->product_unit;
        } else {
            echo $stocks->quantity . "~" . $stocks->product_unit;
        }
    }

    public function ajax_sale_product_prices()
    {
        $id = $this->request->getPost('product');

        $product = $this->productModel->where("id", $id)->first();

        $rumus = $this->productPriceModel->where("id", $product->price_id)->first();
        $level = $this->adminModel->where("id", $this->session->login_id)->first();

        if ($level) {
            if ($level->role == 2 || $level->role == 3) {
                $sales = $this->insentifModel->where("role", $level->role)->where("price_id", $rumus->id)->first();
                $role = $level->role + 2;
                $supervisor = $this->insentifModel->where("role", $role)->where("price_id", $rumus->id)->first();

                $level_sales = [
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

                $level_super = [
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
                    $supervisor->level_10
                ];
            }
        }

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
            // $thisPrice = (round(($thisPrice + config("App")->priceRound / 2) / config("App")->priceRound) * config("App")->priceRound);
            array_push($arrayPrices, $thisPrice);
        }

        if (config("Login")->loginRole == 7) {
            if ($product->price_hyd_online != 0) {
                echo "<option value='13-" . $product->price_hyd_online . "'>Rp. " . number_format($product->price_hyd_online, 0, ",", ".") . " (HYD Online)</option>";
            }
            if ($product->price_hyd_grosir != 0) {
                echo "<option value='14-" . $product->price_hyd_grosir . "'>Rp. " . number_format($product->price_hyd_grosir, 0, ",", ".") . " (HYD Grosir)</option>";
            }
            if ($product->price_hyd_retail != 0) {
                echo "<option value='12-" . $product->price_hyd_retail . "'>Rp. " . number_format($product->price_hyd_retail, 0, ",", ".") . " (HYD Retail)</option>";
            }
        }

        for ($x = 1; $x <= 10; $x++) {

            if ($level->role == 2 || $level->role == 3) {
                $harga_sales = floatval($level_sales[$x]);
                $harga_super = floatval($level_super[$x]);
                $insentifSales = ($arrayPrices[$x] * $harga_sales) / 100;
                $insentifSuper = ($arrayPrices[$x] * $harga_super) / 100;
            }

            if (config("Login")->loginRole == 2) {
                if ($x <= 1) {
                    if ($product->price_hyd_online != 0) {
                        echo "<option value='" . "13" . "-" . $product->price_hyd_online . "'>Rp. " . number_format($product->price_hyd_online, 0, ",", ".") . " (HYD Online)</option>";
                    }
                } elseif ($x == 2) {
                    if ($product->price_hyd_grosir != 0) {
                        echo "<option value='" . "14" . "-" . $product->price_hyd_grosir . "'>Rp. " . number_format($product->price_hyd_grosir, 0, ",", ".") . " (HYD Grosir)</option>";
                    }
                } elseif ($x == 3) {
                    if ($product->price_hyd_retail != 0) {
                        echo "<option value='" . "12" . "-" . $product->price_hyd_retail . "'>Rp. " . number_format($product->price_hyd_retail, 0, ",", ".") . " (HYD Retail)</option>";
                    }
                } elseif ($x == 4) {
                    echo "<option value='" . $x . "-" . $arrayPrices[$x] . "-" . $insentifSales . "-" . $insentifSuper . "' class='price-option-need-approve'>($x) Rp. " . number_format($arrayPrices[$x], 0, ",", ".") . " (Rp. " . number_format($insentifSales, 0, ",", ".") . ")" . "</option>";
                } else {
                    echo "<option value='" . $x . "-" . $arrayPrices[$x] . "-" . $insentifSales . "-" . $insentifSuper . "'>($x) Rp. " . number_format($arrayPrices[$x], 0, ",", ".") . " (Rp. " . number_format($insentifSales, 0, ",", ".") . ")" . "</option>";
                }
            } elseif (config("Login")->loginRole == 3) {
                if ($x <= 1) {
                    if ($product->price_hyd_grosir != 0) {
                        echo "<option value='" . "14" . "-" . $product->price_hyd_grosir . "'>Rp. " . number_format($product->price_hyd_grosir, 0, ",", ".") . " (HYD Grosir)</option>";
                    }
                } elseif ($x == 2) {
                    echo "<option value='" . $x . "-" . $arrayPrices[$x] . "-" . $insentifSales . "-" . $insentifSuper . "' class='price-option-need-approve'>($x) Rp. " . number_format($arrayPrices[$x], 0, ",", ".") . " (Rp. " . number_format($insentifSales, 0, ",", ".") . ")" . "</option>";
                } else {
                    echo "<option value='" . $x . "-" . $arrayPrices[$x] . "-" . $insentifSales . "-" . $insentifSuper . "'>($x) Rp. " . number_format($arrayPrices[$x], 0, ",", ".") . " (Rp. " . number_format($insentifSales, 0, ",", ".") . ")" . "</option>";
                }
            } else {
                echo "<option value='" . $x . "-" . $arrayPrices[$x] . "'>($x) Rp. " . number_format($arrayPrices[$x], 0, ",", ".") . "</option>";
            }
        }
    }

    public function ajax_sale_product_promos()
    {
        $product = $this->request->getPost('product');
        $loginId = $this->session->login_id;
        $role = $this->db->table('administrators')->select('role')->where('id', $loginId)->get()->getRow()->role;

        $promos = $this->db->table('promos');
        $promos->where("product_id", $product);
        $promos->where("promos.role", $role);
        $promos->where("date_start <=", date('Y-m-d'));
        $promos->where("date_end >=", date('Y-m-d'));
        $promos->orderBy('code', 'asc');
        $promos = $promos->get();
        $promos = $promos->getResultObject();

        foreach ($promos as $promo) {
            echo "<option value='" . $promo->id . "'>" . $promo->code . "</option>";
        }
    }

    public function sale_item_add()
    {
        // $F = $this->request->getPost();
        // $gudang = $this->db->table('product_stocks')
        // ->selectSum('product_stocks.quantity')
        // ->select('product_stocks.warehouse_id')
        // ->where('product_stocks.product_id', $F['product'])
        // ->where('product_stocks.warehouse_id',  $F['warehouse'])
        // ->get()->getFirstRow();

        // $inden = $this->db->table('product_stocks')
        // ->selectSum('product_stocks.quantity')
        // ->where('product_stocks.product_id', $F['product'])
        // ->where('product_stocks.inden_warehouse_id', $F['warehouse'])
        // ->where('product_stocks.warehouse_id',  6)
        // ->get()->getFirstRow();

        // $sisa_stok = ($gudang->quantity+$inden->quantity);
        // $sisa_akhir = ($gudang->quantity+$inden->quantity) - $F['qty'];

        // if($F['warehouse'] != 6){
        //     if($sisa_akhir < 0 ){
        //         $this->session->setFlashData('message_type', 'error');
        //         $this->session->setFlashdata('message_content',  "Stok tersisa ".$sisa_stok." Unit");              
        //         return redirect()->back();
        //     }
        // }
        // 

        $sale = $this->request->getPost('sale');
        $warehouse = $this->request->getPost('warehouse');
        $indenWarehouse = $this->request->getPost('indenWarehouse');
        $product = $this->request->getPost('product');
        $price = $this->request->getPost('price');
        $qty = $this->request->getPost('qty');
        $tax = $this->request->getPost('tax');
        $promo = $this->request->getPost('promo');
        $thisSale = $this->saleModel->where("id", $sale)->first();

        $discount = $this->request->getPost('discount');
        if ($discount != NULL) {
            $discount = $this->request->getPost('discount');
        } else {
            $discount = 0;
        }

        if (config("Login")->loginRole == 3) {
            $explodePrice = explode("-", $price);
            $thisPriceLevel = $explodePrice[0];
            $thisPriceValue = $explodePrice[1];


            if ($thisPriceLevel == 1) {
                $thisBonusSales = "";
                $thisBonusSupervisor = "";
            } else {
                if (count($explodePrice) >= 4) {
                    $thisBonusSales = $explodePrice[2];
                    $thisBonusSupervisor = $explodePrice[3];
                } else {
                    $thisBonusSales = "";
                    $thisBonusSupervisor = "";
                }
            }

            if ($this->request->getPost("custom_price")) {
                $custom_price = $this->request->getPost("custom_price");
                $dataInsert = ([
                    "sale_id"   => $sale,
                    "product_id"   => $product,
                    "quantity" => $qty,
                    "price" => $custom_price,
                    "price_level" => 11,
                    "tax"   => $tax,
                    "discount"   => $discount,
                    "promo_id"   => $promo,
                    "need_approve" => 2,
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
                    "tax"   => $tax,
                    "bonus_sales" => $thisBonusSales,
                    "bonus_supervisor" => $thisBonusSupervisor,
                    "discount"   => $discount,
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
                    "tax"   => $tax,
                    "discount"   => $discount,
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
                    "tax"   => $tax,
                    "bonus_sales" => $thisBonusSales,
                    "bonus_supervisor" => $thisBonusSupervisor,
                    "discount"   => $discount,
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
                    "tax"   => $tax,
                    "bonus_sales" => $thisBonusSales,
                    "bonus_supervisor" => $thisBonusSupervisor,
                    "discount"   => $discount,
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
                    "tax"   => $tax,
                    "bonus_sales" => $thisBonusSales,
                    "bonus_supervisor" => $thisBonusSupervisor,
                    "discount"   => $discount,
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
                    "tax"   => $tax,
                    "bonus_sales" => $thisBonusSales,
                    "bonus_supervisor" => $thisBonusSupervisor,
                    "discount"   => $discount,
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
                    "tax"   => $tax,
                    "bonus_sales" => $thisBonusSales,
                    "bonus_supervisor" => $thisBonusSupervisor,
                    "discount"   => $discount,
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
                    "tax"   => $tax,
                    "bonus_sales" => $thisBonusSales,
                    "bonus_supervisor" => $thisBonusSupervisor,
                    "discount"   => $discount,
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
                    "tax"   => $tax,
                    "bonus_sales" => $thisBonusSales,
                    "bonus_supervisor" => $thisBonusSupervisor,
                    "discount"   => $discount,
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
                    "tax"   => $tax,
                    "bonus_sales" => $thisBonusSales,
                    "bonus_supervisor" => $thisBonusSupervisor,
                    "discount"   => $discount,
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
                        "discount"   => $discount,
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
                        "discount"   => $discount,
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
                        "discount"   => $discount,
                        "promo_id"   => $promo,
                        "need_approve" => 3,
                        "ready" => 0,
                        "date" => date('Y,m,d')

                    ]);
                } else {
                    $explodePrice = explode("-", $price);
                    $thisPriceLevel = $explodePrice[0];
                    $thisPriceValue = $explodePrice[1];

                    if ($thisPriceLevel == 1 || $thisPriceLevel == 2 || $thisPriceLevel == 3) {
                        $thisBonusSales = "";
                        $thisBonusSupervisor = "";
                    } else {
                        if (count($explodePrice) >= 4) {
                            $thisBonusSales = $explodePrice[2];
                            $thisBonusSupervisor = $explodePrice[3];
                        } else {
                            $thisBonusSales = "";
                            $thisBonusSupervisor = "";
                        }
                    }

                    if (config("Login")->loginRole == 2) {
                        if ($thisPriceLevel == 2) {
                            $dataInsert = ([
                                "sale_id"   => $sale,
                                "product_id"   => $product,
                                "quantity" => $qty,
                                "price" => $thisPriceValue,
                                "price_level" => $thisPriceLevel,
                                "tax"   => $tax,
                                "bonus_sales" => $thisBonusSales,
                                "bonus_supervisor" => $thisBonusSupervisor,
                                "discount"   => $discount,
                                "promo_id"   => $promo,
                                "need_approve" => 1,
                                "ready" => 0,
                                "date" => date('Y,m,d')
                            ]);
                        }

                        if ($thisPriceLevel == 4) {
                            $dataInsert = ([
                                "sale_id"   => $sale,
                                "product_id"   => $product,
                                "quantity" => $qty,
                                "price" => $thisPriceValue,
                                "price_level" => $thisPriceLevel,
                                "tax"   => $tax,
                                "bonus_sales" => $thisBonusSales,
                                "bonus_supervisor" => $thisBonusSupervisor,
                                "discount"   => $discount,
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
                                "tax"   => $tax,
                                "bonus_sales" => $thisBonusSales,
                                "bonus_supervisor" => $thisBonusSupervisor,
                                "discount"   => $discount,
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
                                "tax"   => $tax,
                                "discount"   => $discount,
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
                                "tax"   => $tax,
                                "bonus_sales" => $thisBonusSales,
                                "bonus_supervisor" => $thisBonusSupervisor,
                                "discount"   => $discount,
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
                                "tax"   => $tax,
                                "bonus_sales" => $thisBonusSales,
                                "bonus_supervisor" => $thisBonusSupervisor,
                                "discount"   => $discount,
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
                                "tax"   => $tax,
                                "bonus_sales" => $thisBonusSales,
                                "bonus_supervisor" => $thisBonusSupervisor,
                                "discount"   => $discount,
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
                                "tax"   => $tax,
                                "bonus_sales" => $thisBonusSales,
                                "bonus_supervisor" => $thisBonusSupervisor,
                                "discount"   => $discount,
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
                                "tax"   => $tax,
                                "bonus_sales" => $thisBonusSales,
                                "bonus_supervisor" => $thisBonusSupervisor,
                                "discount"   => $discount,
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
                                "tax"   => $tax,
                                "bonus_sales" => $thisBonusSales,
                                "bonus_supervisor" => $thisBonusSupervisor,
                                "discount"   => $discount,
                                "promo_id"   => $promo,
                                "need_approve" => 0,
                                "approve_status" => 1,
                                "ready" => 1
                            ]);
                        }
                    } elseif (config("Login")->loginRole == 3) {

                        if ($thisPriceLevel == 2) {
                            $dataInsert = ([
                                "sale_id"   => $sale,
                                "product_id"   => $product,
                                "quantity" => $qty,
                                "price" => $thisPriceValue,
                                "price_level" => $thisPriceLevel,
                                "tax"   => $tax,
                                "discount"   => $discount,
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
                                "tax"   => $tax,
                                "discount"   => $discount,
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
                                "tax"   => $tax,
                                "discount"   => $discount,
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
                                "tax"   => $tax,
                                "discount"   => $discount,
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
                                "tax"   => $tax,
                                "discount"   => $discount,
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
                                "tax"   => $tax,
                                "discount"   => $discount,
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
                                "tax"   => $tax,
                                "discount"   => $discount,
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
                                "tax"   => $tax,
                                "discount"   => $discount,
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
                                "tax"   => $tax,
                                "discount"   => $discount,
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
                                "tax"   => $tax,
                                "discount"   => $discount,
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

        // Ambil contact_id pembelian sekarang
        $getUserID = $this->saleModel->select(["contact_id"])->where("id", $sale)->first();

        // Ambil total keseluruhan pembelian user
        $contact = $this->contactModel
            ->select([
                'is_member'
            ])
            ->where('id', $getUserID->contact_id)
            ->first();

        $this->saleItemModel->insert($dataInsert);

        $saleItemID = $this->saleItemModel->getInsertID();

        if ($contact->is_member == 1) {

            $totalTransaction = $this->saleModel
                ->select(["SUM(sale_items.price * sale_items.quantity) as totalTransaction"])
                ->join('sale_items', 'sales.id = sale_items.sale_id', 'left')
                ->where('sales.contact_id', $getUserID->contact_id)
                ->whereNotIn('sales.id', [$sale])
                ->findAll();

            $totalHarga = $this->saleItemModel
                ->select(["SUM(price * quantity) as totalPrice"])
                ->where('sale_id', $sale)
                ->findAll();

            $totalID = $this->saleItemModel
                ->select(['id'])
                ->where('sale_id', $sale)
                ->findAll();

            $allTransaction = 0;
            $price = 0;

            foreach ($totalTransaction as $transaction) {
                $allTransaction += $transaction->totalTransaction;
            }

            foreach ($totalHarga as $total) {
                $price += $total->totalPrice;
            }

            $totalPoint = 0;

            if ($allTransaction != 0) {

                $totalPrice = $allTransaction += $price;
                $level = "SILVER";

                if ($totalPrice >= 200000000) {
                    $point = floor($price / 1000000) * 5;
                    $totalPoint += $point;
                    $level = 'DIAMOND';
                } elseif ($totalPrice >= 100000000) {
                    $point = floor($price / 1000000) * 4;
                    $totalPoint += $point;
                    $level = "PLATINUM";
                } elseif ($totalPrice >= 25000000) {
                    $point = floor($price / 1000000) * 3;
                    $totalPoint += $point;
                    $level = "GOLD";
                } elseif ($totalPrice < 25000000) {
                    $point = floor($price / 1000000) * 2;
                    $totalPoint += $point;
                }

                if ($level == "SILVER") {
                    $this->contactModel->where('id', $getUserID->contact_id)->set(['member_level' => 1])->update();
                } elseif ($level == "GOLD") {
                    $this->contactModel->where('id', $getUserID->contact_id)->set(['member_level' => 2])->update();
                } elseif ($level == "PLATINUM") {
                    $this->contactModel->where('id', $getUserID->contact_id)->set(['member_level' => 3])->update();
                } elseif ($level == "DIAMOND") {
                    $this->contactModel->where('id', $getUserID->contact_id)->set(['member_level' => 4])->update();
                }

                if (count($totalID) > 1) {

                    $previousID = $this->saleItemModel
                        ->select(['id'])
                        ->where('sale_id', $sale)
                        ->orderBy('id', 'asc')
                        ->first();

                    $this->pointModel->where('sale_item_id', $previousID->id)->set(['point_in' => $totalPoint])->update();
                } else {

                    $data = [
                        "contact_id" => $thisSale->contact_id,
                        "date" => $thisSale->transaction_date,
                        'point_in' => $totalPoint,
                        'sale_item_id' => $saleItemID
                    ];

                    $this->pointModel->insert($data);
                }
            } else {

                $totalPrice = $price;
                $totalPoint = 0;
                $level = "SILVER";

                if ($totalPrice >= 25000000) {
                    $point = floor(25000000 / 1000000)  * 3;
                    $totalPoint += $point;
                    $totalPrice -= 25000000;
                    $level = "GOLD";
                }

                if ($totalPrice >= 100000000) {
                    $point = floor(100000000 / 1000000) * 4;
                    $totalPoint += $point;
                    $totalPrice -= 100000000;
                    $level = "PLATINUM";
                }

                if ($totalPrice >= 200000000) {
                    $point = floor(200000000 / 1000000) * 5;
                    $totalPoint += $point;
                    $totalPrice -= 200000000;
                    $level = "DIAMOND";
                }

                if ($level == "DIAMOND") {
                    $totalPoint += floor($totalPrice / 1000000)  * 5;
                    $this->contactModel->where('id', $getUserID->contact_id)->set(['member_level' => 4])->update();
                } elseif ($level == "PLATINUM") {
                    $totalPoint += floor($totalPrice / 1000000)  * 4;
                    $this->contactModel->where('id', $getUserID->contact_id)->set(['member_level' => 3])->update();
                } elseif ($level == "GOLD") {
                    $totalPoint += floor($totalPrice / 1000000)  * 3;
                    $this->contactModel->where('id', $getUserID->contact_id)->set(['member_level' => 2])->update();
                } elseif ($level == "SILVER") {
                    $totalPoint += floor($totalPrice / 1000000)  * 2;
                    $this->contactModel->where('id', $getUserID->contact_id)->set(['member_level' => 1])->update();
                }

                if (count($totalID) > 1) {

                    $previousID = $this->saleItemModel
                        ->select(['id'])
                        ->where('sale_id', $sale)
                        ->orderBy('id', 'asc')
                        ->first();

                    $this->pointModel->where('sale_item_id', $previousID->id)->set(['point_in' => $totalPoint])->update();
                } else {

                    $data = [
                        "contact_id" => $thisSale->contact_id,
                        "date" => $thisSale->transaction_date,
                        'point_in' => $totalPoint,
                        'sale_item_id' => $saleItemID
                    ];

                    $this->pointModel->insert($data);
                }
            }
        }

        $qtyStock = 0 - $qty;
        $this->productStockModel->insert([
            "product_id"    => $product,
            "warehouse_id" => $warehouse,
            "sale_item_id" => $saleItemID,
            "date"  => date("Y-m-d"),
            "quantity"  => $qtyStock,
            "inden_warehouse_id"    => $indenWarehouse,
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

        if (config("Login")->loginRole == 3) {
            return redirect()->to(base_url('sales/sales/grosir/' . $sale . '/manage'));
        }

        if (config("Login")->loginRole == 7) {
            return redirect()->to(base_url('owner/sales/' . $sale . '/manage'));
        } else {
            return redirect()->to(base_url('sales/sales/' . $sale . '/manage'));
        }
    }

    public function saveSalesOrder($id)
    {
        $sales = $this->saleModel->where('id', $id)->first();
        $payment = $this->paymentModel->select(['name', 'due_date'])->where('id', $sales->payment_id)->first();
        $items = $this->saleItemModel->where('sale_id', $id)->findAll();
        $user = $this->contactModel->where('id', $sales->contact_id)->first();

        // if ($user->is_member == 1) {
        //     // perhitungan point
        //     $totalTransaction = $this->saleModel
        //         ->select(['SUM(sale_items.price * sale_items.quantity) as total'])
        //         ->join('sale_items', 'sales.id = sale_items.sale_id', 'left')
        //         ->where('sales.contact_id', $user->id)
        //         ->first();

        //     $currentTrans = $this->saleModel
        //         ->select(['SUM(sale_items.price * sale_items.quantity) as total'])
        //         ->join('sale_items', 'sales.id = sale_items.sale_id', 'left')
        //         ->where('sales.id', $id)
        //         ->first();

        //     $totalPoint = 0;
        //     $level = $this->checkMemberLevel($totalTransaction->total, $user->id, $currentTrans->total);

        //     // Perhitungan poin berdasarkan tingkat keanggotaan saat ini
        //     if ($level == 'SILVER') {
        //         $toNextTier = 25000000;
        //         $sumTrans = min($currentTrans->total, $toNextTier);
        //         $currentTrans->total -= $sumTrans;

        //         $point = floor($sumTrans / 1000000) * 2;
        //         $totalPoint += $point;

        //         $level = 'GOLD';
        //     }

        //     if ($level == 'GOLD') {
        //         $toNextTier = 100000000;
        //         $sumTrans = min($currentTrans->total, $toNextTier);
        //         $currentTrans->total -= $sumTrans;

        //         $point = floor($sumTrans / 1000000) * 3;
        //         $totalPoint += $point;
        //     }

        //     if ($level == 'PLATINUM') {
        //         $toNextTier = 200000000;
        //         $sumTrans = min($currentTrans->total, $toNextTier);
        //         $currentTrans->total -= $sumTrans;

        //         $point = floor($sumTrans / 1000000) * 4;
        //         $totalPoint += $point;
        //     }

        //     if ($level == 'DIAMOND') {
        //         $point = floor($currentTrans->total / 1000000) * 5;
        //         $totalPoint += $point;
        //     }

        //     return $this->response->setJson(['totalTransaction' => $totalTransaction->total, 'currentTransaction' => $currentTrans->total, "point" => $totalPoint, 'member_level' => $level]);
        //     exit();
        // }

        $data = [];
        $totalPrice = 0;
        $discount = 0;
        $totalDiscount = 0;

        $warehouse = $this->getWarehouseName($sales->warehouse_id);

        foreach ($items as $item) {
            $products = $this->findSkuProduct($item->product_id);

            $totalPrice += $item->price *  $item->quantity;
            if (!empty($item->discount)) {
                $discount += $item->discount;
                $totalDiscount = $totalPrice * $discount / 100;
            }

            $data[] = [
                'sku' => $products['sku'],
                'description' => $products['name'],
                'qty' => $item->quantity,
                'price' => $item->price,
                'total_price' => $item->price,
                'total_discount_per_item_manual' => 0,
                'ppn_included' => $item->tax,
                'remarks' => $sales->sales_notes ?? '',
                'promo_list' => []
            ];
        }

        $arrayItem = [
            'site' => $warehouse['warehouse_name'],
            'order_id' => $sales->id,
            'customer_id' => $sales->contact_id,
            'cart' => $data,
            'sub_total' => $totalPrice,
            'discount_amount' => $totalDiscount,
            'remark' => $sales->sales_notes ?? '',
            'payment_method' => $payment->name,
            'transaction_time' => $sales->transaction_date,
            'terms_of_payment' => 'NETO',
            'terms_of_payment_duration' => $payment->due_date,
            'pph_amount' => 0,
            'ppn_amount' => 0,
            'salesman_code' => 'PELANGGAN',
            'delivery_fee' => 0,
            'service_charge_fee' => 0,
            'airway_bill_code' => '0',
            'dropshipper_name' => '',
            'dropshipper_phone' => '',
            'use_box' => '',
            'wrapping_note' => ''
        ];

        $token = $this->getLatestToken();

        $response = $this->client->request('POST', 'https://api.product.prieds.com/priedsoa/open-api/v1/public/so/save', [
            'headers' => [
                'x-prieds-token' => $token,
                'x-prieds-username' => 'AIO_INTEGRATION'
            ],
            'json' => [
                'request' => $arrayItem
            ]
        ]);

        $data = json_decode($response->getBody()->getContents());

        if ($data->status != 200) {
            return $this->response->setJSON($data);
        }

        $this->saleModel->where('id', $id)->set('is_saved', 1)->update();

        return redirect()->to(base_url('owner/sales/' . $id . '/manage'));
    }

    private function checkMemberLevel($totalTransaction, $userID)
    {
        if ($totalTransaction > 0 || $totalTransaction < 25000000) {
            $this->contactModel->where('id', $userID)->set(['member_level' => 1])->update();
            return 'SILVER';
        } elseif ($totalTransaction >= 25000000 || $totalTransaction < 100000000) {
            $this->contactModel->where('id', $userID)->set(['member_level' => 2])->update();
            return 'GOLD';
        } elseif ($totalTransaction >= 100000000 || $totalTransaction < 200000000) {
            $this->contactModel->where('id', $userID)->set(['member_level' => 3])->update();
            return 'PLATINUM';
        } elseif ($totalTransaction >= 200000000) {
            $this->contactModel->where('id', $userID)->set(['member_level' => 4])->update();
            return 'DIAMOND';
        }
    }

    private function findSkuProduct($productID)
    {
        $products = $this->productModel
            ->where('id', $productID)
            ->first();

        if ($products) {
            return [
                'sku' => $products->sku_number,
                'name' => $products->name
            ];
        }
    }

    public function sales_item_delete($sale, $item)
    {
        $thisSale = $this->saleModel->where("id", $sale)->first();
        if ($thisSale->status >= 6) {
            $this->session->setFlashdata('message_type', 'warning');
            $this->session->setFlashdata('message_content', 'Item Penjualan (SO) gagal dihapus');

            return redirect()->to(base_url('sales/sales/' . $sale . '/manage'));
        }

        $thisItem = $this->saleItemModel->where("id", $item)->first();

        $this->saleItemModel->where("id", $item)->delete();
        $this->productStockModel->where("sale_item_id", $item)->delete();
        $this->pointModel->where("sale_item_id", $item)->delete();
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

        if (config("Login")->loginRole == 3) {
            return redirect()->to(base_url('sales/sales/grosir/' . $sale . '/manage'));
        }

        if (config("Login")->loginRole == 7) {
            return redirect()->to(base_url('owner/sales/' . $sale . '/manage'));
        } else {
            return redirect()->to(base_url('sales/sales/' . $sale . '/manage'));
        }
    }

    public function sales_item_deletes($sale, $item)
    {
        $thisSale = $this->saleModel->where("id", $sale)->first();
        $thisItem = $this->saleItemModel->where("id", $item)->first();

        $this->saleItemModel->where("id", $item)->delete();
        $this->productStockModel->where("sale_item_id", $item)->delete();
        $this->pointModel->where("sale_item_id", $item)->delete();

        $items = $this->saleItemModel->where("sale_id", $sale)->findAll();

        $saleReady = 1;
        foreach ($items as $item) {
            $saleReady = $saleReady * $item->ready;
        }

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Barang berhasil dihapus dari daftar penjualan');

        if (config("Login")->loginRole == 7) {
            return redirect()->to(base_url('owner/sales/' . $sale . '/manage'));
        } else {
            return redirect()->to(base_url('sales/sales/' . $sale . '/manage'));
        }
    }

    public function sales_item_edit_qty()
    {
        $sale = $this->request->getPost('sale');
        $warehouse = $this->request->getPost('warehouse');
        $item = $this->request->getPost('item');
        $product = $this->request->getPost('product');
        $qty = $this->request->getPost('qty');

        $stocks = $this->db->table("product_stocks");
        $stocks->selectSum("product_stocks.quantity");
        $stocks->where("product_id", $product);
        $stocks->where("warehouse_id", $warehouse);

        $stocks = $stocks->get();
        $stocks = $stocks->getFirstRow();

        if ($qty > $stocks->quantity) {
            $this->session->setFlashdata('message_type', 'warning');
            $this->session->setFlashdata('message_content', 'Kuantitas gagal diubah karena melebihi persediaan');
            return redirect()->to(base_url('sales/sales/' . $sale . '/manage'));
        } else {
            $this->saleItemModel->where("id", $item)
                ->set([
                    "quantity" => $qty
                ])->update();

            $qtyForStock = 0 - $qty;
            $this->db->table("product_stocks")->where("sale_item_id", $item)
                ->set([
                    "quantity" => $qtyForStock
                ])->update();
            $this->session->setFlashdata('message_type', 'success');
            $this->session->setFlashdata('message_content', 'Kuantitas berhasil diubah');
            return redirect()->to(base_url('sales/sales/' . $sale . '/manage'));
        }
    }

    public function sales_delete($id)
    {
        $sale = $this->saleModel->where("id", $id)->first();

        $token = $this->getLatestToken();

        if ($sale->status >= 6) {
            $this->session->setFlashdata('message_type', 'warning');
            $this->session->setFlashdata('message_content', 'Penjualan (SO) gagal dihapus');
            return redirect()->to(base_url('sales/sales/' . $id . '/manage'));
        }

        $items = $this->saleItemModel
            ->where("sale_id", $id)
            ->findAll();

        $warehouse = $this->getWarehouseName($sale->warehouse_id);

        foreach ($items as $item) {
            $thisItem = $this->saleItemModel->where("id", $item->id)->first();

            $this->saleItemModel->where("id", $item->id)->delete();
            $this->productStockModel->where("sale_item_id", $item->id)->delete();
        }

        if (!empty($items)) {
            $response = $this->client->request('POST', 'https://api.product.prieds.com/priedsoa/open-api/v1/public/so/delete', [
                'headers' => [
                    'x-prieds-token' => $token,
                    'x-prieds-username' => "AIO_INTEGRATION"
                ],
                'json' => [
                    'request' => [
                        'order_id' => $sale->id,
                        'site' => $warehouse['warehouse_name']
                    ]
                ],
            ]);

            $body = json_decode($response->getBody()->getContents());

            if ($body->status != 200) {
                $this->session->setFlashdata('message_type', 'error');
                $this->session->setFlashdata('message_content', 'Penjualan Di System Prieds Tidak Ditemukan / Sudah Dihapus');
            }
        }

        $this->saleModel->where("id", $id)->set(["trash" => 1])->update();
        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Penjualan (SO) berhasil dihapus');

        if (config("Login")->loginRole == 3) {
            return redirect()->to(base_url('sales/sales_grosir'));
        }

        return redirect()->to(base_url('sales/sales/add'));
    }

    private function getWarehouseName($branchID)
    {
        if ($branchID == 1) {
            return [
                'warehouse_name' => 'GUDANG CIREBON'
            ];
        } else {
            return [
                'warehouse_name' => 'GUDANG TASIKMALAYA'
            ];
        }
    }

    private function isContactPhone($phone)
    {
        $existingContact = $this->contactModel
            ->where('phone', $phone)
            ->first();

        return $existingContact !== null;
    }

    public function contacts_add_direct_sales_add()
    {
        $name = $this->request->getPost('name');
        $type = $this->request->getPost('type');
        $phone = $this->request->getPost('phone');
        // $email = $this->request->getPost('email');
        $address = $this->request->getPost('address');
        // $reference = $this->request->getPost('reference');

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

        return redirect()->to(base_url('sales/sales/add'));
    }

    public function contacts_add_direct_sales_manage()
    {
        $sale = $this->request->getPost('sale');
        $name = $this->request->getPost('name');
        $type = $this->request->getPost('type');
        $phone = $this->request->getPost('phone');
        // $email = $this->request->getPost('email');
        $address = $this->request->getPost('address');
        // $reference = $this->request->getPost('reference');

        if ($this->isContactPhone($phone)) {
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', 'Kontak dengan nomer handphone <b>' . $phone . '</b> sudah ada!');

            if (config("Login")->loginRole == 7) {
                return redirect()->to(base_url('owner/sales/' . $sale . '/manage'));
            } elseif (config("Login")->loginRole == 3) {
                return redirect()->to(base_url('sales/sales/' . $sale . '/manage'));
            } else {
                return redirect()->to(base_url('sales/sales/' . $sale . '/manage'));
            }
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

        $id = $this->contactModel->getInsertID();
        $contacts = $this->contactModel->where('id', $id)->first();

        $token = $this->getLatestToken();

        $response = $this->client->request('POST', 'https://api.product.prieds.com/priedsoa/open-api/v1/public/customer/save', [
            'headers' => [
                'x-prieds-token' => $token,
                'x-prieds-username' => 'AIO_INTEGRATION'
            ],
            'json' => [
                'request' => [
                    'salesman_code' => "PELANGGAN",
                    'customer_id' => $contacts->id,
                    'customer_name' => $contacts->name,
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

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Kontak <b>' . $name . '</b> berhasil ditambahkan');

        if (config("Login")->loginRole == 3) {
            return redirect()->to(base_url('sales/sales/grosir/' . $sale . '/manage'));
        }

        if (config("Login")->loginRole == 7) {
            return redirect()->to(base_url('owner/sales/' . $sale . '/manage'));
        } else {
            return redirect()->to(base_url('sales/sales/' . $sale . '/manage'));
        }
    }
}
