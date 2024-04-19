<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class SalesAPI extends BaseController
{
    use ResponseTrait;

    protected $SalesModel;
    protected $SaleItemsModel;
    protected $AdminModel;
    private $pointModel;
    private $pointExchangeModel;

    public function __construct()
    {
        $this->SalesModel = new \App\Models\Sale();
        $this->pointModel = new \App\Models\UserPoint();
        $this->SaleItemsModel = new \App\Models\SaleItem();
        $this->AdminModel = new \App\Models\Administrator();
        $this->pointExchangeModel = model("App\Models\PointExchange");
    }

    function index(){
        try {
            
            $get = $this->request->getVar();
            if(!isset($get['phone'])){
                return $this->failNotFound("Params session_id is required");
            }
            
            $phone = $get['phone'];
            
            $Users = $this->pointModel
            ->select([
                "user_point.point_in",
                "user_point.point_out",
                "sales.id as sales_id",
                "sales.invoice_address",
                "sales.transaction_date",
                "sales.number as sale_number",
                "sale_items.price",
                "sale_items.quantity",
            ])
            ->select('SUM(sale_items.quantity * sale_items.price) as totalPrice')
            ->join('sale_items','user_point.sale_item_id = sale_items.id','left')
            ->join('products','sale_items.product_id = products.id', 'left')
            ->join('sales','sale_items.sale_id = sales.id','left')
            ->join('contacts','sales.contact_id = contacts.id', 'left')
            ->where('contacts.phone', $phone)
            ->where('sales.status', 6)
            ->groupBy('sale_items.sale_id')
            ->whereNotIn('products.id', [700, 701, 702, 703, 704])
            ->findAll(); 
            
            
            $PointExchange = $this->pointExchangeModel
            ->select([
                "point_exchange.product_id",
                "point_exchange.contact_id",
                "point_exchange.point",
                "point_exchange.exchange_date",
                "contacts.name"
            ])
            ->join("contacts", "point_exchange.contact_id = contacts.id", "left")
            ->where('contacts.phone', $phone)
            ->findAll();

            
            if (!empty($Users)) {
                $response = [
                    "message" => "Success Fetching Data",
                    "users" => $Users,
                    "points" => $PointExchange
                ];

                return $this->respond($response, 200);
            } else {
                return $this->failNotFound("There's No Data In The Table");
            }
        } catch (\Exception $e) {
            return $this->failServerError("Internal Server Error, Please Try Again Later....");
        }
    }

    function show($id = NULL){
        try {
            $Users = $this->SalesModel
            ->join('sale_items', 'sale_items.sale_id = sales.id', 'left')
            ->join('administrators', 'administrators.id = sales.admin_id', 'left')
            ->join('products', "products.id = sale_items.product_id", "left")
            ->where("sales.contact_id IS NOT NULL")
            ->where("sales.contact_id", $id)
            ->findAll();

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
    
    
    function export_invoice($id) {
        try {
            $invoice = $this->SalesModel
            ->select([
                'sales.id as sales_id',
                'sales.number as sale_number',
                'sales.transaction_date',
                'sales.expired_date',
                'contacts.name as contact_name',
                'contacts.address as contact_address',
                'contacts.phone as contact_phone',
                'products.name as product_name',
                'products.unit as product_unit',
                'sale_items.discount as item_disc',
                'sale_items.price as sale_price',
                'sale_items.quantity as sale_quantity',
                'payment_terms.name as payment_method'
            ])
            ->join('contacts', 'sales.contact_id = contacts.id', 'left')
            ->join('sale_items', 'sales.id = sale_items.sale_id', 'left')
            ->join('products', 'sale_items.product_id = products.id', 'left')
            ->join('administrators', 'sales.admin_id = administrators.id', 'left')
            ->join("payment_terms",'sales.payment_id = payment_terms.id','left')
            ->where('sales.id', $id)
            ->get()->getResult(); 
            
            $sales = $this->SalesModel
            ->select([
                "sales.id",
                "sale_items.discount as item_disc",
                "sale_items.price",
                "sale_items.quantity"
            ])
            ->select("SUM(sale_items.price * sale_items.quantity) as totalPrice")
            ->join("sale_items","sales.id = sale_items.sale_id", "left")
            ->groupBy("sales.id")
            ->where("sales.id", $id)
            ->get()->getRow();
            
        $mpdf = new \Mpdf\Mpdf([
           'mode' => 'utf-8',
           'format' => 'A4-L',
       ]);

        $html = '<meta charset="UTF-8">';
        $html .= '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        $html .= '<meta http-equiv="X-UA-Compatible" content="ie=edge">';
        $html .= '<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">';
        $html .= '<link rel="stylesheet" href="' . base_url('public/adminlte') . '/plugins/fontawesome-free/css/all.min.css">';
        $html .= '<link rel="stylesheet" href="' . base_url('public/adminlte') . '/plugins/select2/css/select2.min.css">';
        $html .= '<link rel="stylesheet" href="' . base_url('public/adminlte') . '/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">';
        $html .= '<link rel="stylesheet" href="' . base_url('public/adminlte') . '/plugins/toastr/toastr.min.css">';
        $html .= '<link rel="stylesheet" href="' . base_url('public/adminlte') . '/dist/css/adminlte.min.css">';
        $html .= '<style type="text/css">@page { size: landscape; } .underline{ border-bottom:2px solid black; } .terbilang{border: 2px solid black;} .attention{border: 2px solid black;}</style>';

    
        $html .= "<table>";
        $html .= "<thead>";
        $html .= "<tr>";
        $html .= "<td style='padding-right:100px; text-transform:uppercase;' class='underline'>".config("App")->ptName."</td>";
        $html .= "<th style='padding-right:30px; padding-left:15px;' class='underline'>INVOICE</th>";
        $html .= "<td style='padding-left: 67px;'>KEPADA YTH.</td>";
        $html .= "</tr>";
        $html .= "</thead>";
        $html .= "</table>";
        
        $invoices = null;
        #Revisi
        foreach($invoice as $item):
        helper("word_helper");
        $discountPercentage = $sales->item_disc / 100;
        $discountAmount = $sales->totalPrice * $discountPercentage;
        $discountPrice = $sales->totalPrice - $discountAmount;
        $number = $sales->totalPrice;
        $text = terbilang($number);

            
            if($item->sale_number !== $invoices)
            {
                $html .= "<table>";
                $html .= "<thead>";
                $html .= "<tr>";
                $html .= "<td style='padding-right: 10px; '><p>Jl.Kalijaga No 4, Pegambiran, Cirebon</p><p>Telp:(0231) 225795</td>";
                $html .= "<td style='padding-right: 30px; '><p>No Invoice</p><p>Tgl.Invoice</p><p>Jatuh Tempo</p><p>Cara Bayar</p></td>";
                $html .= "<td style='padding-right: 40px; '><p>".$item->sale_number."</p><p>".$item->transaction_date."</p><p>".date("Y-m-d", strtotime($item->expired_date))."</p><p>".$item->payment_method."</p></td>";
                $html .= "<td style='padding-left:10px;'><p>".$item->contact_name."</p><p>".$item->contact_address."</p><p>".$item->contact_phone."</p></td>";
                $html .= "</tr>";
                $html .= "</thead>";
                $html .= "</table>";
                $html .= "<br>";
                
                $invoices = $item->sale_number;
            }
        endforeach;
            
            $html .= "<table class='table'>";
            $html .= "<thead>";
            $html .= "<tr>";
            $html .= "<th>Nama Barang</th>";
            $html .= "<th>Kemasan</th>";
            $html .= "<th>Qty</th>";
            $html .= "<th>Harga Satuan</th>";
            $html .= "<th>Disc</th>";
            $html .= "<th>Jumlah</th>";
            $html .= "</tr>";
            $html .= "</thead>";
            $html .= "<tbody>";
            foreach($invoice as $item):
            $html .= "<tr>";
            $html .= "<td>".$item->product_name."</td>";
            $html .= "<td>".$item->product_unit."</td>";
            $html .= "<td>".$item->sale_quantity."</td>";
            $html .= "<td>Rp. ".number_format($item->sale_price,0,",",".")."</td>";
            $html .= "<td>".$item->item_disc."%</td>";
            $html .= "<td>Rp. ".number_format($item->sale_price * $item->sale_quantity, 0,",",".")."</td>";
            $html .= "</tr>";
            endforeach;
            $html .= "</tbody>";
            $html .= "</table>";
            $html .= "<br>";
            
            
            $html .= "<table>";
            $html .= "<tbody>";
            $html .= "<tr>";
            $html .= "<td class='terbilang'><p>TERBILANG</p><p>".strtoupper($text)."</p></td>";
            $html .= "<td style='padding-left: 15px; padding-right: 10px;'><p>Sub Total</p><p>Grand Total</p></td>";
            $html .= "<td><p>Rp. ".number_format($discountPrice,0,',','.')."</p><p>Rp. ".number_format($discountPrice,0,',','.')."</p></td>";
            $html .= "</tr>";
            $html .= "</tbody>";
            $html .= "</table>";
            
            $html .= "<table class='mt-5'>";
            $html .= "<thead>";
            $html .= "<tr class='text-center'>";
            $html .= "<td class='text-center' style='padding-right: 80px; padding-left:80px;'><p>Penerima</p><br><br><br><br><br><p>(........................)</p></td>";
            $html .= "<td class='attention' style='padding-right: 50px;'><p>PERHATIAN</p><p>BCA - 134 888 4424 A.N. PT GLOBAL MITRATAMA CEMERLANG</p></td>";
            $html .= "<td class='text-center' style='padding-left:80px;'><p>Hormat Kami</p><br><br><br><br><br><p>(........................)</p></td>";
            $html .= "</tr>";
            $html .= "</thead>";
            $html .= "</table>";
   
        
        
        $mpdf->WriteHTML($html);
        $filename = 'Invoice.pdf';
        header('Content-Type: application/pdf'); 
        header('Content-Disposition: attachment;');
        $mpdf->Output($filename, \Mpdf\Output\Destination::DOWNLOAD);
        exit();
    } catch (\Exception $e) {
        return $this->failServerError("Internal Server Error, Please Try Again Later....");
    }
    
}

}
