<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>

<li class="breadcrumb-item active">Dashboard</li>

<?= $this->endSection(); ?>

<?= $this->section("page_content") ?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                Selamat Datang <b><?= config("Login")->loginName ?></b>, sebagai <?= config("App")->roles[config("Login")->loginRole] ?>
            </div>
        </div>
    </div>
</div>

<?php
$warehouses = $db->table("warehouses");
$warehouses->where("trash",0);
$warehouses = $warehouses->get();
$warehouses = $warehouses->getResultObject();
?>

<?php
$products = $db->table("products");
$products->where("trash",0);
$products = $products->get();
$products = $products->getResultObject();
?>

<?php
$customers = $db->table("contacts");
$customers->where("type",2);
$customers->where("trash",0);
$customers = $customers->get();
$customers = $customers->getResultObject();
?>

<?php
$suppliers = $db->table("contacts");
$suppliers->where("type",1);
$suppliers->where("trash",0);
$suppliers = $suppliers->get();
$suppliers = $suppliers->getResultObject();
?>

<div class="row">
    <div class="col-md-3">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3><?= count($warehouses) ?></h3>
                <p>Gudang</p>
            </div>
            <div class="icon">
                <i class="fa fa-warehouse"></i>
            </div>
            <a href="<?= base_url('warehouses') ?>" class="small-box-footer">
                Lihat <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="small-box bg-success">
            <div class="inner">
                <h3><?= count($products) ?></h3>
                <p>Barang</p>
            </div>
            <div class="icon">
                <i class="fa fa-th-large"></i>
            </div>
            <a href="<?= base_url('products') ?>" class="small-box-footer">
                Lihat <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="small-box bg-info">
            <div class="inner">
                <h3><?= count($customers) ?></h3>
                <p>Pelanggan</p>
            </div>
            <div class="icon">
                <i class="fa fa-address-book"></i>
            </div>
            <a href="<?= base_url('contacts') ?>" class="small-box-footer">
                Lihat <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="small-box bg-info">
            <div class="inner">
                <h3><?= count($suppliers) ?></h3>
                <p>Pemasok</p>
            </div>
            <div class="icon">
                <i class="fa fa-address-book"></i>
            </div>
            <a href="<?= base_url('contacts') ?>" class="small-box-footer">
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
                <h5 class="card-title">Data Penjualan (SO) Yang Sedang Berjalan</h5>
            </div>
            <div class="card-body table-responsive">
                <?php
                $sales = $db->table("sales");
                $sales->where("contact_id !=",NULL);
                $sales->where("payment_id !=",NULL);
                $sales->where("status <",6);
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
                                    <a href="<?= base_url('sales/'.$sale->id.'/manage') ?>" class='btn btn-success btn-sm' title="Kelola Pesanan Penjualan">
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


<?= $this->endSection() ?>