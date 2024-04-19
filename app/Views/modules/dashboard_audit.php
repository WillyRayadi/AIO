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
    $products = $db->table('products as a');
    $products->select('Count(a.id) as total_product');
    $products->where('a.trash', 0);
    $products->orderBy('a.name', 'asc');
    $products = $products->get();
    $product = $products->getFirstRow();
?>

<?php 
    $sales = $db->table('sales');
    $sales->select('count(id) as total_sale');
    $sales->where('contact_id !=', NULL);
    $sales->where('payment_id !=', NULL);
    $sales->where('sales.trash', 0);
    $sales->orderBy('sales.transaction_date','asc');
    $sales = $sales->get();
    $sale = $sales->getFirstRow();
?>

<div class="row">
    <div class="col-md-3"> 
        <div class="small-box bg-success">
            <div class="inner">
                <h3><?= $product->total_product ?></h3>
                <p>Total Produk</p>
            </div> 
            <div class="icon">
                <i class="fa fa-archive"></i>
            </div>
            <a href="<?= base_url('audit/product_all') ?>" class="small-box-footer">
                Lihat <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="small-box bg-info">
            <div class="inner">
                <h3><?= $sale->total_sale ?></h3>
                <p>Total Penjualan</p>
            </div>
            <div class="icon">
                <i class="fas fa-tag"></i>
            </div>
            <a href="<?= base_url('audit/sales') ?>" class="small-box-footer">
                Lihat <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
   
</div>


<?= $this->endSection() ?>