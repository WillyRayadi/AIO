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
                Selamat Datang <b><?= config("Login")->loginName ?></b>, sebagai <?= config("App")->roles[config("Login")->loginRole] ?> perusahaan.
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>