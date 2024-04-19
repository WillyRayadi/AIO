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


<!-- Query Data Dashboard -->
<?php 
$this->session = \Config\Services::session();
$approve = $db->table('sales');
$approve->selectCount('sales.id');
$approve->where('admin_id', $this->session->login_id);
$approve->where('sales.status', 2);
$approve->where('contact_id !=', NULL);
$approve = $approve->get();
$approve = $approve->getFirstRow();

?>

<?php
$this->session = \Config\Services::session();
$delivery = $db->table('sales');
$delivery->selectCount('sales.id');
$delivery->where('admin_id', $this->session->login_id);
$delivery->where('sales.status', 4);
$delivery->where('contact_id !=', NULL);
$delivery = $delivery->get();
$delivery = $delivery->getFirstRow();
?>

<?php
$this->session = \Config\Services::session();
$deliveries = $db->table('sales');
$deliveries->selectCount('sales.id');
$deliveries->where('admin_id', $this->session->login_id);
$deliveries->where('sales.status', 5);
$deliveries->where('contact_id !=', NULL);
$deliveries = $deliveries->get();
$deliveries = $deliveries->getFirstRow();
?>

<?php
$this->session = \Config\Services::session();
$end = $db->table('sales');
$end->selectCount('sales.id');
$end->where('admin_id', $this->session->login_id);
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
            <a href="<?= base_url('sales/status/approve') ?>" class="small-box-footer">
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
            <a href="<?= base_url('sales/status/dikirim/sebagian') ?>" class="small-box-footer">
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
            <a href="<?= base_url('sales/status/dikirim') ?>" class="small-box-footer">
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
            <a href="<?= base_url('sales/status/selesai') ?>" class="small-box-footer">
                Lihat <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>
 
 
<?= $this->endSection() ?>