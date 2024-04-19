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
                <?php 
                $session = \Config\Services::session(); 
                if($session->login_id == 98): ?>
                    Selamat Datang <b><?= config("Login")->loginName ?></b>, sebagai Kepala Gudang
                <?php else: ?>
                    Selamat Datang <b><?= config("Login")->loginName ?></b>, sebagai <?= config("App")->roles[config("Login")->loginRole] ?>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>