<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Reports
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>

<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('reports_'); ?>">Reports</a></li>
<li class="breadcrumb-item active">Report Produk</li>

<?= $this->endSection(); ?>

<?= $this->section("page_content") ?>

<div class="card">
    <div class="card-header bg-info">
        <h5 class="card-title">Report Umur Produk</h5>
    </div>
    <div class="card-body">
        <div class="container align-items-center">
            <form action="<?= base_url('reports/print') ?>" method="get" target="_blank">
                <div class="row">

                    <div class="col form-group">
                        <label class="font-weight-bold">Periode Tanggal</label>
                        <input type='date' name='date' class='form-control'  value="<?= date("Y-m-d") ?>">
                    </div>

                    <button class="col btn btn-success" style="width: 50%; height: 50%; margin-top: 32px;">
                        <i class="fas fa-file"></i>&nbsp; Cetak Laporan
                    </button>

                </div>
            </form>
        </div>
    </div>

 <br>
</div>


<!-- <div class="row mb-2">
    <div class="col-md-12">
        <form action="<?= base_url('reports/print') ?>" method="get" target="_blank">
            <div class="card">

                <div class="card-header bg-info">
                    <h5 class="card-title">
                            Laporan Umur Stok
                        </h5>
                </div>
                <div class="card-body">
                    <div class="col form-group">
                        <label>Periode Tanggal</label>
                        <input type='date' name='date' class='form-control'  value="<?= date("Y-m-d") ?>">
                    </div>
                    <div class="col form-group">
                        <button type='submit' class='btn btn-block btn-info'>
                            <i class='fa fa-print'></i>
                            Cetak
                        </button>
                    </div>
                </div>
                <div class="card-footer"></div>
            </div>
        </form>
    </div>
</div> -->

<?= $this->endSection() ?>

<?= $this->Section("page_script") ?>

<?= $this->endSection() ?>