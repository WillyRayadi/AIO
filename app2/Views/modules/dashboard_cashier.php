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

<div class="row">
    <div class="col-md-3">
        <div class="small-box" style="border-radius: 10px; background-image: url('http://www.aiostore.co.id/wp-content/uploads/2024/03/Silver_Membership-1-e1709889153874.png');">
            <div class="inner text-white">
                <h3>3</h3>
                <p>Member Silver</p>
            </div>
            <div class="icon">
                <i class="fas fa-check"></i>
            </div>
            <a class="small-box-footer" href="#">
                Lihat <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="small-box" style="border-radius: 10px; background-image: url('http://www.aiostore.co.id/wp-content/uploads/2024/03/Gold_Membership-1-e1709889211490.png');">
            <div class="inner text-white">
                <h3>3</h3>
                <p>Member Gold</p>
            </div>
            <div class="icon">
                <i class="fas fa-check"></i>
            </div>
            <a class="small-box-footer" href="#">
                Lihat <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="small-box" style="border-radius: 10px; background-image: url('http://www.aiostore.co.id/wp-content/uploads/2024/03/Platinum_Membership-1-e1709889249640.png');">
            <div class="inner text-white">
                <h3>3</h3>
                <p>Member Platinum</p>
            </div>
            <div class="icon">
                <i class="fas fa-check"></i>
            </div>
            <a class="small-box-footer" href="#">
                Lihat <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="small-box" style="border-radius: 10px; background-image: url('http://www.aiostore.co.id/wp-content/uploads/2024/03/Diamond_Membership-1-e1709889286481.png');
">
            <div class="inner text-white">
                <h3>3</h3>
                <p>Member Diamond</p>
            </div>
            <div class="icon">
                <i class="fas fa-check"></i>
            </div>
            <a class="small-box-footer" href="#">
                Lihat <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    
</div>
 
<?= $this->endSection() ?>