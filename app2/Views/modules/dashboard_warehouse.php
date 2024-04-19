<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>

<li class="breadcrumb-item active">Dashboard</li>

<?= $this->endSection(); ?>

<?= $this->section("page_content") ?>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                Selamat Datang <b><?= config("Login")->loginName ?></b>, sebagai <?= config("App")->roles[config("Login")->loginRole] ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <?php
                $thisMonth = date("n");
                $lastMonth = $thisMonth - 1;

                if($thisMonth > 1){
                    $lastYear = date("Y");
                    $lastMonth = $lastMonth;
                }else{
                    $lastYear = date("Y") - 1;
                    $lastMonth = 12;
                }

                $times = $db->table('sales');
                $times->select('AVG(TIMESTAMPDIFF(SECOND, sales.time_create, sales.time_done)) AS average_seconds');
                $times->where('sales.contact_id !=', NULL);
                $times->where('sales.time_create !=', NULL);

                // Add the conditions for the last month
                if(date("j") > 20){
                    $times->where("transaction_date >=",date("Y-".$thisMonth."-01"));
                    $times->where("transaction_date <=",date("Y-".$thisMonth."-31"));
                }else{
                    $times->where("transaction_date >=",date("Y-".$thisMonth."-01"));
                    $times->where("transaction_date <=",date("Y-".$thisMonth."-31"));
                }

                $times = $times->get();
                $averageSeconds = $times->getRow()->average_seconds;

                // Calculate average time
                $days = floor($averageSeconds / (60 * 60 * 24));
                $averageSeconds %= (60 * 60 * 24);
                $hours = floor($averageSeconds / (60 * 60));
                $averageSeconds %= (60 * 60);
                $minutes = floor($averageSeconds / 60);
                $seconds = $averageSeconds % 60;
    
                // Display the result
                echo "Rata-rata pengiriman: ";
                if ($days > 0) {
                    echo "<b>$days hari,</b> ";
                }
                if ($hours > 0) {
                    echo "<b>$hours jam,</b>";
                }
                if ($minutes > 0) {
                    echo "<b>$minutes menit, </b>";
                }
                echo "<b>$seconds detik</b>.";
                ?>
            </div>
        </div>
    </div>
</div>

<!-- Query Data Dashboard -->
<?php 
$this->session = \Config\Services::session();
$allow_warehouses = !empty(cek_session($this->session->get('login_id'))['allow_warehouses']) ? cek_session($this->session->get('login_id'))['allow_warehouses'] : '"1","2","3","5"';

$approve = $db->table('sales');
$approve->selectCount('sales.id');
$approve->where('sales.status', 2);
$approve->where('contact_id !=', NULL);
$approve = $approve->get();
$approve = $approve->getFirstRow();

?>

<?php
$this->session = \Config\Services::session();
$allow_warehouses = !empty(cek_session($this->session->get('login_id'))['allow_warehouses']) ? cek_session($this->session->get('login_id'))['allow_warehouses'] : '"1","2","3","5"';

$delivery = $db->table('sales');
$delivery->selectCount('sales.id');
$delivery->where('sales.status', 4);
$delivery->where('contact_id !=', NULL);
$delivery = $delivery->get();
$delivery = $delivery->getFirstRow();
?>

<?php
$this->session = \Config\Services::session();

$allow_warehouses = !empty(cek_session($this->session->get('login_id'))['allow_warehouses']) ? cek_session($this->session->get('login_id'))['allow_warehouses'] : '"1","2","3","5"';

$deliveries = $db->table('sales');
$deliveries->selectCount('sales.id');
$deliveries->where('sales.status', 5);
$deliveries->where('contact_id !=', NULL);
$deliveries = $deliveries->get();
$deliveries = $deliveries->getFirstRow();
?>

<?php
$this->session = \Config\Services::session();
$allow_warehouses = !empty(cek_session($this->session->get('login_id'))['allow_warehouses']) ? cek_session($this->session->get('login_id'))['allow_warehouses'] : '"1","2","3","5"';

$end = $db->table('sales');
$end->selectCount('sales.id');
$end->where('sales.status', 6);
$end->where('contact_id !=', NULL);
$end = $end->get();
$end = $end->getFirstRow();
?>

<div class="row">
    <div class="col-md-3">
        <div class="small-box bg-success">
            <div class="inner">
                <h3><?= $approve->id ?></h3>
                <p>Disetujui</p>
            </div> 
            <div class="icon">
                <i class="fas fa-check"></i>
            </div>
            <a href="<?= base_url('sale/status/approve') ?>" class="small-box-footer">
                Lihat <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-md-3"> 
        <div class="small-box" style="background-color: orange;">
            <div class="inner text-white">
                <h3><?= $delivery->id ?></h3>
                <p>Dikirim Sebagian</p>
            </div>
            <div class="icon">
                <i class="fa fa-truck"></i>
            </div>
            <a href="<?= base_url('sale/status/dikirim/sebagian') ?>" class="small-box-footer">
                Lihat <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-md-3">
        <div class="small-box bg-primary" >
            <div class="inner text-white">
                <h3><?= $deliveries->id ?></h3>
                <p>Dikirim</p>
            </div> 
            <div class="icon">
                <i class="fas fa-shipping-fast"></i>
            </div>
            <a href="<?= base_url('sale/status/dikirim') ?>" class="small-box-footer">
                Lihat <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="small-box bg-secondary">
            <div class="inner"> 
                <h3><?= $end->id ?></h3>
                <p>Selesai</p>
            </div> 

            <div class="icon">
                <i class="fa fa-clipboard-check"></i>
            </div>
            <a href="<?= base_url('sale/status/selesai') ?>" class="small-box-footer">
                Lihat <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>

<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-info">
                <h5 class="card-title">Pilih Penjualan (SO) Untuk Dibuatkan Data Pengiriman Barang (DO)</h5>
            </div>
            <div class="card-body table-responsive">
                <?php
                $this->session = \Config\Services::session();
                $allow_warehouses = !empty(cek_session($this->session->get('login_id'))['allow_warehouses']) ? cek_session($this->session->get('login_id'))['allow_warehouses'] : '"1","2","3","5"';
                
                $sales = $db->table("sales");
                $sales->where("contact_id !=",NULL);
                $sales->where("payment_id !=",NULL);
                $sales->where("status >=",3);
                $sales->where("status <",5);
                $sales->where("Id in(
                    select sale_id from sale_items as AA
                    inner join product_stocks as BB on AA.id=BB.sale_item_id 
                    where BB.warehouse_id in($allow_warehouses)
                )");
                $sales->orderBy("transaction_date","desc");
                $sales->orderBy("id","desc");
                $sales = $sales->get();
                $sales = $sales->getResultObject();
                ?>
                <table class="table table-striped table-bordered" id="datatables-default">
                    <thead>
                        <tr>
                            <th class='text-center'>No</th>
                            <th class='text-center'>Tgl. Transaksi</th>
                            <th class='text-center'>Tgl. Jatuh Tempo</th>
                            <th class='text-center'>Sales</th>
                            <th class='text-center'>Pelanggan</th>
                            <th class='text-center'>Status</th>
                            <th class='text-center'>Tags</th>
                            <th class='text-center'>

                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($sales as $sale){
                            ?>
                            <tr>
                                <td class='text-center'><?= $sale->number ?></td>
                                <td class='text-right'><?= date("d-m-Y",strtotime($sale->transaction_date)) ?></td>
                                <td class='text-right'><?= date("d-m-Y",strtotime($sale->expired_date)) ?></td>
                                <td>
                                    <?php
                                    $admin = $db->table("administrators");
                                    $admin->where("id",$sale->admin_id);
                                    $admin = $admin->get();
                                    $admin = $admin->getFirstRow();

                                    echo $admin->name;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $contact = $db->table("contacts");
                                    $contact->where("id",$sale->contact_id);
                                    $contact->where("type",2);
                                    $contact = $contact->get();
                                    $contact = $contact->getFirstRow();

                                    echo $contact->name." | ".$contact->phone;
                                    ?>
                                </td>
                                <td class='text-center'>
                                <span class="badge badge-<?= config("App")->orderStatusColor[$sale->status] ?>"><?= config("App")->orderStatuses[$sale->status] ?></span>
                                </td>
                                <td>
                                    <?php
                                    $thisSaleTagsExplode = explode("#",$sale->tags);
                                    foreach($thisSaleTagsExplode as $tag) {
                                        if($tag == NULL){
                                            
                                        }else{
                                            echo "#".$tag." ";
                                        }
                                    }
                                    ?>
                                </td>
                                <td class='text-center'>
                                    <a href="<?= base_url('warehouse/sales/'.$sale->id.'/manage') ?>" class='btn btn-success btn-sm' title="Kelola Pesanan Penjualan">
                                        <i class='fa fa-cog'></i>
                                    </a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer"></div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-info">
        <h5 class="card-title">Barang Inden</h5>
    </div>
    <div class="card-body">
        <table class="table table-striped table-bordered" id="datatables-default">
            <thead>
                <tr>
                    <th class="text-center">SKU Produk</th>
                    <th class="text-center">Nama Produk</th>
                    <th class="text-center">Nomer Sales Order</th>
                    <th class="text-center">Tanggal Transaksi</th>
                    <th class="text-center">Nama Pelanggan</th> 
                    <th class="text-center">Lokasi Barang</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $products = $db->table('product_stocks');
                    $products->select([
                        'product_stocks.id',
                        'sales.number as sale_number',
                        'contacts.name as contact_name',
                        'products.name as product_name',
                        'product_stocks.inden_warehouse_id',
                        'warehouses.name as warehouse_name',
                        'products.sku_number as product_sku',
                        'sales.transaction_date as sale_transaction',
                    ]);
                    $products->join('products','product_stocks.product_id = products.id','left');
                    $products->join('warehouses','product_stocks.warehouse_id = warehouses.id','left');
                    $products->join('sale_items','product_stocks.sale_item_id = sale_items.id','left');
                    $products->join('sales','sale_items.sale_id = sales.id', 'left');
                    $products->join('contacts','sales.contact_id = contacts.id','left');
                    $products->where('product_stocks.warehouse_id', 6);
                    $products->where('product_stocks.sale_item_id !=', NULL);
                    $products->where('product_stocks.inden_warehouse_id !=', NULL);
                    $products->orderBy('sales.transaction_date', 'desc');
                    $products = $products->get();
                    $products = $products->getResultObject();
                    
                    foreach ($products as $key => $value) {

                        $inden = $db->table('product_stocks');
                        $inden->select('warehouses.name as warehouse_names', 'left');
                        $inden->join('warehouses', 'product_stocks.inden_warehouse_id = warehouses.id','left');
                        $inden->where('product_stocks.id', $value->id);
                        $inden = $inden->get();
                        $inden = $inden->getFirstRow();
                    ?>
                <tr>
                    <td class="text-center"><?= $value->product_sku ?></td>
                    <td class="text-center"><?= $value->product_name ?></td>
                    <td class="text-center"><?= $value->sale_number ?></td>
                    <td class="text-center"><?= $value->sale_transaction ?></td>
                    <td class="text-center"><?= $value->contact_name ?></td>
                    <td class="text-center"><?= $value->warehouse_name.' Di'. $inden->warehouse_names?></td>
                </tr>   

                <?php 
                    } 
                ?>
                </tbody>
        </table>
    </div> 
</div>   

<script type="text/javascript">
    $(document).ready(function() {
        $('#datatables-default').DataTable();
        $('#datatables-secondary').DataTable();
    });
</script>

<?= $this->endSection() ?>