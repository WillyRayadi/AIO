<?php

namespace App\Controllers;

helper('tools_helper');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Hermawan\DataTables\DataTable;

class AdminSub extends BaseController
{
    protected $session;
    protected $validation;
    protected $db;
    
    protected $adminModel;
    
    private $administratorRoleModel;
    private $redeemItemModel;
    private $userRedeemModel;
    private $userPointModel;
    private $pointExchangeModel;

    private $manifestSoModel;
    private $PurchaseOrderModel;
    private $purchaseOrderItemModel;
    private $ProductReturnmodel;
    private $ProductReturnItemModel;
    private $capacityModel;
    private $stokOpname;
    private $stokItemOpnameModel;
    private $brandModel;
    private $buyItemModel;
    private $productCategoriesModel;
    private $SubCategoriesModel;
    private $productModel;
    private $productPriceModel;
    private $productPriceFormulaModel;
    private $productPriceVariableModel;
    private $productStocksModel;
    private $productRepairModel;
    private $productDisplayModel;
    private $productLocationModel;
    private $productStockModel;
    private $codeModel;
    private $customerModel;
    private $warehouseModel;
    private $promoModel;
    private $promoTypeModel;
    private $contactModel;
    private $saleModel;
    private $saleItemModel;
    private $tagModel;
    private $paymentModel;
    private $vehicleModel;
    private $deliveryModel;
    private $deliveryItemModel;
  	private $goodsModel;
  	private $bundlingModel;
    private $saleItemBundlingModel;
    private $warehouseTransferModel;
    private $warehouseTransfersItemsModel;
    private $saleReturnModel;
    private $referralModel;
    private $insentifModel;
    private $staggingDOModel;
    private $productReturnModel ;
    private $productReturnItemModel ;
    private $stokOpnameModel ;

    public function __construct(){
        $this->session = \Config\Services::session();

        $this->db = \Config\Database::connect();
        $this->validation =  \Config\Services::validation();
        
        $this->staggingDOModel = new \App\Models\staggingDO();
        $this->administratorRoleModel = new \App\Models\AdministratorRole();
        $this->userRedeemModel = new \App\Models\userRedeem();
        $this->redeemItemModel = new \App\Models\RedeemItem();
        $this->userPointModel = new \App\Models\UserPoint();
        $this->pointExchangeModel = new \App\Models\PointExchange();
        
        $this->manifestSoModel = new \App\Models\ManifestSo();
        $this->PurchaseOrderModel = new \App\Models\PurchaseOrder();
        $this->purchaseOrderItemModel = new \App\Models\PurchaseOrderItem();
        $this->productReturnModel = new \App\Models\ProductReturn();
        $this->productReturnItemModel = new \App\Models\ProductReturnItem();
        $this->capacityModel =  new \App\Models\Capacity();
        $this->adminModel = new \App\Models\Administrator();
        $this->brandModel = new \App\Models\Brands();
        $this->buyItemModel = new \App\Models\BuyItem();
        $this->productCategoriesModel = new \App\Models\Category();
        $this->SubCategoriesModel = new \App\Models\SubCategory();
        $this->productModel = new \App\Models\Product();
        $this->productPriceModel = new \App\Models\ProductPrice();
        $this->productPriceFormulaModel = new \App\Models\ProductPriceFormula();
        $this->productPriceVariableModel = new \App\Models\ProductPriceVariable();
        $this->productStocksModel = new \App\Models\Stock();
        $this->productRepairModel = new \App\Models\ProductRepair();
        $this->productDisplayModel = new \App\Models\ProductDisplay();
        $this->productLocationModel = new \App\Models\ProductLocation();
        $this->productStockModel = new \App\Models\ProductStock();
        $this->codeModel = new \App\Models\Code();
        $this->customerModel = new \App\Models\Customer();
        $this->warehouseModel = new \App\Models\Warehouse();
        $this->promoModel = new \App\Models\Promo();
        $this->promoTypeModel = new \App\Models\PromoType();
        $this->contactModel = new \App\Models\Contact();
        $this->saleModel = new \App\Models\Sale();
        $this->saleItemModel = new \App\Models\SaleItem();
        $this->tagModel = new \App\Models\Tag();
        $this->paymentModel = new \App\Models\PaymentTerm();
        $this->vehicleModel = new \App\Models\Vehicle();
        $this->deliveryModel = new \App\Models\Delivery();
        $this->deliveryItemModel = new \App\Models\DeliveryItem();
      	$this->goodsModel = new \App\Models\Product();
      	$this->bundlingModel = new \App\Models\Bundling();
      	$this->saleItemBundlingModel = new \App\Models\SaleItemBundling();
      	$this->warehouseTransferModel = new \App\Models\WarehouseTransfer();
        $this->warehouseTransfersItemsModel = new \App\Models\WarehouseTransfersItems();
        $this->stokItemOpnameModel = new \App\Models\stokItemOpname();
        $this->stokOpnameModel   = new \App\Models\StokOpname();
        $this->saleReturnModel = model("App\Models\saleReturnItem");
        $this->referralModel = model("App\Models\ReferralCode");
        $this->insentifModel = model('App\Models\Insentif');
       
        if($this->session->login_id == null){            
            $this->session->setFlashdata('msg', 'Maaf, Silahkan login terlebih dahulu!');
            header("location:".base_url('/'));
            exit();
        }else{
            if(config("Login")->loginRole != 1){
               if(config("Login")->loginRole != 2){
               if(config("Login")->loginRole != 3){
               if(config("Login")->loginRole != 6){
                if(config("Login")->loginRole != 8){
                if(config("Login")->loginRole != 7){
                    header("location:".base_url('/dashboard'));
                    exit();
                }
            }
               }
          }
        }
       }
      }
    } 
    
    public function products_inden(){
        $productInden = $this->db->table('product_stocks as a')
        ->select([
            'd.admin_id',
            'b.sku_number',
            'd.transaction_date',
            'd.status sale_status', 
            'a.inden_warehouse_id',
            'b.name as product_name',
            'd.number as sale_number',
            'c.quantity as sale_qtys',
            'e.name as warehouse_name',
        ])
        ->join('products as b', 'a.product_id = b.id','left')
        ->join('sale_items as c', 'a.sale_item_id = c.id', 'left')
        ->join('sales as d', 'c.sale_id = d.id', 'left')
        ->join('warehouses as e', 'a.warehouse_id = e.id', 'left')
        ->where('d.status !=', 6)
        ->where('a.warehouse_id', 6)
        ->where('a.sale_item_id !=', NULL)
        ->groupBy('c.product_id')
        ->orderBy('d.id', 'desc')->get()->getResultObject();

        $data = ([
            'db'    => $this->db,
            'products' => $productInden,
        ]);

        return view('modules/product_inden', $data);
    }
    
    public function add_submission_print(){
        $dates = $this->request->getPost('dates');
        $reason = $this->request->getPost('reason');
        $sales = $this->request->getPost('sales_id');
        $admins = $this->request->getPost('admin_id');
    
        $file = $this->request->getFile('file'); 
        $imageName = ''; 
    
        if ($file->isValid() && !$file->hasMoved()) {
            $imageName = $file->getRandomName();
            
            $file->move('./public/submit_do/', $imageName);
        }
    
        $this->staggingDOModel->insert([
            'date'  => $dates,
            'sale_id'   => $sales,
            'delivery_id'  => 0,
            'admin_id'  => $admins,
            'reason'    => $reason,
            'image_path' => $imageName, 
        ]);
    
        $this->session->setFlashData('message_type', 'success');
        $this->session->setFlashData('message_content', 'Data Berhasil Di Ajukan!');
    
        return redirect()->back();
    }
    
    public function report_allow(){
        $userRole = $this->db->table('administrator_role');
        $userRole->select('administrator_role.*');
        $userRole->orderBy('administrator_role.role_name','asc');
        $userRole = $userRole->get();
        $userRole = $userRole->getResultObject();

        $spreadsheet =  new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Data Report Hak Akses');
        $sheet->setCellValue('A2', 'Stokaio');
        $sheet->mergeCells('A1:Z1');
        $sheet->mergeCells('A2:Z2');

        $sheet->setCellValue('A3', 'Role User');
        $sheet->setCellValue('B3', 'Buat PD');
        $sheet->setCellValue('C3', 'Edit PD');
        $sheet->setCellValue('D3', 'Hapus PD');
        $sheet->setCellValue('E3', 'Lihat PD');
        $sheet->setCellValue('F3', 'Buat SO');
        $sheet->setCellValue('G3', 'Edit SO');
        $sheet->setCellValue('H3', 'Hapus SO');
        $sheet->setCellValue('I3', 'Lihat SO');
        $sheet->setCellValue('J3', 'Buat DO');
        $sheet->setCellValue('K3', 'Edit DO');
        $sheet->setCellValue('L3', 'Hapus DO');
        $sheet->setCellValue('M3', 'Lihat DO');
        $sheet->setCellValue('N3', 'Buat Retur');
        $sheet->setCellValue('O3', 'Edit Retur');
        $sheet->setCellValue('P3', 'Hapus Retur');
        $sheet->setCellValue('Q3', 'Lihat Retur');
        $sheet->setCellValue('R3', 'Buat Manifest');
        $sheet->setCellValue('S3', 'Buat Transfer Produk');
        $sheet->setCellValue('T3', 'Edit Transfer Produk');
        $sheet->setCellValue('U3', 'Lihat Transfer Produk');
        $sheet->setCellValue('V3', 'Hapus Transfer Produk');
        $sheet->setCellValue('W3', 'Persetujuan SO');
        $sheet->setCellValue('X3', 'Buat Produk');
        $sheet->setCellValue('Y3', 'Lihat Produk');
        $sheet->setCellValue('Z3', 'Hapus Produk');
        
        $column = 3;
        foreach ($userRole as $key => $value) {
            $column++;
            $sheet->setCellValue('A'.$column, $value->role_name);
            $sheet->setCellValue('B'.$column, $value->purchase_order_buat == 1 ? '✔️' : '');
            $sheet->setCellValue('C'.$column, $value->purchase_order_edit == 1 ? '✔️' : '');
            $sheet->setCellValue('D'.$column, $value->purchase_order_hapus == 1 ? '✔️' : '');
            $sheet->setCellValue('E'.$column, $value->purchase_order_lihat == 1 ? '✔️' : '');
            $sheet->setCellValue('F'.$column, $value->sales_order_buat == 1 ? '✔️' : '');
            $sheet->setCellValue('G'.$column, $value->sales_order_edit == 1 ? '✔️' : '');
            $sheet->setCellValue('H'.$column, $value->sales_order_hapus == 1 ? '✔️' : '');
            $sheet->setCellValue('I'.$column, $value->sales_order_lihat == 1 ? '✔️' : '');
            $sheet->setCellValue('J'.$column, $value->delivery_order_buat == 1 ? '✔️' : '');
            $sheet->setCellValue('K'.$column, $value->delivery_order_edit == 1 ? '✔️' : '');
            $sheet->setCellValue('L'.$column, $value->delivery_order_hapus == 1 ? '✔️' : '');
            $sheet->setCellValue('M'.$column, $value->delivery_order_lihat == 1 ? '✔️' : '');
            $sheet->setCellValue('N'.$column, $value->retur_product_buat == 1 ? '✔️' : '');
            $sheet->setCellValue('O'.$column, $value->retur_product_edit == 1 ? '✔️' : '');
            $sheet->setCellValue('P'.$column, $value->retur_product_hapus == 1 ? '✔️' : '');
            $sheet->setCellValue('Q'.$column, $value->retur_product_lihat == 1 ? '✔️' : '');
            $sheet->setCellValue('R'.$column, $value->manifest_so_buat == 1 ? '✔️' : '');
            $sheet->setCellValue('S'.$column, $value->transfer_warehouse_buat == 1 ? '✔️' : '');
            $sheet->setCellValue('T'.$column, $value->transfer_warehouse_edit == 1 ? '✔️' : '');
            $sheet->setCellValue('U'.$column, $value->transfer_warehouse_hapus == 1 ? '✔️' : '');
            $sheet->setCellValue('V'.$column, $value->transfer_warehouse_lihat == 1 ? '✔️' : '');
            $sheet->setCellValue('W'.$column, $value->agreement_buat == 1 ? '✔️' : '');
            $sheet->setCellValue('X'.$column, $value->products_buat == 1 ? '✔️' : '');
            $sheet->setCellValue('Y'.$column, $value->products_edit == 1 ? '✔️' : '');
            $sheet->setCellValue('Z'.$column, $value->products_hapus == 1 ? '✔️' : '');
        }

        $sheet->getStyle('A1:Z1')->getFont()->setBold(true);
        $sheet->getStyle('A2:Z2')->getFont()->setBold(true);

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
        $sheet->getColumnDimension('K')->setAutoSize(true);
        $sheet->getColumnDimension('L')->setAutoSize(true);
        $sheet->getColumnDimension('M')->setAutoSize(true);
        $sheet->getColumnDimension('N')->setAutoSize(true);
        $sheet->getColumnDimension('O')->setAutoSize(true);
        $sheet->getColumnDimension('P')->setAutoSize(true);
        $sheet->getColumnDimension('Q')->setAutoSize(true);
        $sheet->getColumnDimension('R')->setAutoSize(true);
        $sheet->getColumnDimension('S')->setAutoSize(true);
        $sheet->getColumnDimension('T')->setAutoSize(true);
        $sheet->getColumnDimension('U')->setAutoSize(true);
        $sheet->getColumnDimension('V')->setAutoSize(true);
        $sheet->getColumnDimension('W')->setAutoSize(true);
        $sheet->getColumnDimension('X')->setAutoSize(true);
        $sheet->getColumnDimension('Y')->setAutoSize(true);
        $sheet->getColumnDimension('Z')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename= Data Akses User.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
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
    
    public function export_user(){
        $admins = $this->db->table('administrators');
        $admins->select([
            'administrators.role as admin_role',
            'administrators.name as admin_name',
            'administrators.email as admin_email',
            'administrators.phone as admin_phone',
            'administrators.cabang as admin_cabang',
            'administrators.username as admin_username',
        ]);
        $admins->where('active', 1);
        $admins->orderBy('administrators.name', 'asc');
        $admins = $admins->get();
        $admins = $admins->getResultObject();

        $spreadsheet =  new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Data User STOKAIO');
        $sheet->mergeCells('A1:C1');
       
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getFont()->setSize(14);
        $sheet->getStyle('A1:C1')->getFont()->setBold(true);
       
        $sheet->getStyle('A3:C3')->getFont()->setBold(true);
        
        $sheet->setCellValue('A3', 'Nama User');
        $sheet->setCellValue('B3', 'Role User');
        $sheet->setCellValue('C3', 'Cabang Penjualan');
         
        $column = 4;
            foreach ($admins as $key => $value) {
                $sheet->setCellValue('A'.$column, $value->admin_name);
                $sheet->setCellValue('B'.$column, config("App")->roles[$value->admin_role]);
                $sheet->setCellValue('C'.$column, $value->admin_cabang);
                $column++;
            }

            $sheet->getColumnDimension('A')->setAutoSize(true);
            $sheet->getColumnDimension('B')->setAutoSize(true);
            $sheet->getColumnDimension('C')->setAutoSize(true);
    
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename= Data User Stokaio.xlsx');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
            exit();
    }
    
    public function report_sale_tag(){
        $sales_tag = $this->db->table('tags');
        $sales_tag->select([
            'tags.id as tag_id',
            'tags.name as tag_name',
        ]);
        $sales_tag->orderBy('tags.name','asc');
        $sales_tag = $sales_tag->get();
        $sales_tag = $sales_tag->getResultObject();
        
        $admins = $this->db->table('administrators as a');
        $admins->where('a.active', 1);
        $admins->orderBy('a.name','asc');
        $admins->whereIn('a.role', [2,3]);
        $admins = $admins->get();
        $admins = $admins->getResultObject();
        
        $data = ([
            'db'    => $this->db,
            'admins'    => $admins,
            'sales_tag' => $sales_tag,
        ]);
        
        return view('modules/report_sale_tag', $data);
    }
    
    public function export_sale_tag(){
        $tags = $this->request->getGet('tagname');
        $tanggal_awal = $this->request->getGet('tanggalawal');
        $tanggal_akhir = $this->request->getGet('tanggalakhir');
        
        $sales = $this->saleModel
        ->select([
            'sales.number as sale_number',
            'sales.time_done as sale_done',
            'sales.tags as sale_tags',
            'contacts.name as contact_name',
            'products.name as product_name',
            'sale_items.price as sale_price',
            'sale_items.quantity as sale_qty',
            'sales.time_create as sale_create',
            'warehouses.name as warehouse_name'
        ])
        ->join('administrators', 'sales.admin_id = administrators.id', 'left')
        ->join('contacts', 'sales.contact_id = contacts.id', 'left')
        ->join('sale_items', 'sales.id = sale_items.sale_id', 'left')
        ->join('products', 'sale_items.product_id = products.id', 'left')
        ->join('product_stocks', 'sale_items.id = product_stocks.sale_item_id', 'left')
        ->join('warehouses', 'product_stocks.warehouse_id = warehouses.id', 'left')
        ->where('sales.tags','#'.$tags)
        ->where('sales.transaction_date >=', $tanggal_awal)
        ->where('sales.transaction_date <=', $tanggal_akhir)
        ->orderBy('sales.id', 'desc')
        ->get()->getResult();
    

        $spreadsheet =  new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Report Sale Tag '.$tags);
        $sheet->setCellValue('A2',  $tanggal_awal.' / '.$tanggal_akhir);
        $sheet->mergeCells('A1:F1');
        $sheet->mergeCells('A2:F2');

        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getFont()->setSize(14);
        $sheet->getStyle('A1:F1')->getFont()->setBold(true);
        
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2')->getFont()->setSize(14);
        $sheet->getStyle('A2:F2')->getFont()->setBold(true);


        $sheet->getStyle('A4:F4')->getFont()->setBold(true);
        $sheet->setCellValue('A4', 'Number SO');
        $sheet->setCellValue('B4', 'Customer Name');
        $sheet->setCellValue('C4', 'Product Name');
        $sheet->setCellValue('D4', 'Warehouse');
        $sheet->setCellValue('E4', 'Quantity');
        $sheet->setCellValue('F4', 'Price');

        $column = 5;
        foreach ($sales as $key => $value) {
            $sheet->setCellValue('A' . $column, $value->sale_number);
            $sheet->setCellValue('B' . $column, $value->contact_name);
            $sheet->setCellValue('C' . $column, $value->product_name);
            $sheet->setCellValue('D' . $column, $value->warehouse_name);
            $sheet->setCellValue('E' . $column, $value->sale_qty);
            $sheet->setCellValue('F' . $column, $value->sale_price);
            $column++;
        }

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);


        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename= Data Penjual '.$tags.'.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }
    
    public function user_point(){
        $user = $this->userPointModel
        ->select([
            'user_point.id',
            'user_point.contact_id',
            'sum(point_in) as points',
            'user_point.date as point_date',
            'contacts.name as contact_name',
        ])
        ->join('contacts','user_point.contact_id = contacts.id','left')
        ->where('contacts.is_member !=', NULL)
        ->groupBy('contacts.id')->get()->getResultObject();
        
        $data = ([
            'user'  => $user,
            'db'    => $this->db,
        ]);
        
        return view('modules/user_point',$data);
    }
    
    public function redeem_point(){
        $user = $this->userPointModel
        ->select([
            'user_point.contact_id',
            'sum(point_in) as points',
            'user_point.id',
            'user_point.point_in',
            'contacts.name as contact_name',
            'user_point.date as point_date',
        ])
        ->join('contacts', 'user_point.contact_id = contacts.id','left')
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
        $value->join('contacts', 'user_redeem.contact_id = contacts.id','left');
        $value->join('administrators', 'user_redeem.admin_id = administrators.id','left');
        $value->orderBy('user_redeem.dates','desc');
        $value = $value->get();
        $value = $value->getResultObject();
            
        $data = ([
            'user'  => $user,
            'db'    => $this->db,
            'value' => $value,
        ]);
        
        return view('modules/redeem_points', $data);
    }
    
    public function redeem_point_manage($id, $user){
        $header = $this->pointExchangeModel
        ->select([
            'point_exchange.contact_id',    
            'contacts.name as contact_name',
            'point_exchange.exchange_date',
            'user_address.address as member_address',
        ])
        ->join('contacts', 'point_exchange.contact_id = contacts.id','left')
        ->join('user_address', 'point_exchange.contact_id = user_address.contacts_id', 'left')
        ->get()->getFirstRow();
        
        $warehouses = $this->warehouseModel
        ->where('warehouses.trash', 0)
        ->whereIn('warehouses.id', [1,2,3,4,5,6,8,9])
        ->orderBy('warehouses.name', 'asc')->get()->getResultObject();
        
        $products = $this->pointExchangeModel
        ->select([
            'point_exchange.product_id',
            'products.name as product_name',
        ])
        ->where('point_exchange.contact_id', $user)
        ->where('point_exchange.is_claimed !=', NULL)
        ->orderBy('products.name','asc')
        ->join('products', 'point_exchange.product_id = products.id','left')
        ->get()->getResultObject();
        
        $data = ([
            'db'  => $this->db,
            'header'  => $header,
            'products' => $products,
            'warehouses'  => $warehouses,
        ]);
        
        return view('modules/redeem_point', $data);
    }
    
    public function add_customer_redeeem(){
        $user_redeem = $this->db->table('user_redeem');
        $user_redeem->selectMax('id');
        $user_redeem = $user_redeem->get();
        $user_redeem = $user_redeem->getFirstRow();    
        $user_redeem = $user_redeem->id;
        $id = $user_redeem + 1;
            
        $number_redeem = "RDM".date("dmy").$id;
        $dates = $this->request->getPost('dates');
            
        $admin = $this->session->login_id;

        $customers = $this->request->getPost('customers');

        $this->userRedeemModel
        ->insert([
            'admin_id'  => $admin,
            'number'    => $number_redeem,
            'dates'     => $dates,
            'contact_id' => $customers,
        ]);

        $this->session->setFlashData('message_type','success');
        $this->session->setFlashData('message_content','Berhasil Menambahkan Data');
            
        return redirect()->back();
    }
    
    public function user_redeem_manage($id){
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
        $datas->join('contacts','user_redeem.contact_id = contacts.id','left');
        $datas->join('administrators','user_redeem.admin_id = administrators.id','left');
        $datas->orderBy('user_redeem.id','desc');
        $datas->where('user_redeem.id', $id);
        $datas = $datas->get();
        $datas = $datas->getFirstRow();
            
        $products = $this->pointExchangeModel
        ->select([
            'point_exchange.id',
            'point_exchange.product_id',
            'products.name as product_name',
        ])
        ->where('is_claimed', 1)
        ->where('is_redeemed', NULL)
        ->where('point_exchange.contact_id', $datas->contact_id)
        ->orderBy('products.name','asc')
        ->join('products', 'point_exchange.product_id = products.id','left')
        ->get()->getResultObject();
    
        $items = $this->db->table('redeem_items')
        ->select([
            'redeem_items.id',
            'products.name as product_name',
            'redeem_items.quantity as redeem_qty',
        ])        
        ->join('products','redeem_items.product_id = products.id', 'left')
        ->where('user_redeem_id', $id)
        ->orderBy('redeem_items.id', 'desc')
        ->get()->getResultObject();
    
        $warehouses = $this->warehouseModel
        ->select([
            'warehouses.*',
            'sum(product_stocks.quantity) as stock',
        ])
        ->join('product_stocks','warehouses.id = product_stocks.warehouse_id','left')
        ->where('warehouses.trash', 0)
        ->whereIn('warehouses.id', [1,2,3,4,5,6,8,9])
        ->groupBy('warehouses.id')
        ->orderBy('warehouses.name', 'asc')->get()->getResultObject();
                        
        $data = ([
            'datas' => $datas,
            'items' => $items,
            'db'    =>$this->db,
            'products' => $products,
            'warehouses'  => $warehouses,
        ]);
      
        return view('modules/redeem_manage',$data);
    }
    
    public function add_product_redeem(){
        $id = $this->request->getPost('id');
        $contacts = $this->request->getPost('contacts');
        $prods = $this->request->getPost('products');
        $warehouses = $this->request->getPost('warehouses');

        $exchanges = $this->pointExchangeModel
        ->where('id', $prods)
        ->get()
        ->getFirstRow();

        $this->redeemItemModel
        ->insert([
            'product_id'    => $exchanges->product_id,
            'user_redeem_id'    => $id,
            'quantity'      => 1,
        ]);

        $this->productStockModel
        ->insert([
            'quantity'  => -1,
            'voucher_id'  => $prods,
            'date'  => date('Y-m-d'),
            'product_id'    =>  $exchanges->product_id,
            'warehouse_id'  =>  $warehouses,
        ]);

        $this->pointExchangeModel
        ->where('id', $prods)
        ->where('contact_id', $contacts)
        ->set([
            'is_redeemed'   => 1,
        ])->update();

        $this->session->setFlashData('message_type', 'success');
        $this->session->setFlashData('message_content', 'Produk Berhasil Di Redeem!');
 
        return redirect()->back();
    }
    
    public function purchases(){
        $purchases = $this->PurchaseOrderModel
        ->select([
            'purchase_order.id',
            'purchase_order.date',
            'purchase_order.keterangan',
            'contacts.name as contact_name',
            'purchase_order.number as purchase_number',
        ])
        ->join('contacts','purchase_order.supplier_id = contacts.id','left')
        ->orderBy('purchase_order.id','desc')->get()->getResultObject();

        $data = ([
            'db'    => $this->db,
            'purchases' => $purchases,
        ]);

        return view('modules/purchases',$data);
    }
    

    public function purchases_manage($id){

        $headers = $this->PurchaseOrderModel
        ->select([
            'purchase_order.id',
            'contacts.name as contact_name',
            'administrators.name as admin_name',
            'purchase_order.date as purchase_date',
            'purchase_order.number as purchase_number',
        ])
        ->join('contacts','purchase_order.supplier_id = contacts.id','left')
        ->join('administrators','purchase_order.admin_id = administrators.id','left')
        ->where('purchase_order.id',$id)->get()->getFirstRow();

        $purchases = $this->purchaseOrderItemModel
        ->select([
            'products.id as product_id',
            'products.name as product_name',
            'purchase_order_item.id as item_id',
            'products.sku_number as product_sku',
            'purchase_order_item.quantity as purchase_quantity',
        ])
        ->join('products','purchase_order_item.product_id = products.id','left')
        ->where('purchase_order_id',$id)
        ->get()->getResultobject();

        $data = ([
            'db'    => $this->db,
            'headers'   => $headers,
            'purchases' => $purchases,
        ]);

        return view('modules/purchases_manages',$data);
    }

    public function approve_purchase_order($id) {
        $date = $this->request->getPost('date');
        $quantity = $this->request->getPost('quantity');
        $products = $this->request->getPost('product_id');

        $this->purchaseOrderItemModel->where('id',$id)
        ->set([
            'ready' => 1,
        ])->update();

        $approved = $this->purchaseOrderItemModel->where('id', $id)->get()->getFirstRow();

        if ($approved->ready != 0) {
            $this->productStockModel->insert([
                'date'  => $date,
                'quantity'  => $quantity,
                'product_id' => $products,
                'purchase_order_id' => $approved->purchase_order_id,
            ]);
        } 

        $this->session->setFlashdata('message_type', 'successs');
        $this->session->setFlashdata('message_content', 'Data berhasil ditambahkan');

        return redirect()->back();
    }
    
    public function histori_pengiriman(){
        $sales = $this->saleModel
        ->select([
            'sales.number as sale_number',
            'sales.time_done as sale_done',
            'contacts.name as contact_name',
            'sales.time_create as sale_create',
            'manifest_so.time as manifest_create',
            'deliveries.date as delivery_create',
            'FLOOR(SUM(TIMESTAMPDIFF(SECOND, sales.time_create, sales.time_done)) / 60) as total_minutes',
        ])
        ->join('deliveries','sales.id = deliveries.sale_id', 'left')
        ->join('manifest_so','sales.id = manifest_so.sale_id','left')
        ->join('contacts','sales.contact_id = contacts.id','left')
        ->orderBy('sales.id','desc')
        ->where('sales.contact_id !=', NULL)
        ->where('sales.time_create !=', NULL)
        ->groupBy('sales.id')
        ->get()->getResultObject();

        $data = ([
            'db'    => $this->db,
            'sales' => $sales,
        ]);

        return view('modules/histori_pengiriman', $data);
    }
    
    public function report_histori_pengiriman()
    {
        
        $sales = $this->saleModel->where('contact_id !=', NULL)->orderBy('sales.id','desc')->get()->getResultObject();

        $data = ([
            'db'    => $this->db,
            'sales'  => $sales,
        ]);

        return view('modules/report_histori_pengiriman',$data);
    }
    
    public function export_histori_pengiriman(){
        $roles = $this->request->getGet('roles');
        $tanggalawal = $this->request->getGet('tanggalawal');
        $tanggalakhir = $this->request->getGet('tanggalakhir');

        $sales = $this->saleModel
        ->select([
            'sales.number as sale_number',
            'sales.time_done as sale_done',
            'sales.tags as sale_tags',
            'contacts.name as contact_name',
            'sales.time_create as sale_create',
            'manifest_so.time as manifest_create',
            'deliveries.date as delivery_create',
        ])
        ->join('administrators', 'sales.admin_id = administrators.id', 'left')
        ->join('contacts', 'sales.contact_id = contacts.id', 'left')
        ->join('manifest_so', 'sales.id = manifest_so.sale_id', 'left')
        ->join('deliveries', 'sales.id = deliveries.sale_id', 'left')
        ->where('administrators.role',$roles)
        ->where('sales.time_create!=',  NULL)
        ->where('sales.contact_id !=', NULL)
        ->where('sales.transaction_date >=', $tanggalawal)
        ->where('sales.transaction_date <=', $tanggalakhir)
        ->orderBy('sales.id', 'desc')
        ->get()->getResult();

        $spreadsheet =  new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Data Histori Pengiriman');
        $sheet->mergeCells('A1:G1');

        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getFont()->setSize(14);
        $sheet->getStyle('A1:G1')->getFont()->setBold(true);


        $sheet->getStyle('A3:G3')->getFont()->setBold(true);

        $sheet->setCellValue('A3', 'Nomer Sales Order');
        $sheet->setCellValue('B3', 'Nama Pelanggan');
        $sheet->setCellValue('C3', 'Sales Order Dibuat');
        $sheet->setCellValue('D3', 'Tags');
        $sheet->setCellValue('E3', 'Manifest Dicetak');
        $sheet->setCellValue('F3', 'Surat Jalan Dicetak');
        $sheet->setCellValue('G3', 'Sales Order Selesai');

        $column = 4;
        foreach ($sales as $key => $value) {
            $sheet->setCellValue('A' . $column, $value->sale_number);
            $sheet->setCellValue('B' . $column, $value->contact_name);
            $sheet->setCellValue('C' . $column, $value->sale_create);
            $sheet->setCellValue('D' . $column, $value->sale_tags ? $value->sale_tags : "-");
            $sheet->setCellValue('E' . $column, $value->manifest_create);
            $sheet->setCellValue('F' . $column, $value->delivery_create);
            $sheet->setCellValue('G' . $column, $value->sale_done);
            $column++;
        }

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);


        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename= Data Histori Pengiriman.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }
    
    public function purchase_order_export($id){
        $good_purchase = $this->PurchaseOrderModel
        ->select([
            'contacts.name as contact_name',
            'products.name as product_name',
            'products.unit as product_unit',
            'products.sku_number as product_sku',
            'purchase_order.date as purchase_date',
            'purchase_order.keterangan as purchase_keterangan',
            'purchase_order_item.quantity as purchase_quantity',
        ])
        ->join('contacts', 'purchase_order.supplier_id = contacts.id', 'left')
        ->join('purchase_order_item', 'purchase_order.id = purchase_order_item.purchase_order_id', 'left')
        ->join('products', 'purchase_order_item.product_id = products.id', 'left')
        ->where('purchase_order.id', $id)
        ->get()->getResultObject();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Data Purchase Order');
        $sheet->mergeCells('A1:C1');

        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getFont()->setSize(14);

        $sheet->setCellValue('A2', 'SKU Produk');
        $sheet->setCellValue('B2', 'Nama Produk');
        $sheet->setCellValue('C2', 'Jumlah Purchase Order');

        $sheet->getStyle('A2:C2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle('A2:C2')->getFont()->setSize(12);
        $sheet->getStyle('A2:C2')->getFont()->setBold(true);

        $column = 3;
        foreach ($good_purchase as $value) {
            $sheet->setCellValue('A'.$column, $value->product_sku);
            $sheet->setCellValue('B'.$column, $value->product_name);
            $sheet->setCellValue('C'.$column, $value->purchase_quantity);
            $column++;
        }

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename=Data Purchase Order.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();

    }
    
    public function getReportOrdered()
    {
        $saleItems = $this->saleItemModel
        ->select(["sale_items.quantity as sale_qty", "sale_items.product_id", "sales.number as sale_number", "sales.status", "sales.transaction_date", "sale_items.id"])
        ->join("sales", "sale_items.sale_id = sales.id", "left")
        ->where("sales.id IS NOT NULL")
        ->where("sale_items.product_id IS NOT NULL")
        ->orderBy("sales.transaction_date", "desc")
        ->findAll();
        
        $products = $this->productModel
        ->select(["name as product_name", "id", "sku_number"])
        ->whereIn("id", array_column($saleItems, "product_id"))
        ->findAll();
        
        $delivery = $this->deliveryModel
        ->select(["quantity as QtyKeluar", "sale_item_id"])
        ->whereIn("sale_item_id", array_column($saleItems, "id"))
        ->findAll();
        
        $prepare = $this->prepareReportOrderedData($saleItems, $products, $delivery);
        
        return $prepare;
    }
    
    protected function prepareReportOrderedData($saleItems, $products, $delivery)
    {
        $data = [];
        foreach($saleItems as $item){
            $rowData = [
                // "products" => $this->findProductName($products, $item->product_id),
                "sale_number" => $item->sale_number,
                "transaction_date" => $item->transaction_date,
                "sale_qty" => $item->sale_qty,
                // "QtyKeluar" => $this->findStockOut($delivery, $item->id)
            ];
            
            $data[] = $rowData;
        }
        
        return $data;
    }
    
    protected function findProductName($products, $targetID)
    {
        foreach($products as $product){
            if($product->id == $targetID){
                return [
                    "sku_number" => $product->sku_number,
                    "product_name" => $product->product_name
                ];
            }
        }
        
        return ["sku_number" => NULL, "product_name" => NULL];
    }
    
    protected function findStockOut($delivery, $saleItemID)
    {
        foreach($delivery as $item){
            if($item->sale_item_id == $saleItemID){
                return $item->QtyKeluar;
            }   
        }
        
        return 0;
    }
    
    public function report_ordered(){
        $items = $this->saleItemModel
        ->select([
            'sales.status',
            'products.sku_number',
            'sales.transaction_date',
            'sales.number as sale_number',
            'products.name as product_name',
            'sale_items.quantity as sale_qty',
            'delivery_items.quantity as QtyKeluar',
        ])
        ->join('delivery_items','sale_items.id = delivery_items.sale_item_id','left')
        ->join('products','sale_items.product_id = products.id','left')
        ->join('sales','sale_items.sale_id = sales.id','left')
        ->where('sales.id !=', NULL)
        ->where('products.id !=', NULL)
        ->orderBy('sales.transaction_date','desc') 
        ->groupBy('sales.id')
        ->get()->getResultObject();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1','Data Barang Di Pesan');
        $sheet->mergeCells('A1:F1');
        $sheet->mergeCells('A2:F2');

        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getFont()->setSize(14);
        $sheet->getStyle('A1:G1')->getFont()->setBold(true);

        $sheet->getStyle('A4:F4')->getFont()->setBold(true);
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A4', 'Nomer SKU');
        $sheet->setCellValue('B4', 'Nama Produk');
        $sheet->setCellvalue('C4', 'Nomer Sales Order');
        $sheet->setCellValue('D4', 'Tanggal Transaksi');
        $sheet->setCellValue('E4', 'Jumlah Dipesan');
        $sheet->setCellValue('F4', 'Status Pengiriman');

        $column = 5;
        foreach ($items as $key => $value){

            $sheet->setCellValue('A'.$column, $value->sku_number);
            $sheet->setCellValue('B'.$column, $value->product_name);
            $sheet->setCellValue('C'.$column, $value->sale_number);
            $sheet->setCellValue('D'.$column, $value->transaction_date);
            $sheet->setCellValue('E'.$column, $value->sale_qty.' Unit');
            
            $QtyKeluar = empty($value->QtyKeluar)? 0 : $value->QtyKeluar;
            $QtySO = $value->sale_qty;

            if(($QtySO-$QtyKeluar) == 0){
                $statusSODetail = 'Dikirim';
                $sheet->setCellValue('F'.$column, $statusSODetail);

            }elseif(($QtySO-$QtyKeluar) > 0){
                $statusSODetail = 'Dikirim Sebagian';
                $sheet->setCellValue('F'.$column, $statusSODetail);
            }

            if(($QtySO-$QtyKeluar) == $QtySO){
                $statusSODetail = 'Disetujui';
                $sheet->setCellValue('F'.$column, $statusSODetail);
            }

            $column++;
        }

        $sheet->getStyle('A1:F1')->getFont()->setBold(true);
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename=Data Barang Dipesan.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }
    
    public function report_per_warehouse(){
        $data = [
            "warehouses" => $this->warehouseModel->select(["id", "name"])->where("trash", 0)->orderBy("name", "asc")->findAll()    
        ];
        
        return view("modules/report_per_warehouse", $data);
    }

    public function purchase_order(){
        $suppliers = $this->contactModel->where('trash', 0)->where('type', 1)->orderBy('contacts.name','asc')->get()->getResultObject();
        $products = $this->productModel->where('trash', 0)->orderBy('products.name','asc')->get()->getResultObject();

        $purchases = $this->PurchaseOrderModel
        ->select([
            'purchase_order.id',
            'purchase_order.date',
            'purchase_order.keterangan',
            'contacts.name as contact_name',
            'purchase_order.number as po_number',
        ])
        ->join('contacts','purchase_order.supplier_id = contacts.id', 'left')
        ->orderBy('purchase_order.id','asc')
        ->get()->getResultObject();

        $data = ([
            'suppliers'  => $suppliers,
            'products'  => $products,
            'purchases' => $purchases,
        ]);

        return view('modules/purchase_order', $data);
    }

    public function purchase_order_add(){
        $dates = $this->request->getPost('dates');
        $suppliers = $this->request->getPost('suppliers');
        $keterangan = $this->request->getPost('keterangan');

        $purchases = $this->db->table('purchase_order');
        $purchases->selectMax('id');
        $purchases = $purchases->get();
        $purchases = $purchases->getFirstRow();
        $purchases = $purchases->id;

        $id = $purchases + 1;
        $number_po = "AIO/".date("F/y")."/".$id;

        $this->PurchaseOrderModel->insert([
            'date'  => $dates,
            'number'    => $number_po,
            'supplier_id' => $suppliers,
            'keterangan' => $keterangan,
        ]);

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data berhasil dibuat!');

        return redirect()->to(base_url('product/purchase/order'));
    }

    public function purchase_order_manage($id){
        $data_purchase = $this->PurchaseOrderModel->where('purchase_order.id',$id)->get()->getFirstRow();

        if ($data_purchase != NULL) {

            $products = $this->productModel
            ->select([
                'products.id as product_id',
                'products.name as product_name',
                'products.sku_number as product_sku',
            ])
            ->orderBy('products.name','asc')
            ->where('trash', 0)
            ->get()->getResultObject();

            $good_purchase = $this->PurchaseOrderModel
            ->select([
                'purchase_order.id',
                'contacts.name as contact_name',
                'purchase_order.date as purchase_date',
                'purchase_order.number as purchase_number',
                'purchase_order.keterangan as purchase_keterangan',
            ])
            ->join('contacts', 'purchase_order.supplier_id = contacts.id','left')
            ->where('purchase_order.id',$id)->get()->getFirstRow();

            $good_purchase_item = $this->purchaseOrderItemModel
            ->select([
                'purchase_order_item.id',
                'products.name as product_name',
                'products.sku_number as product_sku',
                'purchase_order_item.purchase_order_id',
                'purchase_order_item.quantity as product_quantity',
            ])
            ->join('products','purchase_order_item.product_id = products.id', 'left')
            ->orderBy('purchase_order_item.id','left')->get()->getResultObject();

            $data = ([
                'db'    => $this->db,
                'products'  => $products,
                'good_purchase' => $good_purchase,
                'good_purchase_item' => $good_purchase_item,
            ]);

            return view('modules/purchase_order_manage',$data);

        } else {
            $this->session->setFlashdata('message_type','danger');
            $this->session->setFlashdata('message_content','Data barang tidak ada!');

            return redirect()->to(base_url('product/purchase/order'));
        }
    }

    public function purchase_order_add_item(){

        $quantity = $this->request->getPost('quantity');
        $products = $this->request->getPost('product_id');
        $id =   $this->request->getPost('purchase_order_id');

        $this->purchaseOrderItemModel->insert([
            'product_id' => $products,
            'quantity'   => $quantity,
            'purchase_order_id' => $id,
        ]);

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data barang berhasil di tambahkan');

        return redirect()->back();
    }

    public function purchase_order_delete($id){
        $items = $this->purchaseOrderItemModel
        ->where("purchase_order_id", $id)
        ->findAll();

        $header = $this->PurchaseOrderModel
        ->where('purchase_order.id', $id)
        ->first();

        foreach ($items as $item) {
            $this->purchaseOrderItemModel->where("id", $item->id)->delete();
        }

        $this->PurchaseOrderModel->delete($id);
        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data '.$header->number. ' Berhasil Di hapus');

        return redirect()->to(base_url('product/purchase/order'));
    }   

    public function purchase_order_items_delete($id, $items){
        $purchase_items = $this->purchaseOrderItemModel->find($items);

        if ($purchase_items) {

            $prods = $this->productModel->where('products.id', $purchase_items->product_id)->get()->getFirstRow();

            $this->purchaseOrderItemModel->where('id', $items)->delete();
            $this->session->setFlashdata('message_type', 'success');
            $this->session->setFlashdata('message_content', $prods->name .' Berhasil Di hapus Dari Daftar');

            return redirect()->to(base_url('purchase/order/manage/'.$id));

        } else {
            $this->session->setFlashdata('message_type', 'danger');
            $this->session->setFlashdata('message_content', 'Data tidak ditemukan');

            return redirect()->back();
        }
        
    }
    
    public function return_pemasok(){
    $pemasok = $this->contactModel->where('trash',0)->where('type',1)->orderBy('contacts.name','asc')->get()->getResultObject();

    $returns = $this->productReturnModel
    ->select([
        'product_returns.id',
        'contacts.name as contact_name',
        'product_returns.date as retur_date',
        'product_returns.number as number_retur',
        'product_returns.keterangan as keterangan',
        'warehouses.name as warehouse_name',
    ])
    ->join('contacts','product_returns.contact_id = contacts.id','left')
    ->join('administrators','product_returns.admin_id = administrators.id','left')
    ->join('warehouses', 'product_returns.warehouse_id = warehouses.id', 'left')
    ->orderBy('product_returns.id','desc')->get()->getResultObject();

    $data = ([
        'pemasok' => $pemasok,
        'returns' => $returns,
        'db'      => $this->db, 
    ]);

    return view('modules/return_pemasok',$data);
}

    public function return_pemasok_add(){
    $return_pemasok = $this->db->table('product_returns');
    $return_pemasok->selectMax('id');
    $return_pemasok = $return_pemasok->get();
    $return_pemasok = $return_pemasok->getFirstRow();

    $return_pemasok = $return_pemasok->id;
    $id = $return_pemasok + 1;
    $number_retur = "SRP/".date("y")."/".$id;
    $dates = $this->request->getPost('dates');
    $contacts = $this->request->getPost('contact_id');
    $keterangan = $this->request->getPost('keterangan');
    $warehouses = $this->request->getPost('warehouse_id');

    $this->productReturnModel->insert([
        'date'       => $dates,
        'admin_id'   => $this->session->login_id,
        'contact_id' => $contacts,
        'keterangan' => $keterangan,
        'number'     => $number_retur,
        'warehouse_id'  => $warehouses,
    ]);

    return redirect()->to(base_url('return/pemasok'));
}

    public function return_pemasok_manage($id){
    $data_retur = $this->productReturnModel->where(['product_returns.id' => $id])->first();

    if($data_retur != NULL) {
        $goods = $this->productStockModel
        ->select([
            'products.id as product_id',
            'products.name as product_name',
        ])
        ->join('products','product_stocks.product_id = products.id','left')
        ->whereIn('warehouse_id', [7,10])
        ->groupBy('products.name')
        ->get()->getResultObject();

        $good_retur = $this->productReturnModel
        ->select([
            'product_returns.date',
            'contacts.name as contact_name',
            'product_returns.id as pemasok_id',
            'administrators.name as admin_name',
            'warehouses.name as warehouse_name',
            'product_returns.files as retur_files',
            'product_returns.number as retur_number',
            'product_returns.keterangan as keterangan',
        ])
        ->join('contacts', 'product_returns.contact_id = contacts.id', 'left')
        ->join('warehouses', 'product_returns.warehouse_id = warehouses.id', 'left')
        ->join('administrators', 'product_returns.admin_id = administrators.id', 'left')
        ->where('product_returns.id', $id)->get()->getFirstRow(); 
 
        $retur_item = $this->productReturnItemModel
        ->select([
            'product_returns_item.files as retur_files',
            'products.name as product_name',
            'product_returns_item.quantity',
            'product_returns_item.id as return_item_id',
        ])
        ->join('products', 'product_returns_item.product_id = products.id', 'left')
        ->where('product_returns_item.return_pemasok_id', $id)
        ->get()->getResultObject();

        $data = ([
            'db' => $this->db,
            'goods' => $goods,
            'good_retur' => $good_retur,
            'retur_item' => $retur_item,
        ]);

        return view('modules/return_pemasok_manage', $data);

        }else{
            $this->session->setFlashdata('message_type', 'success');
            $this->session->setFlashdata('message_content', 'Data tidak ditemukan');
            return redirect()->to(base_url('return/pemasok'));
        }
    }
    
    public function return_pemasok_add_items(){
    $date = $this->request->getPost('dates');
    $retur_id = $this->request->getPost('retur_id');
    $products = $this->request->getPost('product_id');
    $quantity = $this->request->getPost('quantity');
    $warehouses = $this->request->getPost('warehouse_id');

    $this->productReturnItemModel->insert([
        "quantity"      => $quantity,
        "product_id"    => $products,
        "return_pemasok_id"  => $retur_id,
    ]);

    $returID = $this->productReturnItemModel->getInsertID();

    $qtyStock = 0 - $quantity;
    $this->productStockModel->insert([
        'date'          => $date,
        "product_id"    => $products,
        "quantity"      => $qtyStock,
        "warehouse_id"  => $warehouses,
        "product_return_pemasok_id" => $returID,
    ]);

    $this->session->setFlashdata('message_type', 'success');
    $this->session->setFlashdata('message_content', 'Data berhasil ditambahkan');

    return redirect()->to(base_url('return/pemasok/manage') . '/' . $retur_id);
    }

    public function return_pemasok_print($good_retur){
    $data_returs = $this->productReturnModel
    ->select([
        'product_returns.id',
        'contact_id',
        'number as retur_number',
        'admin_id',
        'keterangan',
        'date',
    ])
    ->where('product_returns.id', $good_retur)->get()->getFirstRow();

    $item_returs = $this->productReturnItemModel
    ->select([
        'products.name as product_name',
        'product_returns_item.quantity',
    ])
    ->join('products', 'product_returns_item.product_id = products.id', 'left')
    ->where('product_returns_item.return_pemasok_id', $good_retur)
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

    return view('modules/retur_pemasok_print', $data);
    }

    public function return_pemasok_delete($id){
    $items = $this->productReturnItemModel
    ->where("return_pemasok_id", $id)
    ->findAll();

    foreach ($items as $item) {
        $this->productReturnItemModel->where("id", $item->id)->delete();
        $this->productStockModel->where("product_return_pemasok_id", $item->id)->delete();
    }

    $this->productReturnModel->delete($id);
    $this->session->setFlashdata('message_type', 'success');
    $this->session->setFlashdata('message_content', 'Retur Pemasok Berhasil Dihapus');

    return redirect()->to(base_url('return/pemasok'));
    }

    public function return_pemasok_item_delete($id, $items){
    $returPemasokItem = $this->productReturnItemModel->find($items);

    if ($returPemasokItem) {
        $this->productReturnItemModel->where('id', $items)->delete();
        $this->productStockModel->where('product_return_pemasok_id', $items)->delete();

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Produk Berhasil Di Hapus');

        return redirect()->to(base_url('return/pemasok/manage/'. $id));

    } else {
        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Produk gagal dihapus');

     return redirect()->to(base_url('return/pemasok/manage/'. $id));
 
    } 
    }
    
    public function return_pemasok_insert_file(){
        $id = $this->request->getPost('id');

        $returns = $this->productReturnItemModel
        ->select('product_returns_item.return_pemasok_id')
        ->where('product_returns_item.return_pemasok_id', $id)
        ->get()->getFirstRow();


        $validationRule = [
            'file' => [
                'label' => 'File',
                'rules' => 'uploaded[file]',
            ],
        ];

        if (! $this->validate($validationRule)) {
            print_r($this->validator->getErrors());
            $errors = $this->validator->getErrors();
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', $errors['file']);

            return redirect()->back();
        }

        $filename = $_FILES['file']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $rename_file = "Receipt_retur_".$id."_".date("dmYHis").".".$ext;
        $uploaddir = './public/return_pemasok/';
        $alamatfile = $uploaddir . $rename_file;

        move_uploaded_file($_FILES['file']['tmp_name'], $alamatfile);

        $this->productReturnItemModel
        ->where("product_returns_item.id",$id)
        ->set(["files"=>$rename_file])
        ->update();

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', "Berkas Retur Berhasil Di upload");

        return redirect()->back();
    }
    
    public function stokOpname(){
        $stokOpname = $this->stokOpnameModel->select(["stok_opname.id", "stok_opname.date", "stok_opname.number", "warehouses.name"])->join("warehouses", "warehouses.id = stok_opname.warehouse_id", "left")->orderBy('stok_opname.id','desc')->get()->getResultObject();
        $warehouses = $this->warehouseModel->orderBy('trash', 0)->get()->getResultObject();

        $data = ([
            'db'    => $this->db,
            'stokOpname'    => $stokOpname,
            'warehouses'    => $warehouses,
        ]);

        return view('modules/stokopname',$data);
    }

    public function stokOpname_insert_first(){

        $date = $this->request->getPost('date');
        $warehouses = $this->request->getPost('warehouses');

        $data_stok_opname = $this->db->table('stok_opname');
        $data_stok_opname->selectMax('id');
        $data_stok_opname = $data_stok_opname->get();
        $data_stok_opname = $data_stok_opname->getFirstRow();

        $data_stok_opname = $data_stok_opname->id;

        $no_doc = $data_stok_opname + 1;

        $number_document = "SOP/".date("y")."/".date("m")."/".$no_doc;

        $this->stokOpnameModel->insert([
            'date'  => $date,
            'number'    => $number_document,
            'admin_id'  => $this->session->login_id,
            'warehouse_id' => $warehouses,
        ]);

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data stok opname berhasil diinput');

        return redirect()->to(base_url('stok_opname'));
    }

    public function stokOpname_manage($id){
        $data_stokOpname = $this->stokOpnameModel->get()->getFirstRow();
            if ($data_stokOpname != NULL) {
        $goods = $this->productModel->where(['trash' => 0])->orderBy('name','asc')->findAll();
        $warehouses = $this->warehouseModel->where('trash',0)->orderBy('warehouses.name','desc')->findAll();

        $stokOpname = $this->stokOpnameModel
        ->join('warehouses', 'stok_opname.warehouse_id = warehouses.id','left')
        ->join('administrators','stok_opname.admin_id = administrators.id','left')
        ->select([
         'stok_opname.id',
         'stok_opname.warehouse_id',
         'warehouses.name as warehouse_name',
         'stok_opname.number as number_document',
         'administrators.name as admin_name',
        ])
        ->where('stok_opname.id',$id)
        ->get()->getFirstRow();

        $stokOpname_items = $this->stokItemOpnameModel  
        ->join('products','stok_item_opname.product_id = products.id','left')
        ->select([
            'stok_item_opname.id',
            'products.name as product_name',
            'stok_item_opname.quantity',
        ])  
        ->where('id_stok_opname',$id)
        ->get()->getResultObject();

        $data = ([ 
            'products' => $goods,
            'db'    => $this->db,
            'warehouses'    => $warehouses, 
            'stokOpname'    => $stokOpname,
            'stokOpname_items'  => $stokOpname_items,
        ]); 

        return view('modules/stok_opname_manage',$data);

        } else {
            $this->session->setFlashdata('message_type','warning');
            $this->session->setFlashdata('message_content','Data Tidak Ditemukan');
            return redirect()->to(base_url('stok_opname'));
        } 
    }

    public function stok_opname_item(){
    $quantity = $this->request->getPost('quantity');
    $products = $this->request->getPost('product_id');
    $id_opname = $this->request->getPost('id_stok_opname');

    $this->stokItemOpnameModel->insert([
        'date' => date('Y-m-d H:i:s'),
        'quantity'      => $quantity,
        'product_id'    => $products,
        'id_stok_opname' => $id_opname,
    ]);

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data produk berhasil ditambahkan!');

        return redirect()->to(base_url('stok_opname/manage/'.$id_opname));
    } 

    public function export_stok_opname($id){ 
    $datas = $this->stokOpnameModel
    ->join('warehouses', 'stok_opname.warehouse_id = warehouses.id', 'left')
    ->join('administrators', 'stok_opname.admin_id = administrators.id', 'left')
    ->join('stok_item_opname', 'stok_opname.id = stok_item_opname.id_stok_opname', 'left')
    ->join('products', 'stok_item_opname.product_id = products.id', 'left')
    ->select([
        'warehouses.id as warehouse_id',
        'warehouses.name as warehouse_name',
        'products.name as product_name',
        "products.sku_number as skunumber",
        'administrators.name as admin_name',
        'stok_opname.date as stokOpname_date',
        'stok_item_opname.date as stok_time',
        'stok_opname.number as stok_opname_number',
        'stok_item_opname.quantity as stok',
    ])
    ->where('stok_opname.id', $id)
    ->orderBy('stok_opname.id', 'asc')
    ->get()->getResultObject();

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set title headers
    $sheet->setCellValue('A1', 'AIO STORE');
    $sheet->setCellValue('A2', 'Stok Opname '.$datas[0]->admin_name.' Tanggal '. $datas[0]->stokOpname_date);
    $sheet->setCellValue('A4', $datas[0]->warehouse_name);

    // Merge title headers
    $sheet->mergeCells('A1:D1');
    $sheet->mergeCells('A2:D2');
    $sheet->mergeCells('A3:D3');
    $sheet->mergeCells('A4:D4');

    // Styling for title headers
    $spreadsheet->getActiveSheet()
    ->getStyle('A1:A4')
    ->getAlignment()
    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

    $spreadsheet->getActiveSheet()
    ->getStyle('B4:C4')
    ->getAlignment()
    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

    $spreadsheet->getActiveSheet()
    ->getStyle('A1:A3')
    ->getFont()
    ->setSize(14);

    // Set column headers
    $sheet->setCellValue('A5', 'SKU Produk');
    $sheet->setCellValue('B5', 'Nama Produk');
    $sheet->setCellValue('C5', 'Waktu Stok Opname');
    $sheet->setCellValue('D5', 'Quantity');

    $column = 6;
    foreach ($datas as $item) {
        $sheet->setCellValue('A' . $column, $item->skunumber);
        $sheet->setCellValue('B' . $column, $item->product_name);
        $sheet->setCellValue('C' . $column, $item->stok_time);
        $sheet->setCellValue('D' . $column, $item->stok);
        $column++;
    }

    // Styling for column headers
    $sheet->getStyle('A4:F4')->getFont()->setBold(true);
    $sheet->getStyle('A5:F5')->getFont()->setBold(true);

    // Set column width to auto-fit
    $sheet->getColumnDimension('A')->setAutoSize(true);
    $sheet->getColumnDimension('B')->setAutoSize(true);
    $sheet->getColumnDimension('C')->setAutoSize(true);
    $sheet->getColumnDimension('D')->setAutoSize(true);

    // Sending the file to the browser for download
    $writer = new Xlsx($spreadsheet);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename=Data Stok Opname.xlsx');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
    exit();
    }

    public function stok_opname_delete_item($id,$items){

        $stokOpnameItem = $this->stokItemOpnameModel->find($items);

        if ($stokOpnameItem) {
            $this->stokItemOpnameModel->delete($items);
            $this->session->setFlashdata('message_type', 'success');
            $this->session->setFlashdata('message_content', 'Data berhasil dihapus'); 
        return redirect()->to(base_url('stok_opname/manage/'.$id));

        } else {
            $this->session->setFlashdata('message_type', 'danger');
            $this->session->setFlashdata('message_content', 'Data gagal dihapus');
            return redirect()->to(base_url('stok_opname/manage/'.$id));
        }

        return redirect()->to(base_url('stok_opname/manage/'.$id));
    }

    public function stok_opname_delete($id){
        $this->stokOpnameModel->delete($id);
        $this->stokItemOpnameModel->where('id_stok_opname',$id)->delete();
        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data Stok Opname berhasil dihapus');

        return redirect()->to(base_url('stok_opname'));
    }
    
    public function brands_index(){
        $brands = $this->brandModel
        ->select([
            'brands.id',
            'brands.brand_name',
            'brands.brand_code',
        ])
        ->orderBy('brands.brand_name','asc')
        ->get()->getResultObject();

        $data = ([
            'db' => $this->db,
            'brands' => $brands
        ]);

        return view('modules/brands',$data);
    }

    public function brands_add(){
        $brand_name = $this->request->getPost('brand_name');
        $brand_code = $this->request->getPost('brand_code');

        $this->brandModel->insert([
            'brand_name'    => $brand_name,
            'brand_code'    => $brand_code,
        ]);

        $this->session->setFlashdata('message_type','success');
        $this->session->setFlashdata('message_content', 'Data brand berhasil ditambahkan ke dalam stok aio');

        return redirect()->to(base_url('brands'));
    }

    public function brands_delete($id){
        $this->brandModel->delete($id);

        $this->session->setFlashdata('message_type','success');
        $this->session->setFlashdata('message_content', 'Data brand berhasil dihapus');

        return redirect()->to(base_url('brands'));

    }
    
    public function status_approve(){
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
        ->join('locations','sales.location_id = locations.id','left')
        ->join('administrators','sales.admin_id = administrators.id','left')
        ->where("contact_id !=",NULL)
        ->where("payment_id !=",NULL)
        ->where('sales.status',2)
        ->orderBy("transaction_date","desc")
        ->orderBy("id","desc")->findAll();

        $data = ([
            "sales" => $sales,  
            "db"    => $this->db,
        ]);
        
        return view('modules/sales_approve', $data);
    }

    public function status_dikirim_sebagian(){
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
        ->join('locations','sales.location_id = locations.id','left')
        ->join('administrators','sales.admin_id = administrators.id','left')
        ->where("contact_id !=",NULL)
        ->where("payment_id !=",NULL)
        ->where('sales.status',4)
        ->orderBy("transaction_date","desc")
        ->orderBy("id","desc")->findAll();

        $data = ([
            "sales" => $sales,  
            "db"    => $this->db,
        ]);
        
        return view('modules/sales_dikirim_sebagian', $data);
    }

    public function status_dikirim(){
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
        ->join('locations','sales.location_id = locations.id','left')
        ->join('administrators','sales.admin_id = administrators.id','left')
        ->where("contact_id !=",NULL)
        ->where("payment_id !=",NULL)
        ->where('sales.status', 5)
        ->orderBy("transaction_date","desc")
        ->orderBy("id","desc")->findAll();

        $data = ([
            "sales" => $sales,  
            "db"    => $this->db,
        ]);
        
        return view('modules/sales_dikirim', $data);
    }

    public function status_selesai(){
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
        ->join('locations','sales.location_id = locations.id','left')
        ->join('administrators','sales.admin_id = administrators.id','left')
        ->where("contact_id !=",NULL)
        ->where("payment_id !=",NULL)
        ->where('sales.status', 6)
        ->orderBy("transaction_date","desc")
        ->orderBy("id","desc")->findAll();

        $data = ([
            "sales" => $sales,  
            "db"    => $this->db,
        ]);
        
        return view('modules/sales_selesai', $data);
    }
    
    public function report_activity_customer()
    {
        $customers = $this->contactModel->where('trash', 0)->orderBy('contacts.name','asc')->findAll();
        $data = ([
            'db' => $this->db,
            'customers' => $customers,
        ]);

        return view('modules/report_activity_customers', $data);
    }

    public function data_activity_customer(){
    $tanggalawal = $this->request->getGet('tanggalawal');
    $tanggalakhir = $this->request->getGet('tanggalakhir');
    $customerName = $this->request->getGet('customerName');

    $query = $this->saleModel
    ->select([
      'sales.id as sales_id',
      'sales.number as sale_number',
      'contacts.name as contact_name',
      'products.name as product_name',
      'sales.transaction_date as sale_date',
      'contacts.address as contact_address',
      'sale_items.quantity as sale_quantity', 
    ])
    ->join('contacts','sales.contact_id = contacts.id','left')
    ->join('sale_items','sales.id = sale_items.sale_id','left')
    ->join('products', 'sale_items.product_id = products.id', 'left')
    ->where('sales.contact_id !=', NULL)
    ->orderBy('sales.id','desc');

        if (!empty($tanggalawal)) {
            $query->where('sales.transaction_date >=', $tanggalawal);
        }

        if (!empty($tanggalakhir)) {
            $query->where('sales.transaction_date <=', $tanggalakhir);
        }

        if (!empty($customerName != "-- Pilih Pelanggan --")) {
            $query->where('sales.contact_id', $customerName);
        }

        $customers = $query->get()->getResultObject();

        $data = ([ 
            "db"=> $this->db, 
            "customers" => $customers,
            "tanggalawal" => $tanggalawal,
            "tanggalakhir" => $tanggalakhir, 
        ]);

        return view("modules/data_activity_customer", $data);        
    }

    public function report_produk_keluar(){
        $categories = $this->productCategoriesModel->orderBy('name','asc')->findAll();
        $data = ([
            'db' => $this->db,
            'categories'  => $categories,
        ]);
        return view('modules/report_barang_keluar',$data);
    }

    public function subcategory(){
        $subcategories = $this->SubCategoriesModel->orderBy('name','asc')->findAll();
        $categories = $this->productCategoriesModel->orderBy('name','asc')->findAll();
        
        $codes = $this->codeModel
        ->where("trash", 0)
        ->orderBy("name", "asc")
        ->findAll();

        $data = ([
            'db' => $this->db,
            'subcategori'  => $subcategories,
            'categories' => $categories,
            'codes' => $codes,
        ]);
        return view('modules/products_subcategories',$data);
    }

    public function add_subcategori(){
        $category = $this->request->getpost('categori');
        $namecode = $this->request->getpost('codes');
        $subcategory = $this->request->getpost('subcategori');

        $this->SubCategoriesModel->insert([
            'category_id' => $category,
            'code' => $namecode,
            'name' => $subcategory,
        ]);

        $this->session->setFlashData('message_type', 'success');
        $this->session->setFlashData('message_content', 'Data Berhasil Di Diinput!');
    
        return redirect()->back();
    }
    
    public function activity_approval(){
        $sale_items = $this->saleItemModel
        ->select('sale_items.date as date')
        ->select('sale_items.price')
        ->select('sale_items.price_level')
        ->select('sales.number as sale_number')
        ->select('administrators.name as admin_name')
        ->join('sales','sale_items.sale_id = sales.id','left')
        ->join('administrators','sale_items.admin_approve_id = administrators.id','left')
        ->orderBy('sale_items.id','desc')
        ->where("sale_items.need_approve >",0)
        ->where("sale_items.admin_approve_id >",0)
        ->get()
        ->getResultObject();

        $data = ([
            "sale_items" => $sale_items,
            "db" => $this->db,
        ]);

        return view('modules/activity_approval',$data);
    }
    
    public function report_barang_masuk(){
        $buys = $this->db->table('buys')->orderBy('buys.id', 'desc')->get()->getResultObject();
        $products = $this->goodsModel->orderBy('products.name','asc')->where('trash', 0)->get()->getFirstRow();
        
        $data = ([
           'db' => $this->db,
           'buys'       => $buys,
           'products'   => $products,
        ]);
        return view('modules/report_barang_masuk', $data);
    }
  
    public function report_penggunaan_harga(){
        return view('modules/report_penggunaan_harga');
    }
    
    public function report_activity_approval(){
        return view('modules/report_activity_approve');
    }
    
    public function report_status(){
        return view("modules/report_setuju");
    }
  
    public function ajax_sale_product_prices(){
        $id = $this->request->getPost('product'); 
        $product = $this->productModel->where("id",$id)->first(); 
        $rumus = $this->productPriceModel->where("id",$product->price_id)->first();

        $margins = ([
            0, 
            $rumus->plus_one,
            $rumus->plus_two,
            $rumus->plus_three,
            $rumus->plus_four,
            $rumus->plus_five,
            $rumus->plus_six,
            $rumus->plus_seven,
            $rumus->plus_eight,
            $rumus->plus_nine,
            $rumus->plus_ten,
        ]);

        $arrayPrices = ([0]);

        $thisPrice = floatval($product->price);
        array_push($arrayPrices,$thisPrice);
        
        for($p = 2; $p <= 10; $p++){
            $thisPrice += $margins[$p];
            array_push($arrayPrices, $thisPrice);
        }

        for($x = 1; $x <= 10; $x++){
            if(config("Login")->loginRole == 2){
                if($x <= 3){

                }elseif($x == 4){
                    echo"<option value='".$arrayPrices[$x]."-".$x."' class='price-option-need-approve'>($x) Rp. ".number_format($arrayPrices[$x],0,",",".")."</option>";
                }else{
                    echo"<option value='".$arrayPrices[$x]."-".$x."'>($x) Rp. ".number_format($arrayPrices[$x],0,",",".")."</option>";
                }
            }elseif(config("Login")->loginRole == 3){
                if($x <= 1){

                }elseif($x == 2){ 
                    echo"<option value='".$arrayPrices[$x]."-".$x."' class='price-option-need-approve'>($x) Rp. ". number_format($arrayPrices[$x],0,",",".")."</option>";
                }else{ 
                    echo"<option value='".$arrayPrices[$x]."-".$x."'>($x) Rp. ".number_format($arrayPrices[$x],0,",",".")." </option>";
                } 
            }else{ 
                echo"<option value='".$arrayPrices[$x]."-".$x."'>($x) Rp. ".number_format($arrayPrices[$x],0,",",".")."</option>"; 
            } 
        } 
    } 
  
    public function report_produk(){
        
        $data = [
            "brand" => $this->brandModel->whereNotIn("id", [57,58,59,60,61,62,63,64])->findAll()  
        ];
        
   	    return view('modules/report_produk', $data); 
    }

 
  	public function report_userso(){
       $administrators = $this->adminModel
        ->select('administrators.id admin_id')
        ->select('administrators.username as admin_username')
        ->select('administrators.email as admin_email')
        ->select('administrators.name as admin_name')
        ->select('administrators.phone as admin_phone')
        ->select('administrators.role as admin_role')
        ->where('administrators.role >=',2)
        ->where('administrators.role <=',3)
        ->where('administrators.active !=',0)
        ->orderBy('administrators.username','asc')
        ->findAll();

        $adminname = $this->request->getGet('adminname');
        $data = ([
            "administrators" => $administrators,
            "db"    => $this->db,
        ]);
        return view('modules/report_userso', $data);
    }
  
    public function reports_()
    {
        return view('modules/reports_');
    }
    
    public function reportss_()
    {
        return view('modules/reportss_');
    }
  
    public function report_setuju(){
        return view('modules/report_setuju');
    }

    public function report_kirim(){
        return view('modules/report_kirim');
    }

    public function report_selesai(){
        return view('modules/report_selesai');
    }
  
  	public function reports_so(){
      return view('modules/reports_so');
    }
  
  	public function report_umurbarang()
    {
      return view('modules/report_umurbarang');
    }
    
    public function report_per_products()
    {
        return view("modules/report_per_products");
    }
    
    public function report_pergerakan_barang()
    {
        $prod_id = $this->productModel->where('trash',0)->orderBy('products.name','asc')->findAll();
        $data = ([
            'db' => $this->db,
            'prod_id' => $prod_id,
        ]);

        return view('modules/report_pergerakanbarang',$data);
    }

  	public function report_pergerakan_barangs()
    {
        $productName = $this->request->getGet('productName');
        $tanggalawal = $this->request->getGet('tanggalawal');
        $tanggalakhir = $this->request->getGet('tanggalakhir');

        $query = $this->productStockModel
        ->select([
            'buys.id as buys_id',
            'sales.id as sales_id',
            'contacts.name as contact_name',
            'return_sales.id as returns_id',
            'warehouse_transfers.id as transfersw_id',
            'products.sku_number',
            'products.name as product_name',
            'products.id as products_id',
            'product_stocks.date as movement_date',
            'buys.number as purchase_delivery_number',
            'warehouse_transfers.number as tf_number',
            'warehouse_transfers.date as tf_date',
            'buys.date as purchase_date',
            'buy_items.quantity as purchase_quantity',
            'sales.number as sales_order_number',
            'sales.transaction_date as sales_date',
            'sale_items.quantity as sales_quantity',
            'warehouse_transfers_items.quantity as tf_quantity',
            'product_stocks.quantity',
            'product_stocks.sale_item_id',
            'product_stocks.date as prod_date',
            'product_stocks.warehouse_transfer_id',
            'warehouses.name as warehouse_name',
            'product_stocks.product_return_id',
            'return_sales.number as return_number',
            'return_sales.date as retur_date',
            'return_item.quantity as retur_qty',
        ])
        ->join('warehouse_transfers_items','product_stocks.warehouse_transfer_id =warehouse_transfers_items.id','left')
        ->join('warehouse_transfers','warehouse_transfers_items.warehouse_transfers_id = warehouse_transfers.id','left')
        ->join('products', 'product_stocks.product_id = products.id', 'left')
        ->join('buy_items', 'product_stocks.buy_item_id = buy_items.id', 'left')
        ->join('buys', 'buy_items.buy_id = buys.id', 'left')
        ->join('sale_items', 'product_stocks.sale_item_id = sale_items.id', 'left')
        ->join('sales', 'sale_items.sale_id = sales.id', 'left')
        ->join('contacts','sales.contact_id = contacts.id', 'left')
        ->join('warehouses','product_stocks.warehouse_id = warehouses.id', 'left')
        ->join('return_item','product_stocks.product_return_id = return_item.id', 'left')
        ->join('return_sales','return_item.retur_id = return_sales.id','left')
        ->orderBy('products.name', 'asc');
        
        if (!empty($tanggalawal)) { 
            $query->where('product_stocks.date >=', $tanggalawal);
        }

        if (!empty($tanggalakhir)) {
            $query->where('product_stocks.date <=', $tanggalakhir);
        }

        if (!empty($productName != "-- Pilih Produk --")) {
            $query->where('product_stocks.product_id', $productName);
        }
        
        $products = $query->get()->getResultObject();

        $data = ([ 
            "db"=> $this->db, 
            "products" => $products,
            "tanggalawal" => $tanggalawal,
            "tanggalakhir" => $tanggalakhir, 
        ]);

        return view("modules/pergerakan_barang",$data);
    }
  
    public function products_manage($id){
        $product = $this->productModel->where("id",$id)->where("trash",0)->first();
        $capacity = $this->capacityModel->get()->getResultObject();
        
        $category = $this->productCategoriesModel->where("id",$product->category_id)->first();
        $code = $this->codeModel->where("id",$product->code_id)->first();
        
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
        
        $thisFormula = $this->productPriceModel
        ->where("id",$product->price_id)
        ->first();

        $data = ([
            "session"   => $this->session,
            "capacity"  => $capacity,
            "product"   => $product,
            "thisCategory"   => $category,
            "thisCode"   => $code,
            "thisFormula"   => $thisFormula,
            "categories"   => $categories,
            "prices"   => $prices,
            "codes"   => $codes,
            "db"        => $this->db,
            "validation" => $this->validation,
            "brands" => $this->brandModel->findAll()
        ]);

        return view("modules/product_manage",$data);
    }
    public function product_save_price(){
        $id = $this->request->getPost("id");
        $price = $this->request->getPost("price");

        $this->productModel
        ->where("id",$id)
        ->set([
            "price" => $price
        ])
        ->update();

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Harga utama berhasil disimpan');

        return redirect()->to(base_url('products/'.$id.'/manage'));
    }
    public function product_save_margin(){
        $product = $this->request->getPost('product');
        $id = $this->request->getPost('id');
        $level = $this->request->getPost('level');
        $margin = $this->request->getPost('margin');



        if($id == 0){
            $this->productPriceModel->insert([
                "product_id"    => $product,
                "level"         => $level,
                "percentage"    => $margin,
                "date_created"  => date('Y-m-d'),
            ]);
        }else{
            $this->productPriceModel->where("id",$id)->set([
                "percentage"    => $margin,
                "date_created"  => date('Y-m-d'),
                "approve_owner_status"  => 1,
                "approve_spv_retail_status"  => 1,
                "approve_spv_grosir_status"  => 1,
                "owner_id"  => NULL,
                "spv_retail_id" => NULL,
                "spv_grosir_id" => NULL,
                "date_owner_approve" => NULL,
                "date_spv_retail_approve" => NULL,
                "date_spv_grosir_approve" => NULL,
            ])->update();
        }

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Margin harga berhasil disimpan');

        return redirect()->to(base_url('products/'.$product.'/manage'));
    }


    public function product_repairs(){
        $products = $this->productModel->where("trash",0)->orderBy("name","asc")->findAll();
        $customers = $this->contactModel
        ->where("type",2)
        ->where("trash",0)
        ->orderBy("name","asc")
        ->findAll();

        $warehouses = $this->warehouseModel->where("trash",0)->orderBy("name","asc")->findAll();

        $repairs = $this->db->table("product_repairs");
        $repairs->select("product_repairs.id as 'repair_id'");
        $repairs->select("product_repairs.date as 'repair_date'");
        $repairs->select("product_repairs.details as 'repair_details'");
        $repairs->select("product_repairs.quantity as 'repair_qty'");
        $repairs->select("products.name as 'product_name'");
        $repairs->select("products.unit as 'product_unit'");
        $repairs->select("contacts.name as 'contact_name'");
        $repairs->select("contacts.phone as 'contact_phone'");
        $repairs->select("contacts.address as 'contact_address'");
        $repairs->select("warehouses.name as 'warehouse_name'");
        $repairs->join("products","product_repairs.product_id=products.id","left");
        $repairs->join("contacts","product_repairs.contact_id=contacts.id","left");
        $repairs->join("warehouses","product_repairs.warehouse_id=warehouses.id","left");
        $repairs->orderBy("product_repairs.date","desc");
        $repairs->orderBy("product_repairs.id","desc");

        $repairs = $repairs->get();
        $repairs = $repairs->getResultObject();

        $data = ([
            "products" => $products,
            "warehouses" => $warehouses,
            "customers" => $customers,
            "repairs"=>$repairs,
        ]);

        return view("modules/product_repairs",$data);
    }
    
    public function product_repairs_add(){
        $customer = $this->request->getPost('customer');
        $product = $this->request->getPost('product');
        $warehouse = $this->request->getPost('warehouse');
        $date = $this->request->getPost('date');
        $qty = $this->request->getPost('qty');
        $details = $this->request->getPost('details');

        $this->productRepairModel->insert([
            "product_id"    => $product,
            "contact_id" => $customer,
            "warehouse_id" => $warehouse,
            "date" => $date,
            "quantity" => $qty,
            "details" => $details
        ]);
        $idRepairItem = $this->productRepairModel->getInsertID();
        $qty_stock = 0 - $qty;
        $this->productStockModel->insert([
            "product_id"    => $product,
            "warehouse_id" => $warehouse,
            "product_repair_id" => $idRepairItem,
            "date"  => date("Y-m-d"),
            "quantity"  => $qty_stock,
        ]);

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data perbaikan (service) produk berhasil ditambah');

        return redirect()->to(base_url('products/repairs'));
    }
    
    public function product_repairs_delete($id){
        $this->productRepairModel->delete($id);

        $this->productStockModel->where("product_repair_id",$id)->delete();
        
        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data perbaikan (service) produk berhasil dihapus');

        return redirect()->to(base_url('products/repairs'));
    }
    
    public function product_repairs_ajax_edit(){
        $id = $this->request->getPost("id");
        $repair = $this->productRepairModel->where("id",$id)->first();
        echo json_encode($repair);
    }
    
    public function product_repairs_save(){
        $id = $this->request->getPost("id");
        $customer = $this->request->getPost('customer');
        $product = $this->request->getPost('product');
        $warehouse = $this->request->getPost('warehouse');
        $date = $this->request->getPost('date');
        $qty = $this->request->getPost('qty');
        $details = $this->request->getPost('details');

        $this->productRepairModel->where("id",$id)->set([
            "product_id"    => $product,
            "contact_id" => $customer,
            "warehouse_id" => $warehouse,
            "date" => $date,
            "quantity" => $qty,
            "details" => $details
        ])->update();

        $qty_stock = 0 - $qty;
        $this->productStockModel->where("product_repair_id",$id)->set([
            "product_id"    => $product,
            "warehouse_id" => $warehouse,
            "quantity"  => $qty_stock,
        ])->update();

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data perbaikan (service) produk berhasil disimpan');

        return redirect()->to(base_url('products/repairs'));
    }

    public function product_displays(){
        $products = $this->productModel->where("trash",0)->orderBy("name","asc")->findAll();        
        $warehouses = $this->warehouseModel->where("trash",0)->orderBy("name","asc")->findAll();

        $displays = $this->db->table("product_displays");
        $displays->select("product_displays.id as 'display_id'");
        $displays->select("product_displays.date as 'display_date'");
        $displays->select("product_displays.quantity as 'display_qty'");
        $displays->select("products.name as 'product_name'");
        $displays->select("products.unit as 'product_unit'");
        $displays->select("warehouses.name as 'warehouse_name'");
        $displays->join("products","product_displays.product_id=products.id","left");
        $displays->join("warehouses","product_displays.warehouse_id=warehouses.id","left");
        $displays->orderBy("product_displays.date","desc");
        $displays->orderBy("product_displays.id","desc");

        $displays = $displays->get();
        $displays = $displays->getResultObject();

        $data = ([
            "products" => $products,
            "warehouses" => $warehouses,
            "displays"=>$displays,
        ]);

        return view("modules/product_displays",$data);
    }
    
    public function product_displays_add(){
        $product = $this->request->getPost('product');
        $warehouse = $this->request->getPost('warehouse');
        $date = $this->request->getPost('date');
        $qty = $this->request->getPost('qty');
        $details = $this->request->getPost('details');

        $this->productDisplayModel->insert([
            "product_id"    => $product,
            "warehouse_id" => $warehouse,
            "date" => $date,
            "quantity" => $qty,
            "details" => $details
        ]);
        $idDisplayItem = $this->productDisplayModel->getInsertID();
        $qty_stock = 0 - $qty;
        $this->productStockModel->insert([
            "product_id"    => $product,
            "warehouse_id" => $warehouse,
            "product_display_id" => $idDisplayItem,
            "date"  => date("Y-m-d"),
            "quantity"  => $qty_stock,
        ]);

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data produk berhasil ditambah');

        return redirect()->to(base_url('products/stokOpname'));
    }
    
    public function product_displays_delete($id){
        $this->productDisplayModel->delete($id);

        $this->productStockModel->where("product_display_id",$id)->delete();
        
        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data display produk berhasil dihapus');

        return redirect()->to(base_url('products/stokOpname'));
    }
    
    public function product_displays_ajax_edit(){
        $id = $this->request->getPost("id");
        $display = $this->productDisplayModel->where("id",$id)->first();
        echo json_encode($display);
    }
    
    public function product_displays_save(){
        $id = $this->request->getPost("id");
        $product = $this->request->getPost('product');
        $warehouse = $this->request->getPost('warehouse');
        $date = $this->request->getPost('date');
        $qty = $this->request->getPost('qty');
        $details = $this->request->getPost('details');

        $this->productDisplayModel->where("id",$id)->set([
            "product_id"    => $product,
            "warehouse_id" => $warehouse,
            "date" => $date,
            "quantity" => $qty,
            "details" => $details
        ])->update();

        $qty_stock = 0 - $qty;
        $this->productStockModel->where("product_display_id",$id)->set([
            "product_id"    => $product,
            "warehouse_id" => $warehouse,
            "quantity"  => $qty_stock,
        ])->update();

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data display produk berhasil disimpan');

        return redirect()->to(base_url('products/stokOpname'));
    }

    public function product_stocks(){
        $stocks = $this->db->table("product_stocks");
        $stocks->select("product_stocks.id as 'stock_id'");
        $stocks->select("product_stocks.qty_recorded as 'stock_qty_recorded'");
        $stocks->select("product_stocks.qty_real as 'stock_qty_real'");
        $stocks->select("product_stocks.quantity as 'stock_qty'");
        $stocks->select("product_stocks.date as 'stock_date'");
        $stocks->select("product_stocks.details as 'stock_details'");
        $stocks->select("products.name as 'product_name'");
        $stocks->select("products.unit as 'product_unit'");
        $stocks->select("warehouses.name as 'warehouse_name'");
        $stocks->join("products","product_stocks.product_id=products.id","left");
        $stocks->join("warehouses","product_stocks.warehouse_id=warehouses.id","left");
        $stocks->orderBy("product_stocks.date","desc");
        $stocks->orderBy("product_stocks.id","desc");
        $stocks->where("sale_item_id",NULL);
        $stocks->where("buy_item_id",NULL);

        $stocks = $stocks->get();
        $stocks = $stocks->getResultObject();

        $data = ([
            "stocks" => $stocks,
        ]);

        return view("modules/product_stocks",$data);
    }
    
    public function product_stocks_add(){
        $products = $this->productModel->where("trash",0)->orderBy("name","asc")->findAll();
        $warehouses = $this->warehouseModel->where("trash",0)->orderBy("name","asc")->findAll();

        $data = ([
            "products"   => $products,
            "warehouses" => $warehouses,
        ]);

        return view("modules/product_stocks_add",$data);
    }
    
    public function product_stocks_add_ajax_qty_recorded(){
        $product = $this->request->getPost('product');
        $warehouse = $this->request->getPost('warehouse');

        $stocks = $this->db->table("product_stocks");
        $stocks->selectSum("quantity");
        $stocks->where("product_id",$product);
        $stocks->where("warehouse_id",$warehouse);

        $stocks = $stocks->get();
        $stocks = $stocks->getFirstRow();

        if($stocks->quantity <= 0){
            echo "0";
        }else{
            echo $stocks->quantity;
        }
    }
    
    public function product_stocks_insert(){
        $warehouse = $this->request->getPost('warehouse');
        $product = $this->request->getPost('product');
        $qty_recorded = $this->request->getPost('qty_recorded');
        $qty_real = $this->request->getPost('qty_real');
        $qty_custom = $this->request->getPost('qty_custom');
        $date = $this->request->getPost('date');
        $details = $this->request->getPost('details');

        $this->productStockModel->insert([
            "warehouse_id"    => $warehouse,
            "product_id"    => $product,
            "qty_recorded"          => $qty_recorded,
            "qty_real"          => $qty_real,
            "quantity"          => $qty_custom,
            "details"          => $details,
            "date"          => $date,
        ]);

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data penyesuaian persediaan produk berhasil ditambah');

        return redirect()->to(base_url('products/stocks'));
    }
    
    public function product_stocks_delete($id){
        $this->productStockModel->delete($id);

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data penyesuaian persediaan produk berhasil dihapus');

        return redirect()->to(base_url('products/stocks'));
    }

    public function product_locations(){
        $products = $this->productModel->where("trash",0)->orderBy("name","asc")->findAll();
        $warehouses = $this->warehouseModel
            ->where("trash", 0)
            ->orderBy("name", "asc")
            ->findAll();

        $categories = $this->productCategoryModel
            ->where("trash", 0)
            ->orderBy("name", "asc")
            ->findAll();

        $codes = $this->codeModel
            ->where("trash", 0)
            ->orderBy("name", "asc")
            ->findAll();

        $data = ([
            "products"  => $products,
            "warehouses"          => $warehouses,
            "categories"          => $categories,
            "codes"          => $codes,
            "db"=> $this->db,
        ]);

        return view("modules/product_locations",$data);
    }
    public function product_location_manage($id){
        $product = $this->productModel->where("id",$id)->where("trash",0)->first();

        if($product == NULL){
            return redirect()->to(base_url('dashboard'));
        }

        $code = $this->codeModel->where("id",$product->code_id)->first();
        $category = $this->productCategoriesModel->where("id",$product->category_id)->first();

        $warehouses = $this->warehouseModel
            ->where("trash", 0)
            ->orderBy("name", "asc")
            ->findAll();

        $stocks = $this->db->table("product_stocks");
        $stocks->selectSum("quantity");
        $stocks->where("product_id",$id);
    
        $stocks = $stocks->get();
        $stocks = $stocks->getFirstRow();
    
        if($stocks->quantity <= 0){
            $thisStock = 0;
        }else{
            $thisStock =  $stocks->quantity;
        }

        $data = ([
            "product"   => $product,
            "stock"   => $thisStock,
            "code"          => $code,
            "category" =>   $category,
            "warehouses" => $warehouses,
            "db"          => $this->db,
        ]);

        return view("modules/product_location_manage",$data);
    }
    public function product_location_save(){
        $product = $this->request->getPost('product');
        $warehouse = $this->request->getPost('warehouse');
        $qty = $this->request->getPost('qty');

        $stocks = $this->db->table("product_stocks");
        $stocks->selectSum("quantity");
        $stocks->where("product_id",$product);
    
        $stocks = $stocks->get();
        $stocks = $stocks->getFirstRow();
    
        if($stocks->quantity <= 0){
            $thisStock = 0;
        }else{
            $thisStock =  $stocks->quantity;
        }

        $countQty = count($qty);

        $sumQty = 0;
        for($q = 0; $q <= $countQty-1; $q++){
            $sumQty += $qty[$q];
        }

        if($sumQty > $thisStock){
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', 'Data gagal disimpan, melebihi persediaan aktif');

            return redirect()->to(base_url('product/'.$product.'/location/manage'));
        }

        $countWarehouses = count($warehouse);
        
        for($w = 0; $w <= $countWarehouses-1; $w++){
            $existWarehouse = $this->productLocationModel
            ->where("product_id",$product)
            ->where("warehouse_id",$warehouse[$w])->first();
            
            if($existWarehouse != NULL){
                $this->productLocationModel
                ->where("product_id",$product)
                ->where("warehouse_id",$warehouse[$w])
                ->set(["quantity"=>$qty[$w]])->update();
            }else{
                $this->productLocationModel
                ->insert([
                    "warehouse_id"=>$warehouse[$w],
                    "product_id"   => $product,
                    "quantity"          => $qty[$w],
                ]);
            }
        }

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data lokasi produk berhasil disimpan');

        return redirect()->to(base_url('product/'.$product.'/location/manage'));
    }

    public function product_prices(){
        $prices = $this->productPriceModel->orderBy("code","asc")->findAll();

        $data = ([
            "prices" => $prices,
        ]);

        return view("modules/product_prices",$data);
    }
    public function product_prices_add(){
        $code = $this->request->getPost('code');

        $this->productPriceModel->insert([
            "code" => $code,
        ]);

        $idPrice = $this->productPriceModel->getInsertID();

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Rumus harga berhasil dibuat');

        return redirect()->to(base_url('products/prices/'.$idPrice.'/manage'));
    }
    public function product_prices_manage($id){
        $price = $this->productPriceModel->where("id",$id)->first();

        if(!$price){
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', 'Data tidak ditemukan');

            return redirect()->to(base_url('dashboard'));
        }

        $variables = $this->productPriceVariableModel->where("product_price_id",$id)->orderBy("define","asc")->findAll();
        $formulas = $this->productPriceFormulaModel->where("product_price_id",$id)->orderBy("level","asc")->findAll();

        $data = ([
            "price"=> $price,
            "variables"=> $variables,
            "formulas"=> $formulas,
        ]);

        return view("modules/product_price_manage",$data);
    }
    public function product_prices_variables_add(){
        $price = $this->request->getPost('price');
        $name = $this->request->getPost('name');
        $value = $this->request->getPost('value');

        $this->productPriceVariableModel->insert([
            "product_price_id"=>$price,
            "define"    => $name,
            "value" => $value,
        ]);

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Variable berhasil ditambahkan');

        return redirect()->to(base_url('products/prices/'.$price.'/manage'));
    }
    public function product_prices_formulas_add(){
        $price = $this->request->getPost('price');
        $level = $this->request->getPost('level');
        $formula = $this->request->getPost('formula');

        $this->productPriceFormulaModel->insert([
            "product_price_id"=>$price,
            "level"    => $level,
            "formula" => $formula,
        ]);

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Rumus berhasil ditambahkan');

        return redirect()->to(base_url('products/prices/'.$price.'/manage'));
    }
    public function product_prices_save(){
        $id = $this->request->getPost('id');
        $code = $this->request->getPost('code');
        $prices = $this->request->getPost('prices');

        $this->productPriceModel->where("id",$id)
        ->set([
            "code"  => $code,
            "plus_two" => $prices[0],
            "plus_three" => $prices[1],
            "plus_four" => $prices[2],
            "plus_five" => $prices[3],
            "plus_six" => $prices[4],
            "plus_seven" => $prices[5],
            "plus_eight" => $prices[6],
            "plus_nine" => $prices[7],
            "plus_ten" => $prices[8],
        ])->update();

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Rumus berhasil disimpan');

        return redirect()->to(base_url('products/prices/'.$id.'/manage'));
    }
    public function product_prices_ajax_simulation(){
        $formula = $this->request->getPost('formula');
        $price = $this->request->getPost('price');
        
        $rumus = $this->productPriceModel->where("id",$formula)->first();

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

        $arrayPrices = ([0,0]);

        $thisPrice = $price;
        for($p = 2; $p <= 10; $p++){
            $thisPrice += $margins[$p];
            // $thisPrice = (round(($thisPrice + config("App")->priceRound / 2) / config("App")->priceRound) * config("App")->priceRound);
            array_push($arrayPrices, $thisPrice);
        }

        echo json_encode($arrayPrices);
    }

	public function promo_types(){ 
        $types = $this->promoTypeModel->orderBy("name","asc")->findAll();

        $data = ([
            "types" => $types,
        ]);

        return view("modules/promo_types",$data);
    }
    public function promo_types_add(){
        $name = $this->request->getPost('name');

        $this->promoTypeModel->insert([
            "name" => $name,
        ]);

        $uncategorized = $this->promoTypeModel->where("name",config("App")->uncategorized)->first();

        if(!$uncategorized){
            $this->promoTypeModel->insert([
                "name" => config("App")->uncategorized,
            ]);
        }

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data jenis promo berhasil ditambah');

        return redirect()->to(base_url('promo/types'));
    }
    
    public function promo_types_delete($id){
        $uncategorized = $this->promoTypeModel->where("name",config("App")->uncategorized)->first();        

        $this->promoModel->where("type_id",$id)->set(["type_id"=>$uncategorized->id])->update();

        $this->promoTypeModel->delete($id);

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data jenis promo berhasil dihapus');

        return redirect()->to(base_url('promo/types'));
    }
    public function promo_types_edit(){
        $id = $this->request->getPost('id');
        $name = $this->request->getPost('name');

        $this->promoTypeModel->where("id",$id)->set([
            "name" => $name,
        ])->update();

        $uncategorized = $this->promoTypeModel->where("name",config("App")->uncategorized)->first();

        if(!$uncategorized){
            $this->promoTypeModel->insert([
                "name" => config("App")->uncategorized,
            ]);
        }

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data jenis promo berhasil disimpan');

        return redirect()->to(base_url('promo/types'));
    }

    
    public function promo(){
        $types = $this->promoTypeModel->orderBy("name","asc")->findAll();
        $gifts = $this->productModel->where('trash',0)->orderBy("name","desc")->findAll();
        $products = $this->productModel->where("trash",0)->orderBy("name","asc")->findAll();
        $promoss = $this->promoModel->orderBy("date_start","desc")->orderBy("id","desc")->first();

        $promos = $this->db->table("promos");
        $promos->select([
            'promos.gifts',
            'promos.nominal',
            'promos.percentage',
            'promos.id as promo_id',
            'promos.code as promo_code',
            'promos.role as promo_role',
            'promo_types.name as type_name',
            'products.name as product_name',
            'promos.details as promo_details',
            'promos.type_id as promo_type_id',
            'promos.date_end as promo_date_end',
            'promos.date_start as promo_date_start',
            'promos.price_level as promo_price_level',
            'promos.date_created as promo_date_created',
        ]);
        $promos->join("promo_types","promos.type_id=promo_types.id","left");
        $promos->join("products","promos.product_id=products.id","left");
        $promos->orderBy("promos.date_start","desc");
        $promos->orderBy("promos.id","desc");
        $promos = $promos->get();
        $promos = $promos->getResultObject();

        $data = ([
            "types"    => $types,
            "gifts"    => $gifts,
            "products"    => $products,
            "promos"    => $promos,
            "promoss"    => $promoss,
            "db"    => $this->db,
        ]);

        return view("modules/promo",$data);
    }
    
    public function promo_add(){
        $type = $this->request->getPost('type');
        $product = $this->request->getPost('product');
        $code = $this->request->getPost('code');
        $nominal = $this->request->getPost('nominal');
        $percentage =  $this->request->getPost('percentage');
        $date_start = $this->request->getPost('date_start');
        $date_end = $this->request->getPost('date_end');
        $details = $this->request->getPost('details');
        $roles = $this->request->getPost('roles');

        $this->promoModel->insert([
            "role" => $roles,
            "type_id"  => $type,
            "product_id"  => $product,
            "code"  => $code,
            "date_created"  => date("Y-m-d"),
            "date_start"    => $date_start,
            "date_end"      => $date_end,
            "nominal"       => $nominal,    
            "percentage"    => $percentage,
            "details"       => $details,
            "force_inactive" => 0,
        ]);

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Promo berhasil ditambah');

    return redirect()->to(base_url('promo'));
    }

    public function promo_delete($id){
        $promoUse = $this->saleItemModel->where("promo_id",$id)->findAll(); 

        if($promoUse == NULL){
            $this->promoModel->delete($id);
            $this->session->setFlashdata('message_type', 'success');
            $this->session->setFlashdata('message_content', 'Promo berhasil dihapus');
        }else{
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', 'Promo gagal dihapus karena sudah pernah digunakan');
        }

        return redirect()->to(base_url('promo'));
    }

    public function promo_ajax_edit(){
        $id = $this->request->getPost('id');
        $row = $this->promoModel->where("id",$id)->first();
        echo json_encode($row);
    }

    public function promo_save(){
        $id = $this->request->getPost('id');
        $type = $this->request->getPost('type');
        $product = $this->request->getPost('product');
        $code = $this->request->getPost('code');
        $nominal = $this->request->getPost('nominal');
        $percentage = $this->request->getPost('percentage');
        $date_start = $this->request->getPost('date_start');
        $date_end = $this->request->getPost('date_end');
        $details = $this->request->getPost('details');

        $this->promoModel->where("id",$id)->set([
            "type_id"  => $type,
            "product_id"  => $product,
            "code"  => $code,
            "date_created"  => date("Y-m-d"),
            "date_start"    => $date_start,
            "date_end"      => $date_end,
            "percentage"    => $percentage,
            "nominal"       => $nominal,
            "details"       => $details,
            "force_inactive"        => 0,
        ])->update();

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Promo berhasil disimpan');

        return redirect()->to(base_url('promo'));
    }

    public function promo_gifts_manage($id){
        $promo = $this->db->table("promos");
        $promo->select('promos.gifts');
        $promo->select('promos.role as promo_role');
        $promo->select('promos.percentage');
        $promo->select('promos.nominal');
        $promo->select("promos.id as promo_id");
        $promo->select("promos.type_id as promo_type_id");
        $promo->select("promos.product_id as promo_product_id");
        $promo->select("promos.price_level as promo_price_level");
        $promo->select("promos.code as promo_code");
        $promo->select("promos.date_created as promo_date_created");
        $promo->select("promos.date_start as promo_date_start");
        $promo->select("promos.date_end as promo_date_end");
        $promo->select("promos.details as promo_details");
        $promo->select("promo_types.name as type_name");
        $promo->select("products.name as product_name");
        $promo->join("promo_types","promos.type_id=promo_types.id","left");
        $promo->join("products","promos.product_id=products.id","left");
        $promo->where("promos.id",$id);

        $promo = $promo->get();
        $promo = $promo->getFirstRow();

        if($promo == NULL){
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', 'Promo tidak ditemukan');

            return redirect()->to(base_url('promo'));
        }

        $bundlings =  $this->db->table("bundlings");
        $bundlings->select("bundlings.id as bundling_id");
        $bundlings->select("products.name as product_name");
        $bundlings->select("bundlings.price as price");
        $bundlings->join("products","bundlings.product_id=products.id","left");
        $bundlings->where("bundlings.promo_id",$id);
        $bundlings = $bundlings->get();
        $bundlings = $bundlings->getResultObject();

        $products = $this->productModel->where("trash",0)->orderBy("name","ASC")->findAll();

        $data = ([
            "db" => $this->db,
            "promo" => $promo,
            "products"=> $products,
            "bundlings"=> $bundlings,
        ]);

        return view("modules/promo_gifts",$data);
    }

    public function promo_gifts_add(){
        $promo = $this->request->getPost("promo");
        $product = $this->request->getPost("product");
        $price = $this->request->getPost("price");

        $this->bundlingModel->insert([
            "price" => $price,
            "promo_id"  => $promo,
            "product_id"  => $product,
            "quantity"  => 1,
        ]);

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Produk bundling berhasi ditambahkan');

        return redirect()->to(base_url('promo/'.$promo.'/gifts'));
    }

    public function promo_gifts_delete($promo,$gift){
        $this->bundlingModel->where(["id"  => $gift,])->delete();

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Produk bundling berhasi dihapus');

        return redirect()->to(base_url('promo/'.$promo.'/gifts'));
    }
    
    public function getSalesDataPerAllowedWarehouse()
    {
        $allow_warehouses = !empty(cek_session($this->session->get('login_id'))['allow_warehouses']) ? cek_session($this->session->get('login_id'))['allow_warehouses'] : '"1","2","3","4","5","6","7","8","9","10"';
        
        $builder = $this->db->table('sales')
        ->select('sales.id, number, transaction_date, administrators.name as admin_name, contacts.name as contact_name, contacts.phone as contact_phone,status, tags')
        ->join('administrators', 'sales.admin_id = administrators.id')
        ->join('contacts', 'sales.contact_id = contacts.id')
        ->where("sales.id in(
            select sale_id from sale_items as AA
            inner join product_stocks as BB on AA.id=BB.sale_item_id 
            where BB.warehouse_id in($allow_warehouses)
        )")
        ->orderBy('sales.id', 'desc');
        
        return DataTable::of($builder)
        ->setSearchableColumns(["sales.number", "sales.transaction_date", "contacts.name", "administrators.name"])
        ->toJson(true);
    }
    
    public function getSalesOrder()
    {
        // $allow_warehouses = !empty(cek_session($this->session->get('login_id'))['allow_warehouses']) ? cek_session($this->session->get('login_id'))['allow_warehouses'] : '"1","2","3","4","5","6","7","8","9","10"';
        
        $sales = $this->saleModel
        ->select(['sales.id', 'sales.number'])
        ->where("contact_id !=", NULL)
        ->where("payment_id !=", NULL)
        // ->where("Id in(
        //     select sale_id from sale_items as AA
        //     inner join product_stocks as BB on AA.id=BB.sale_item_id 
        //     where BB.warehouse_id in($allow_warehouses)
        // )")
        ->orderBy("transaction_date","desc")
        ->orderBy("id","desc")
        ->findAll();
        
        return $this->response->setJSON($sales);
    }
  
    public function sales() {
        $allow_warehouses = !empty(cek_session($this->session->get('login_id'))['allow_warehouses']) ? cek_session($this->session->get('login_id'))['allow_warehouses'] : '"1","2","3","4","5","6","7","8","9","10"';
        
        $sales = $this->db->table('sale_items as a');
        $sales->select([
            'b.id',
            'b.status',
            'b.transaction_date',
            'e.name as admin_name',
            'c.name as contact_name',   
            'b.number as sale_number',
        ]);
        $sales->join('sales as b', 'a.sale_id = b.id','left');
        $sales->join('contacts as c', 'b.contact_id = c.id','left');
        $sales->join('product_stocks as d', 'a.id = d.sale_item_id','left');
        $sales->join('administrators as e', 'b.admin_id = e.id','left');
        $sales->where('b.contact_id !=', NULL);
        $sales->where('b.payment_id !=', NULL);
        $sales->where('b.trash', 0);
        $sales->whereNotIn('d.warehouse_id', [$allow_warehouses]);
        $sales->orderBy('b.transaction_date','desc');
        $sales->groupBy('b.id');
        $sales = $sales->get();
        $sales = $sales->getResultObject();

        $data = ([
            'sales' => $sales,
            'db'  => $this->db,
        ]);

        return view("modules/sales",$data);
    }
    
    public function sales_manage($id){
        $sale = $this->saleModel->where("id",$id)->first();
        $delivery = $this->deliveryModel->where('deliveries.id',$id)->get()->getFirstRow();

        if($sale == NULL){
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', 'Data tidak ditemukan');

            return redirect()->to(base_url('dashboard'));
        }

        $contact = $this->contactModel
        ->where("id",$sale->contact_id)
        ->first();

        $admin = $this->adminModel
        ->where("id",$sale->admin_id)
        ->first();

        $warehouse = $this->warehouseModel
        ->where("id",$sale->warehouse_id)
        ->first();

        $payment = $this->paymentModel
        ->where("id",$sale->payment_id)
        ->first();
        
        $items = $this->saleItemModel
        ->where("sale_id",$id)
        ->findAll();
        
        $supir = $this->deliveryModel
        ->select('deliveries.driver_name')
        ->where("sale_id",$id)
        ->first();

        $deliveries = $this->deliveryModel
        ->where("sale_id",$id)
        ->orderBy("sent_date","desc")
        ->orderBy("id","desc")
        ->findAll();

        $data = ([
            "db"    => $this->db,
            "contact"  => $contact,
            "admin"  => $admin,
            "warehouse"=> $warehouse,
            "payment"=> $payment,
            "sale"  => $sale,
            "supir" => $supir,
            "items" => $items,
            "deliveries" => $deliveries,
            "delivery" => $delivery,
        ]);

        return view("modules/sales_manage",$data);
    }
    
    public function sales_invoice_print($id){
        $sale = $this->saleModel->where("id",$id)->first();

        if($sale == NULL){
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', 'Data tidak ditemukan');

            return redirect()->to(base_url('dashboard'));
        }

        if($sale->contact_id == NULL){
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', 'Data tidak ditemukan');

            return redirect()->to(base_url('dashboard'));
        }
        
        if($sale->payment_id == NULL){
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', 'Data tidak ditemukan');

            return redirect()->to(base_url('dashboard'));
        }

        $contact = $this->contactModel
        ->where("id",$sale->contact_id)
        ->first();

        $warehouse = $this->warehouseModel
        ->where("id",$sale->warehouse_id)
        ->first();

        $payment = $this->paymentModel
        ->where("id",$sale->payment_id)
        ->first();
        
        $items = $this->saleItemModel
        ->where("sale_id",$id)
        ->findAll();

        $data = ([
            "db"    => $this->db,
            "contact"  => $contact,
            "warehouse"=> $warehouse,
            "payment"=> $payment,
            "sale"  => $sale,
            "items" => $items,
        ]);

        return view("modules/print_sale_invoice",$data);
    }
    
    public function sales_manifest_print(){
        $number_one = $this->request->getPost('number1');
        $number_two = $this->request->getPost('number2');

        $sales1 = $this->saleModel
        ->select([
            "sales.number",
            "contacts.address",
            "sales.sales_notes",
            "sales.transaction_date",
            "contacts.name as contact_name",
            "administrators.name as admin_name",
        ])
        ->join('contacts', 'sales.contact_id = contacts.id','left')
        ->join('administrators', 'sales.admin_id = administrators.id','left')
        ->where('sales.id', $number_one)->get()->getFirstRow();

        $sales2 = $this->saleModel
        ->select([
            "sales.number",
            "contacts.address",
            "sales.sales_notes",
            "sales.transaction_date",
            "contacts.name as contact_name",
            "administrators.name as admin_name",
        ])
        ->join('contacts', 'sales.contact_id = contacts.id','left')
        ->join('administrators', 'sales.admin_id = administrators.id','left')
        ->where('sales.id', $number_two)->get()->getFirstRow();

        $datas1 = $this->saleItemModel
        ->select([
            "sale_items.quantity",
            "product_stocks.warehouse_id",
            "products.name as product_name",
        ])
        ->join('products','sale_items.product_id = products.id','left')
        ->join('product_stocks', 'sale_items.id = product_stocks.sale_item_id','left')
        ->where('sale_items.sale_id', $number_one)
        ->get()->getResultObject();

        $datas2 = $this->saleItemModel
        ->select([
            "sale_items.quantity",
            "product_stocks.warehouse_id",
            "products.name as product_name",
        ])
        ->join('products','sale_items.product_id = products.id','left')
        ->join('product_stocks', 'sale_items.id = product_stocks.sale_item_id','left')
        ->where('sale_items.sale_id', $number_two)
        ->get()->getResultObject();
        
        for ($i = 0; $i < 2; $i++) {
            $this->manifestSoModel->insert([
                'sale_id' => ($i == 0) ? $number_one : $number_two,
                'time' => date("Y-m-d H:i:s"),
            ]);
        }

        $data = ([
            'db'    => $this->db,
            'sales1' => $sales1,
            'sales2' => $sales2,
            'datas1' => $datas1,
            'datas2' => $datas2,
        ]);

        return view("modules/print_sale_manifest",$data); 
    }
    
    public function sales_drive_letter_print($id){
        $sale = $this->saleModel->where("id",$id)->first();

        if($sale == NULL){
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', 'Data tidak ditemukan');

            return redirect()->to(base_url('dashboard'));
        }

        if($sale->contact_id == NULL){
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', 'Data tidak ditemukan');

            return redirect()->to(base_url('dashboard'));
        }
        if($sale->payment_id == NULL){
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', 'Data tidak ditemukan');

            return redirect()->to(base_url('dashboard'));
        }

        $contact = $this->contactModel
        ->where("id",$sale->contact_id)
        ->first();

        $warehouse = $this->warehouseModel
        ->where("id",$sale->warehouse_id)
        ->first();

        $payment = $this->paymentModel
        ->where("id",$sale->payment_id)
        ->first();

        $vehicle = $this->vehicleModel
        ->where("id",$sale->vehicle_id)
        ->first();
        
        $items = $this->saleItemModel
        ->where("sale_id",$id)
        ->findAll();

        $data = ([
            "db"    => $this->db,
            "contact"  => $contact,
            "warehouse"=> $warehouse,
            "payment"=> $payment,
            "sale"  => $sale,
            "vehicle"  => $vehicle,
            "items" => $items,
        ]);

        return view("warehouse/print_sale_drive_letter",$data);
    }
    
    public function sales_set_status($id,$status){
        $saleData = $this->saleModel->where("id",$id)->first();
        if($status == 4){
            if($saleData->sent_date == NULL){
                $this->session->setFlashdata('message_type', 'warning');
                $this->session->setFlashdata('message_content', 'Data Surat Jalan Belum Lengkap');
            }
        }

        if($status == 5){
            if($saleData->shipping_receipt_file == NULL){
                $this->session->setFlashdata('message_type', 'warning');
                $this->session->setFlashdata('message_content', 'Berkas Surat Jalan Belum Diupload');
            }
        }

        $this->saleModel->where("id",$id)
        ->set([
            "time_done" => date("Y-m-d H:i:s"),
            "status"=>$status,
            ])->update();

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Status berhasil disimpan');

        if(config("Login")->loginRole == 7){
            return redirect()->to(base_url('owner/sales/'.$id.'/manage'));
        }else{
            return redirect()->to(base_url('sales/'.$id.'/manage'));
        }
    }
    
    public function sales_warehouse(){
        
        $allow_warehouses = !empty(cek_session($this->session->get('login_id'))['allow_warehouses']) ? cek_session($this->session->get('login_id'))['allow_warehouses'] : '"1","2","3","4","5","6","7","8","9","10"';
        
        $sales = $this->db->table('sale_items as a');
        $sales->select([
            'b.id',
            'b.status',
            'b.transaction_date',
            'e.name as admin_name',
            'c.name as contact_name',   
            'b.number as sale_number',
        ]);
        $sales->join('sales as b', 'a.sale_id = b.id','left');
        $sales->join('contacts as c', 'b.contact_id = c.id','left');
        $sales->join('product_stocks as d', 'a.id = d.sale_item_id','left');
        $sales->join('administrators as e', 'b.admin_id = e.id', 'left');
        $sales->where('b.contact_id !=', NULL);
        $sales->where('b.payment_id !=', NULL);
        $sales->where("status >=",2);
        $sales->where("status !=",3);
        $sales->where("b.trash", 0);
        $sales->whereNotIn('d.warehouse_id', [$allow_warehouses]);
        $sales->orderBy('b.transaction_date','desc');
        $sales->groupBy('b.id');
        $sales = $sales->get();
        $sales = $sales->getResultObject();

        $data = ([
            'sales' => $sales,
            'db'  => $this->db,
        ]);
 
        return view("modules/sales_warehouse",$data); 
    }
    
    public function sales_manage_warehouse($id){
        $sale = $this->saleModel->where("id",$id)->first(); 
        $deliveries = $this->deliveryModel->where('sale_id',$id)->get()->getFirstRow();

        if($deliveries == NULL)
 
        if($sale == NULL){ 
            $this->session->setFlashdata('message_type', 'error'); 
            $this->session->setFlashdata('message_content', 'Data tidak ditemukan'); 
            return redirect()->to(base_url('dashboard')); 
        } 
 
        if($sale->contact_id == NULL){
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', 'Data tidak ditemukan'); 
            return redirect()->to(base_url('dashboard')); 
        } 

        if($sale->payment_id == NULL){
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', 'Data tidak ditemukan'); 
            return redirect()->to(base_url('dashboard'));
        }

        $contact = $this->contactModel
        ->where("id",$sale->contact_id)
        ->first();

        $warehouse = $this->warehouseModel
        ->where("id",$sale->warehouse_id)
        ->first();

        $payment = $this->paymentModel
        ->where("id",$sale->payment_id)
        ->first();

        $vehicles = $this->vehicleModel
        ->where("trash",0)
        ->orderBy("brand","asc")
        ->findAll();
        
        $items = $this->saleItemModel
        ->where("sale_id",$id)
        ->findAll();

        $admin = $this->adminModel
        ->where("id",$sale->admin_id)
        ->first();

        $deliveries = $this->deliveryModel
        ->where("sale_id",$id)
        ->orderBy("sent_date","desc")
        ->orderBy("id","desc")
        ->findAll();

        $deliver = $this->deliveryModel
        ->where("sale_id",$id)
        ->orderBy("sent_date",'desc')
        ->orderBy('id','desc')->findAll();
        
        $saleItem = $this->saleItemModel
        ->orderBy('id','desc')
        ->first();

        $stocks = $this->productStockModel
        ->selectSum('quantity')
        ->where('product_id',$saleItem->product_id)
        ->first();

        $data = ([
            "db"    => $this->db,
            "contact"  => $contact,
            "admin"  => $admin,
            "warehouse"=> $warehouse,
            "payment"=> $payment,
            "sale"  => $sale,
            "items" => $items,
            "deliver" => $deliver,
            "vehicles" => $vehicles,
            "deliveries" => $deliveries,
            "saleItem" => $saleItem,
            "stocks" => $stocks,
        ]);

        return view("modules/sales_manage_warehouse",$data);
    }
    
    public function sales_drive_save(){
        $id = $this->request->getPost('id');
        $vehicle = $this->request->getPost('vehicle');
        $driver = $this->request->getPost('driver');
        $sent_date = $this->request->getPost('sent_date');
        $warehouse_notes = $this->request->getPost('warehouse_notes');

        $this->saleModel->where("id", $id)
            ->set([
                "vehicle_id" => $vehicle,
                "driver_name" => $driver,
                "sent_date" => $sent_date,
                "warehouse_notes" => $warehouse_notes,
            ])->update();

            $this->session->setFlashdata('message_type', 'success');
            $this->session->setFlashdata('message_content', 'Data Surat Jalan Berhasil Disimpan');

        return redirect()->to(base_url('sales/manage/'.$id.'/warehouse'));
    }

    public function deliveries_add(){
        $id = $this->request->getPost('id');
        $vehicle = $this->request->getPost('vehicle');
        $driver = $this->request->getPost('driver');
        $sent_date = $this->request->getPost('sent_date');
        $warehouse_notes = $this->request->getPost('warehouse_notes');

        $this->deliveryModel
            ->insert([
            "sale_id"=>$id,
            "vehicle_id" => $vehicle,
            "driver_name" => $driver,
            "sent_date" => $sent_date,
            "warehouse_notes" => $warehouse_notes,
        ]);

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data Pengiriman Berhasil Dibuat');

        return redirect()->to(base_url('sales/manage/'.$id.'/warehouse'));
    }

    public function deliveries_item_add(){
        $delivery = $this->request->getPost('delivery');
        $sale = $this->request->getPost('sale');
        $item = $this->request->getPost('item');
        $qty = $this->request->getPost('qty');
        $no_trx = $this->request->getPost('no_trx');

        $thisItem = $this->saleItemModel->where("id",$item)->first();
        $thisDeliveredItem = $this->deliveryItemModel->selectSum("quantity")->where("sale_item_id",$item)->first();

        $sumQty = $thisItem->quantity - $thisDeliveredItem->quantity;

        //lakukan pengecekan qty pesan yang telah dikirim

        if($qty == 0){
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', 'Pengiriman Item Tidak Boleh Nol');

            return redirect()->to(base_url('sales/manage/'.$sale.'/warehouse'));
        }else{
            if($qty > $sumQty){
                $this->session->setFlashdata('message_type', 'error');
                $this->session->setFlashdata('message_content', 'Pengiriman Item Telah Melebihi Kuantites Yang Dipesan');

                return redirect()->to(base_url('sales/manage/'.$sale.'/warehouse'));
            }else{
                $insert = $this->deliveryItemModel
                ->insert([
                    "delivery_id" => $delivery,
                    "sale_item_id" => $item,
                    "quantity" => $qty
                ]);


                $this->update_status_empat($no_trx);


                $this->session->setFlashdata('message_type', 'success');
                $this->session->setFlashdata('message_content', 'Pengiriman Item Berhasil Ditambahkan'); 
                return redirect()->to(base_url('sales/manage/'.$sale.'/warehouse')); 
            }
        }
    }

    public function update_status_empat($no_trx){

        //cek selisih qty pesan
        $cek_qty_pesan = $this->db->table("sales a");
        $cek_qty_pesan->select("sum(b.quantity) as quantity_pesan,b.id");
        $cek_qty_pesan->join("sale_items b","a.id=b.sale_id","inner");
        $cek_qty_pesan->where(['number'=>$no_trx]);
        $rows_qty = $cek_qty_pesan->get();

        if($rows_qty->getNumRows() > 0){

            $cek_qty_kirim = $this->db->table("sales a");
            $cek_qty_kirim->select("sum(c.quantity) as qty_kirim");
            $cek_qty_kirim->join("sale_items b","a.id=b.sale_id","inner");
            $cek_qty_kirim->join("delivery_items c","b.id=c.sale_item_id","left");
            $cek_qty_kirim->where(['number'=>$no_trx]);
            $rows_qty_kirim = $cek_qty_kirim->get();

            if($rows_qty_kirim->getNumRows() > 0){

                // 9 > 9
                if(($rows_qty->getRow()->quantity_pesan) > $rows_qty_kirim->getRow()->qty_kirim ) :

                //update status
                     $this->saleModel->where("number",$no_trx)->set(["status"=>4])->update();
            else :
                $this->saleModel->where("number",$no_trx)->set(["status"=>5])->update();

            endif;
            }
        }   
    }

    public function deliveries_save(){
        $id = $this->request->getPost('id');
        $sale = $this->request->getPost('sale');
        $vehicle = $this->request->getPost('vehicle');
        $driver = $this->request->getPost('driver');
        $sent_date = $this->request->getPost('sent_date');
        $warehouse_notes = $this->request->getPost('warehouse_notes');

        $this->deliveryModel->where("id",$id)
        ->set([
            "vehicle_id" => $vehicle,
            "driver_name" => $driver,
            "sent_date" => $sent_date,
            "warehouse_notes" => $warehouse_notes,
        ])->update();

        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data Pengiriman Berhasil Disimpan');

        return redirect()->to(base_url('sales/manage/'.$sale.'/warehouse'));
    }

    public function deliveries_delete($sale,$id){
        $this->deliveryModel->where("id",$id)->delete();
        $this->deliveryItemModel->where("delivery_id",$id)->delete(); 
        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Data Pengiriman Berhasil Dihapus'); 

        return redirect()->to(base_url('sales/manage/'.$sale.'/warehouse')); 
    }

    public function deliveries_items_delete($sale,$item){
        $no_trx = $this->request->getGet('no_trx');

        $this->deliveryItemModel->where("id",$item)->delete();
        $this->update_status_empat($no_trx);
        $this->session->setFlashdata('message_type', 'success');
        $this->session->setFlashdata('message_content', 'Pengiriman Item Berhasil Dihapus');

        return redirect()->to(base_url('sales/manage/'.$sale.'/warehouse'));
    }

    public function reports(){
        return view('modules/reports');
    }
    
    public function reports_print(){
        $date = $this->request->getGet('date');
        
        $products = $this->getProductsAge($date);
        $sales = $this->getSalesAge();
        
        
        $productSales = $this->calculatePurchaseAndSales($products, $sales); //pembelian - penjualan
        
        $data = ([
            "date"  => $date,
            "products"  => $productSales,
            "db"=> $this->db,
        ]);

        return view("modules/reports_print",$data);
    }
    
    public function referralCode()
    {
        $member = $this->getRegisteredMember();
        
        $data = [
            "users" => $member  
        ];
        
        return view('modules/referral_code', $data);
    }
    
    public function addReferralCode()
    {
        $sales_id = $this->request->getVar('sales_id');
        $referralCode = $this->generateReferralCode(7);
        
        $data = [
            "sales_id" => $sales_id,
            "referral_code" => $referralCode
        ];
        
        $this->referralModel->insert($data);
        
        return redirect()->to(base_url('sales/referral-code'));  
    }
    
    public function generateReferralCode($length)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $randomString = '';
    
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
    
        return $randomString;
    }
    
    public function getAllSales()
    {
        $sales = $this->adminModel->select(['administrators.name', 'administrators.id'])->where('active', 1)->whereIn('role', [2,3])->findAll();
        
        $data = [
            "sales" => $sales    
        ];
        
       return $this->response->setJSON($data);
    }
    
    private function getRegisteredMember()
    {
        $refCode = $this->referralModel
        ->select(["referral_code.referral_code", "referral_code.id", "administrators.name"])
        ->join('administrators', 'referral_code.sales_id = administrators.id', 'left')
        ->findAll();
        
        $contacts = $this->contactModel
        ->select(["COUNT(id) as total_member", "no_reference"])
        ->where('is_member', 1)
        ->whereIn("no_reference", array_column($refCode, "referral_code"))
        ->groupBy('no_reference')
        ->findAll();
        
        $data = $this->prepareMemberData($refCode, $contacts);
        
        return $data;
    }
    
    private function prepareMemberData($refCode, $contacts)
    {
        $data = [];
        
        foreach($refCode as $code) {
            $member = [
                "id" => $code->id,
                "sales" => $code->name,
                "refCode" => $code->referral_code,
                "member" => $this->findTotalMember($contacts, $code->referral_code)
            ];
            
            $data[] = $member;
        }
        
        return $data;
    }
    
    private function findTotalMember($contacts, $refCode)
    {
        foreach($contacts as $user) {
            if($user->no_reference == $refCode) {
                return $user->total_member;
            }
        }
        
        return "0";
    }
    
    private function getProductsAge($date) //pembelian      
    {
        $products = $this->productModel->select(["id", "name"])->whereNotIn("id", [700, 701, 702, 703, 704, 1248, 1386, 1474, 1831])->where("trash", 0)->orderBy("name", "asc")->findAll();
        
        $thirtyDays = $this->productStockModel
            ->select(["SUM(product_stocks.quantity) as total", "product_stocks.product_id", "product_stocks.warehouse_id", "product_stocks.date"])
            ->whereIn("product_stocks.product_id", array_column($products, "id"))
            ->where("product_stocks.buy_item_id IS NOT NULL")
            ->where("product_stocks.date <=", date("Y-m-d", strtotime($date)))
            ->where("product_stocks.date >=", date("Y-m-d", strtotime("-30 days", strtotime($date))))
            ->groupBy(["product_stocks.product_id"])
            ->findAll();

        $sixtyDays = $this->productStockModel
            ->select(["SUM(product_stocks.quantity) as total", "product_stocks.product_id", "product_stocks.warehouse_id", "product_stocks.date"])
            ->whereIn("product_stocks.product_id", array_column($products, "id"))
            ->where("product_stocks.buy_item_id IS NOT NULL")
            ->where("product_stocks.date <=", date("Y-m-d", strtotime("-31 days", strtotime($date))))
            ->where("product_stocks.date >=", date("Y-m-d", strtotime("-60 days", strtotime($date)))) // 1=2 ,2=1, 3=2
            ->groupBy(["product_stocks.product_id"])
            ->findAll();

        $ninetyDays = $this->productStockModel
            ->select(["SUM(product_stocks.quantity) as total", "product_stocks.product_id", "product_stocks.warehouse_id", "product_stocks.date"])
            ->whereIn("product_stocks.product_id", array_column($products, "id"))
            ->where("product_stocks.buy_item_id IS NOT NULL")
            ->where("product_stocks.date <=", date("Y-m-d", strtotime("-61 days", strtotime($date))))
            ->where("product_stocks.date >=", date("Y-m-d", strtotime("-90 days", strtotime($date))))
            ->groupBy(["product_stocks.product_id"])
            ->findAll();

        $moreThanNinetyDays = $this->productStockModel
            ->select(["SUM(product_stocks.quantity) as total", "product_stocks.product_id", "product_stocks.warehouse_id", "product_stocks.date"])
            ->whereIn("product_stocks.product_id", array_column($products, "id"))
            ->where("product_stocks.buy_item_id IS NOT NULL")
            ->where("product_stocks.date <=", date("Y-m-d", strtotime("-91 days", strtotime($date))))
            ->where("product_stocks.date >=", date("Y-m-d", strtotime("-120 days", strtotime($date))))
            ->groupBy(["product_stocks.product_id"])
            ->findAll(); 
            
        $sixMonth = $this->productStockModel // Range Bulan 4,5,6,7,8,9,10,11
            ->select(["SUM(product_stocks.quantity) as total", "product_stocks.product_id", "product_stocks.warehouse_id", "product_stocks.date"])
            ->whereIn("product_stocks.product_id", array_column($products, "id"))
            ->where("product_stocks.buy_item_id IS NOT NULL")
            // ->where("product_stocks.date <=", date("Y-m-d", strtotime("-151 days", strtotime($date))))
            // ->where("product_stocks.date >=", date("Y-m-d", strtotime("-180 days", strtotime($date))))
            ->where("product_stocks.date <=", date("Y-m-d", strtotime("-91 days", strtotime($date))))
            ->where("product_stocks.date >=", date("Y-m-d", strtotime("-330 days", strtotime($date))))
            ->groupBy(["product_stocks.product_id"])
            ->findAll();
            
        $oneYear = $this->productStockModel
            ->select(["SUM(product_stocks.quantity) as total", "product_stocks.product_id", "product_stocks.warehouse_id", "product_stocks.date"])
            ->whereIn("product_stocks.product_id", array_column($products, "id"))
            ->where("product_stocks.buy_item_id IS NOT NULL")
            ->where("product_stocks.date <=", date("Y-m-d", strtotime("-331 days", strtotime($date))))
            ->where("product_stocks.date >=", date("Y-m-d", strtotime("-365 days", strtotime($date))))
            ->groupBy(["product_stocks.product_id"])
            ->findAll();
            
        $twoYear = $this->productStockModel
            ->select(["SUM(product_stocks.quantity) as total", "product_stocks.product_id", "product_stocks.warehouse_id", "product_stocks.date"])
            ->whereIn("product_stocks.product_id", array_column($products, "id"))
            ->where("product_stocks.buy_item_id IS NOT NULL")
            ->where("product_stocks.date <=", date("Y-m-d", strtotime("-366 days", strtotime($date))))
            ->where("product_stocks.date >=", date("Y-m-d", strtotime("-730 days", strtotime($date))))
            ->groupBy(["product_stocks.product_id"])
            ->findAll();
        
        // $prepare = $this->prepareProductsDataBasedOnAges($products, $thirtyDays, $sixtyDays, $ninetyDays, $moreThanNinetyDays);
        
        $prepare = $this->prepareProductsDataBasedOnAges($products, $thirtyDays, $sixtyDays, $ninetyDays, $sixMonth, $oneYear, $twoYear);
        
        return $prepare;
    }
    
    private function getSalesAge()
    {
        $products = $this->productModel->select(["id", "name"])->whereNotIn("id", [700, 701, 702, 703, 704, 1248, 1386, 1474, 1831])->where("trash", 0)->orderBy("name", "asc")->findAll();
        
        $sales = $this->productStockModel
        ->select(["SUM(product_stocks.quantity) as total", "product_stocks.product_id", "product_stocks.date", "product_stocks.sale_item_id"])
        ->whereIn("product_stocks.product_id", array_column($products, "id"))
        ->where("product_stocks.sale_item_id IS NOT NULL")
        ->groupBy(["product_stocks.product_id"])
        ->findAll();
        
        $displays = $this->productStockModel
        ->select(["SUM(quantity) as total", "product_id", "date"])
        ->whereIn("product_id", array_column($products, "id"))
        ->where("product_display_id IS NOT NULL")
        ->groupBy("product_id")
        ->findAll();
        
        $returns = $this->productStockModel
        ->select(["SUM(product_stocks.quantity) as total", "product_stocks.product_id", "product_stocks.date"])
        ->whereIn("product_stocks.product_id", array_column($products, "id"))
        ->where("product_return_id IS NOT NULL")
        ->groupBy(["product_stocks.product_id"])
        ->findAll();
        
        $transfers = $this->productStockModel
        ->select(["SUM(product_stocks.quantity) as total", "product_stocks.product_id", "product_stocks.date"])
        ->whereIn("product_stocks.product_id", array_column($products, "id"))
        ->where("product_stocks.warehouse_transfer_id IS NOT NULL")
        ->where("product_stocks.quantity < 0")
        ->groupBy("product_stocks.product_id")
        ->findAll();
        
        $pemasok = $this->db->table('product_returns_item')
        ->select(["SUM(quantity) as total", "product_id", "product_returns.date"])
        ->join("product_returns", "product_returns_item.return_pemasok_id = product_returns.id")
        ->whereIn("product_id", array_column($products, "id"))
        ->groupBy(["product_id"])
        ->get()->getResult();
        
        $prepare = $this->prepareSalesDataForProductsAge($products, $sales, $returns, $transfers, $pemasok,$displays);
        
        return $prepare;
    }
    
   
    
    private function prepareProductsDataBasedOnAges($products, $thirtyDays, $sixtyDays, $ninetyDays, $sixMonth, $oneYear, $twoYear)
    {
        $data = [];
        foreach($products as $product){
            $productData = [
                "product_id" => $product->id,
                "product_name" => $product->name,
                "thirtyDays" => $this->calculateTotalQuantityForProductAge($thirtyDays, $product->id),
                "sixtyDays" => $this->calculateTotalQuantityForProductAge($sixtyDays, $product->id),
                "ninetyDays" => $this->calculateTotalQuantityForProductAge($ninetyDays, $product->id),
                // "moreThanNinetyDays" => $this->calculateTotalQuantityForProductAge($moreThanNinetyDays, $product->id)
                "sixMonth" => $this->calculateTotalQuantityForProductAge($sixMonth, $product->id),
                "oneYear" => $this->calculateTotalQuantityForProductAge($oneYear, $product->id),
                "twoYear" => $this->calculateTotalQuantityForProductAge($twoYear, $product->id),
            ];
            
            // $total = $productData["thirtyDays"]["quantity"] + $productData["sixtyDays"]["quantity"] + $productData["ninetyDays"]["quantity"] + $productData["moreThanNinetyDays"]["quantity"];
            
            // $productData["total"] = $total;
            
            $data[] = $productData;
        }
        
        return $data;
    }
    
    private function prepareSalesDataForProductsAge($products, $sales,$return,$transfer, $pemasok,$display)
    {
        $data = [];
        foreach($products as $product){

           
            $total_sales= $this->calculateTotalQuantityForProductAge($sales, $product->id)['quantity'];
            $total_return = $this->calculateTotalQuantityForProductAge($return, $product->id)['quantity'];
            $total_display = $this->calculateTotalQuantityForProductAge($display, $product->id)['quantity'];
            $total_pemasok = $this->calculateTotalQuantityForProductAge($pemasok, $product->id)['quantity'];
            $total_transfer = 0;// $this->calculateTotalQuantityForProductAge($transfer, $product->id)['quantity'];
            
            $total = $total_sales+$total_return+$total_display+$total_transfer-$total_pemasok;
            $salesData = [
                "product_id" => $product->id,
                "sales" => abs($total),
                "sls"=>$total_sales,
                "return"=>$total_return,
                "display"=>$total_display,
                "transfer"=>$total_transfer
            ];
            
            
            $data[] = $salesData;
        }
        
        return $data;
    }
    
    private function calculateTotalQuantityForProductAge($productsAge, $targetProductsID)
    {
        foreach($productsAge as $product){
            if($product->product_id == $targetProductsID){
                return [
                   "date" => $product->date,
                   "quantity" => $product->total
                ];
            }
        }
        
        return ["date" => NULL, "quantity" => 0];
    }

   
    
    private function calculatePurchaseAndSales($products, $sales)
    {
        $data = [];
        foreach($products as $product){
            $rowData = [];
            
            $thirtyDaysQuantity = $product["thirtyDays"]["quantity"];
            $thirtyDaysDate = $product["thirtyDays"]["date"];
            
            $sixtyDaysQuantity = $product["sixtyDays"]["quantity"];
            $sixtyDaysDate = $product["sixtyDays"]["date"];
            
            $ninetyDaysQuantity = $product["ninetyDays"]["quantity"];
            $ninetyDaysDate = $product["ninetyDays"]["date"];
            
            $sixMonthQuantity = $product["sixMonth"]["quantity"];
            $sixMonthDate = $product["sixMonth"]["date"];
            
            $oneYearQuantity = $product["oneYear"]["quantity"];
            $oneYearDate = $product["oneYear"]["date"];
            
            $twoYearQuantity = $product["twoYear"]["quantity"];
            $twoYearDate = $product["twoYear"]["date"];
            
            foreach($sales as $sale){
                $saleQuantity = $sale["sales"];
                
                if($product["product_id"] == $sale["product_id"]){
                    
                    if($product["twoYear"]["quantity"] > 0){
                        $soldQuantity = min($twoYearQuantity, $saleQuantity); //RESULT = SALES+RETURN+DISPLAY+TRANSFER
                        $twoYearQuantity -= $soldQuantity;
                        $saleQuantity -= $soldQuantity;
                    }
                    if($product["oneYear"]["quantity"] > 0){
                        $soldQuantity = min($oneYearQuantity, $saleQuantity); //RESULT = SALES+RETURN+DISPLAY+TRANSFER
                        $oneYearQuantity -= $soldQuantity;
                        $saleQuantity -= $soldQuantity;
                    }
                    if($product["sixMonth"]["quantity"] > 0){
                        $soldQuantity = min($sixMonthQuantity, $saleQuantity); //RESULT = SALES+RETURN+DISPLAY+TRANSFER
                        $sixMonthQuantity -= $soldQuantity;
                        $saleQuantity -= $soldQuantity;
                    }
                    if($product["ninetyDays"]["quantity"] > 0){
                        $soldQuantity = min($ninetyDaysQuantity, $saleQuantity);
                        $ninetyDaysQuantity -= $soldQuantity;
                        $saleQuantity -= $soldQuantity;
                    }
                    if($product["sixtyDays"]["quantity"] > 0){
                        $soldQuantity = min($sixtyDaysQuantity, $saleQuantity);
                        $sixtyDaysQuantity -= $soldQuantity;
                        $saleQuantity -= $soldQuantity;
                    }
                    if($product["thirtyDays"]["quantity"] > 0){
                        $soldQuantity = min($thirtyDaysQuantity, $saleQuantity);
                        $thirtyDaysQuantity -= $soldQuantity;
                        $saleQuantity -= $soldQuantity;
                    }
                }
            }
            
            $rowData["product_id"] = $product["product_id"];
            $rowData["product_name"] = $product["product_name"];
            $rowData["twoYear"] = ["date" => $twoYearDate, "quantity" => $twoYearQuantity];
            $rowData["oneYear"] = ["date" => $oneYearDate, "quantity" => $oneYearQuantity];
            $rowData["sixMonth"] = ["date" => $sixMonthDate, "quantity" => $sixMonthQuantity];
            $rowData["ninetyDays"] = ["date" => $ninetyDaysDate, "quantity" => $ninetyDaysQuantity];
            $rowData["sixtyDays"] = ["date" => $sixtyDaysDate, "quantity" => $sixtyDaysQuantity];
            $rowData["thirtyDays"] = ["date" => $thirtyDaysDate, "quantity" => $thirtyDaysQuantity];
            
            $total = $rowData["twoYear"]["quantity"] + $rowData["oneYear"]["quantity"] + $rowData["sixMonth"]["quantity"] + $rowData["ninetyDays"]["quantity"] + $rowData["sixtyDays"]["quantity"] + $rowData["thirtyDays"]["quantity"];
            $rowData["total"] = $total;
            
            $data[] = $rowData;
        }
        
        return $data;
    }
    

    
    private function findDaysDifference($date)
    {
        $todaysDate = strtotime(date('Y-m-d'));
        $transferDate = strtotime($date);
        
        $diff = $todaysDate - $transferDate;
        $days = floor($diff / (60 * 60 * 24));
        
        return abs($days);
    }
    
    public function deliveries_print($id,$sent){
      	$no = 0;
        $sale = $this->saleModel->where("id",$id)->first();
        $delivery = $this->deliveryModel->where("id",$sent)->first();

        if($sale == NULL){
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', 'Data tidak ditemukan');

            return redirect()->to(base_url('dashboard'));
        }

        if($delivery == NULL){
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', 'Data tidak ditemukan');

            return redirect()->to(base_url('dashboard'));
        }

        if($sale->contact_id == NULL){
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', 'Data tidak ditemukan');

            return redirect()->to(base_url('dashboard'));
        }
        
        if($sale->payment_id == NULL){
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', 'Data tidak ditemukan');

            return redirect()->to(base_url('dashboard'));
        }

        $contact = $this->contactModel
        ->where("id",$sale->contact_id)
        ->first();

        $warehouse = $this->warehouseModel
        ->where("id",$sale->warehouse_id)
        ->first();

        $payment = $this->paymentModel
        ->where("id",$sale->payment_id)
        ->first();

        $vehicle = $this->vehicleModel
        ->where("id",$sale->vehicle_id)
        ->first();
        
        $items = $this->saleItemModel
        ->where("sale_id",$id)
        ->findAll();

        $delivery_items = $this->deliveryItemModel
        ->where("delivery_id",$sent)
        ->findAll();
      
        $print = $this->deliveryModel
        ->where('deliveries.sale_id',$sale->id)
        ->first();
      
        $no++;

        $data = ([
            "db"    => $this->db,
            "contact"  => $contact,
            "warehouse"=> $warehouse,
            "payment"=> $payment,
            "sale"  => $sale,
            "delivery" => $delivery,
            "vehicle"  => $vehicle,
            "items" => $items,
            "delivery_items" => $delivery_items,
        ]);
        
        $this->deliveryModel
        ->where('deliveries.sale_id',$sale->id)
        ->set([
            'print' => 1,
            'admin_print_id'    => $this->session->login,
            'date' => date('Y-m-d H:i:s')
        ])->update();

        return view("warehouse/print_sale_delivery_letter",$data);
    }
    
    public function product_transfers(){
        $data_transfers = $this->warehouseTransferModel
        ->select([
          'warehouse_transfers.id',
          'warehouse_transfers.date',
          'warehouse_transfers.number',
          'warehouse_transfers.details',
          'contacts.name as contact_name',
          'administrators.name as admin_name',
        ])
        ->join('contacts','warehouse_transfers.contact_id = contacts.id','left')
        ->join('administrators','warehouse_transfers.admin_id = administrators.id','left')
        ->orderBy('warehouse_transfers.id','desc')
        ->get()->getResultObject();
        
        $admins = $this->adminModel
        ->select([
            'administrators.id',
            'administrators.name',
            'administrators.email',
            'administrators.phone',
            'administrators.cabang',
            'administrators.address',
            'administrators.username',
        ])
        ->where('administrators.status', 1)
        ->orderBy('administrators.name','asc')
        ->get()->getResultObject();
        
        $data = ([
            'db' => $this->db,
            'admins' => $admins,
            'data_transfers' => $data_transfers,
        ]);
        
        return view('admin/product_transfers',$data);

    } 
    
    public function transfers_print($good_transfers_id,$id){
        $data_transfers = $this->warehouseTransferModel->where("warehouse_transfers.id",$id)->first();

        $items = $this->warehouseTransfersItemsModel
        ->where("warehouse_transfers_items.warehouse_transfers_id",$id)
        ->findAll();

        $from = $this->warehouseModel
        ->where("id",$data_transfers->warehouse_from_id)
        ->first();

        $to = $this->warehouseModel
        ->where("id",$data_transfers->warehouse_to_id)
        ->first();

        $admin = $this->adminModel
        ->where("id",$data_transfers->admin_id)
        ->first();   

        $data = ([
            "db"    => $this->db,
            "data_transfers"  => $data_transfers,
            "items"=> $items,
            "from"  => $from,
            "to"  => $to,
            "admin" => $admin,
        ]);

        return view("modules/print_transfers",$data);
    }
    
    public function report_sales_bonus()
    {
        $data = $this->request->getVar("data");

        $ArrayData = json_decode($data, true);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Data Bonus Sales');
        $sheet->mergeCells('A1:C1');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getFont()->setSize(14);

        $sheet->setCellValue('A3', 'No');
        $sheet->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('B3', 'Nama Sales');
        $sheet->getStyle('B3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('C3', 'Bonus');
        $sheet->getStyle('C3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);


        $rowCount = 4;
        foreach ($ArrayData as $data) {
            $col = 1;
            foreach ($data as $cell) {
                $sheet->setCellValueByColumnAndRow($col, $rowCount, $cell);
                $col++;
            }
            $rowCount++;
        }

        $sheet->getStyle('A3:C3')->getFont()->setBold(true);
        $sheet->getStyle('A')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        $fileName = uniqid() . "_" . time() . ".xlsx";
        $filePath = WRITEPATH . 'uploads/' . $fileName;
        $writer->save($filePath);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        readfile($filePath);
        exit();
    }
    
    public function export_pergerakan_barang()
    {
        $data = $this->request->getVar("data");
        $arrayData = json_decode($data, true);
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $sheet->setCellValue('A1', 'Data Pergerakan Barang');
        $sheet->mergeCells('A1:E1');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getFont()->setSize(14);

        $rowCount = 3;
        foreach ($arrayData as $data) {
            $col = 1;
            foreach ($data as $cell) {
                $sheet->setCellValueByColumnAndRow($col, $rowCount, $cell);
                $col++;
            }
            $rowCount++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = uniqid() . "_" . time() . ".xlsx";
        $filePath = WRITEPATH . 'uploads/' . $fileName;
        $writer->save($filePath);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        readfile($filePath);
        exit();
    }
    
      public function report_penjualan()
    {
        $bulan = $this->request->getVar('bulan');
        $tahun = $this->request->getVar('tahun');

        $sales = $this->saleModel
            ->join('sale_items', 'sales.id = sale_items.sale_id', 'left')
            ->join('administrators', 'sales.admin_id = administrators.id', 'left')
            ->where('administrators.active', 1)
            ->where('sales.status >=', 5)
            ->where('sales.contact_id !=', 'NULL');

        if (!empty($bulan)) {
            $sales = $sales->where('MONTH(transaction_date)', $bulan);
        }

        if (!empty($tahun)) {
            $sales = $sales->where("YEAR(transaction_date)", $tahun);
        }

        $result = $sales->select('administrators.name, SUM(sale_items.quantity * sale_items.price) as totalSales')
            ->orderBy('totalSales','DESC')
            ->groupBy('administrators.name')
            ->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'PT. GLOBAL MITRATAMA CEMERLANG');
        $sheet->mergeCells('A1:C1');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getFont()->setSize(14);

        $sheet->setCellValue('A2', "$bulan - $tahun");
        $sheet->mergeCells('A2:C2');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2')->getFont()->setSize(14);

        $sheet->setCellValue('A4', 'No');
        $sheet->setCellValue('B4', 'Nama');
        $sheet->setCellValue('C4', 'Pencapaian');

        $column = 5;
        $no = 0;
        foreach ($result as $item) {
            $no++;
            $sheet->setCellValue('A' .  $column, $no);
            $sheet->setCellValue('B' .  $column, $item->name);
            $sheet->setCellValue('C' . $column, "Rp. " . number_format($item->totalSales, 0, ",", "."));
            $column++;
        }

        $sheet->getStyle('A4:C4')->getFont()->setBold(true);
        $sheet->getStyle('A')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'Data Penjualan.xlsx';
        $writer->save($filename);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        readfile($filename);
        exit();
    }
    
    
}