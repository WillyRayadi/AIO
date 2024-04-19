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
        <a class="nav-link" style="color: gray;" aria-current="page" href="<?= base_url('audit/report_sales') ?>">Sales</a>
    </li>

    <!-- <li class="nav-item">
        <a class="nav-link" style="color: gray;" href="#">Pembelian</a>
    </li>-->

<li class="nav-item">
    <a class="nav-link active" href="<?= base_url('audit/report_produk')?>">Produk</a>
</li>

</ul>

<div class="card-body">
    <div class="row">

        <div class="column">
            <h4 style="padding-bottom: 1px; font-size: 1.44em; color: #23527c;">Data Produk</h4>
            <span style="font-size: 14px;">Laporan ini untuk menampilkan data semua produk yang ada dan siap untuk di-jual.</span>
            <br>
            <a class="btn btn-transparant btn-small" style="margin-top: 5px; display: inline-block; font-size: 0.9em; border: 2px solid #216a88; color: #216a88;" href="<?= base_url('product/export'); ?>">Lihat Report</a>
        </div>

        <div class="column">
            <h4 style="padding-bottom: 1px; font-size: 1.44em; color: #23527c;">Data Umur Produk</h4>
            <span style="font-size: 14px;">Laporan ini menampilkan umur semua produk yang ada digudang.</span>
            <br>
            <a class="btn btn-transparant btn-small" style="margin-top: 5px; display: inline-block; font-size: 0.9em; border: 2px solid #216a88; color: #216a88;" href="<?= base_url('report_umurbarang'); ?>">Lihat Report</a>
        </div>

        <div class="column" style="margin-top: -150px; margin-bottom: -145px;">
            <h4 style="padding-bottom: 1px; font-size: 1.44em; color: #23527c;">Data Quantity Produk</h4>
            <span style="font-size: 14px;">Laporan ini menampilkan kuantitas stok di setiap gudang untuk semua produk.</span>
            <br>
            <a class="btn btn-transparant btn-small" style="margin-top: 5px; display: inline-block; font-size: 0.9em; border: 2px solid #216a88; color: #216a88;" href="<?= base_url('product/export_quantity') ?>">Lihat Report</a>
        </div>

        <div class="column" style="margin-top: -150px; margin-bottom: -145px;">
            <h4 style="padding-bottom: 1px; font-size: 1.44em; color: #23527c;">Data Harga Per-brand</h4>
            <span style="font-size: 14px;">Laporan ini menampilkan semua harga jualn brang yang kamu pilih.</span>
            <br>
            <a class="btn btn-transparant btn-small" style="margin-top: 5px; display: inline-block; font-size: 0.9em; border: 2px solid #216a88; color: #216a88;" href="<?= base_url('report_produk'); ?>">Lihat Report</a>
        </div>

        <div class="column" style="margin-top: 7px; margin-bottom: -145px;">
            <h4 style="padding-bottom: 1px; font-size: 1.44em; color: #23527c;">Data Barang Masuk</h4>
            <span style="font-size: 14px;">Laporan ini menampilkan barang masuk untuk semua produk yang ada digudang.</span>
            <br>
            <a class="btn btn-transparant btn-small" style="margin-top: 5px; display: inline-block; font-size: 0.9em; border: 2px solid #216a88; color: #216a88;" href="<?= base_url('report_barang_masuk'); ?>">Lihat Report</a>
        </div>
        
       <div class="column" style="margin-top:-10px; margin-bottom: -145px;">
            <h4 style="padding-bottom: 1px; font-size: 1.44em; color: #23527c;">Data Barang Keluar</h4>
            <span style="font-size: 14px;">Laporan ini menampilkan barang keluar untuk semua produk yang ada digudang.</span>
            <br>
            <a class="btn btn-transparant btn-small" style="margin-top: 5px; display: inline-block; font-size: 0.9em; border: 2px solid #216a88; color: #216a88;" href="<?= base_url('report_barang_keluar'); ?>">Lihat Report</a>
        </div>

    </div>
</div>

</div>
<br><br>
<?= $this->endSection() ?>

<?= $this->Section("page_script") ?>

<?= $this->endSection() ?>