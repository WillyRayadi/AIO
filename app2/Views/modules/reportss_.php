<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Reports
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>

<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Reports</li>

<?= $this->endSection(); ?> -->

<?= $this->section("page_content") ?>
<style>
    * {
      box-sizing: border-box;
  }

/* Create two equal columns that floats next to each other */
.column {
  float: left;
  width: 50%;
  padding: 10px;
  height: 300px; /* Should be removed. Only for demonstration */
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}
</style>

<div class="card">

    <div class="card-header bg-primary">
        <h5 class="card-title">Reports Data</h5>
    </div>

    <ul class="nav nav-tabs pt-2">
        <li class="nav-item">
            <a class="nav-link" style="color: gray;" aria-current="page" href="<?= base_url('reports') ?>">Sales</a>
        </li>
    
        <li class="nav-item">
            <a class="nav-link" style="color: gray;" href="<?= base_url('reports_')?>">Produk</a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link active" href="<?= base_url('reportss_') ?>">Lainnya</a>
        </li>
    </ul>

    <div class="card-body">
        <div class="row pb-5">
            <div class="col-sm">
                <h4 style="padding-bottom: 1px; font-size: 1.44em; color: #23527c;">Data Pelanggan</h4>
                <span style="font-size: 14px;">Laporan ini menampilkan data semua kontak Pelanggan yang ada.</span>
                <br>
                <a class="btn btn-transparant btn-small" style="margin-top: 5px; display: inline-block; font-size: 0.9em; border: 2px solid #216a88; color: #216a88;" href="<?= base_url('export/contact_customers'); ?>">Lihat Report</a>
            </div>
            
            <div class="col-sm">
                <h4 style="padding-bottom: 1px; font-size:1/44dm; color: #23527c;">Data Supplier</h4>
                <span style="font-size: 14px;">Laporan ini menampilkan data semua kontak yang ada.</span>
                <br>
                <a class="btn btn-transparant btn-small" style="margin-top: 5px; display: inline-block; font-size: 0.9em; border: 2px solid #216a88; color: #216a88;"  href="<?= base_url('export/contact_supplier'); ?>">Lihat Report</a>
            </div>
        </div>
        <div class="row pb-5">
            <div class="col-sm">
                <h4 style="padding-bottom: 1px; font-size: 1.44em; color: #23527c;">Hak Akses</h4>
                <span style="font-size: 14px;">Laporan ini menampilkan data tentang hak akses.</span>
                <br>
                <a class="btn btn-transparant btn-small" style="margin-top: 5px; display: inline-block; font-size: 0.9em; border: 2px solid #216a88; color: #216a88;" href="<?= base_url('report/allow/role'); ?>">Lihat Report</a>
            </div>
            <div class="col-sm">
                <h4 style="padding-bottom: 1px; font-size: 1.44em; color: #23427c;">Data User</h4>
                <span style="font-size: 14px;">Klik Laporan ini untuk menampilkan data user yang ada.</span>
                <br>
                <a href="<?= base_url('export/user/stokaio') ?>" class="btn btn-transparant btn-small" style="margin-top: 5px; display: inline-block; font-size: 0.9em; border: 2px solid #216a88; color: #216a88">
                    Lihat Report
                </a>
            </div>
        </div>
    </div>
</div>
<br><br>
<?= $this->endSection() ?>

<?= $this->Section("page_script") ?>

<?= $this->endSection() ?>