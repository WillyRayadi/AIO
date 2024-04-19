<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Reports
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>

<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Reports</li>

<?= $this->endSection(); ?>

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
        <a class="nav-link active" aria-current="page" href="<?= base_url('audit/report_sales') ?>">Sales</a>
    </li>

    <!-- <li class="nav-item">
        <a class="nav-link" style="color: gray;" href="#">Pembelian</a>
    </li>
-->

<li class="nav-item">
    <a class="nav-link" style="color: gray;" href="<?= base_url('audit/report_produk')?>">Produk</a>
</li>

</ul>

<div class="card-body">
    <div class="row">

        <div class="column">
            <h4 style="padding-bottom: 1px; font-size: 1.44em; color: #23527c;">Penjualan Sales (SO)</h4>
            <span style="font-size: 14px;">Klik Tombol Dibawah Untuk Menampilkan Daftar Semua List Pejualan Yang Telah Dibuat Oleh Sales, Sesuai Dengan Tanggal Waktu Yang Diinginkan.</span>
            <br>
            <a class="btn btn-transparant btn-small" style="margin-top: 5px; display: inline-block; font-size: 0.9em; border: 2px solid #216a88; color: #216a88;" href="<?= base_url('reports_so'); ?>">Lihat Report</a>
        </div>

        <div class="column">
            <h4 style="padding-bottom: 1px; font-size: 1.44em; color: #23527c;">Penjualan Per-sales</h4>
            <span style="font-size: 14px;">Kamu Juga Bisa Meng-klik Tombol Dibawah Untuk Menampilkan Data Penjualan Per Sales (ID).</span>
            <br>
            <a class="btn btn-transparant btn-small" style="margin-top: 5px; display: inline-block; font-size: 0.9em; border: 2px solid #216a88; color: #216a88;" href="<?= base_url('report_userso'); ?>">Lihat Report</a>
        </div>

        <div class="column" style="margin-top: -120px; margin-bottom: -145px;">
            <h4 style="padding-bottom: 1px; font-size: 1.44em; color: #23527c;">Penjualan (SO) Dengan Status Disetujui</h4>
            <span style="font-size: 14px;">Untuk Melihat Penjualan (SO) Yang Telah Disetujui, Kamu Bisa Meng-kilk Tombol Dibawah.</span>
            <br>
            <a class="btn btn-transparant btn-small" style="margin-top: 5px; display: inline-block; font-size: 0.9em; border: 2px solid #216a88; color: #216a88;" href="<?= base_url('report_setuju'); ?>">Lihat Report</a>
        </div>

        <div class="column" style="margin-top: -120px; margin-bottom: -145px;">
            <h4 style="padding-bottom: 1px; font-size: 1.44em; color: #23527c;">Penjualan (SO) Dengan Status Dikirim</h4>
            <span style="font-size: 14px;">Untuk Melihat Penjualan (SO) Yang Telah Dikirim, Kamu Bisa Meng-kilk Tombol Dibawah.</span>
            <br>
            <a class="btn btn-transparant btn-small" style="margin-top: 5px; display: inline-block; font-size: 0.9em; border: 2px solid #216a88; color: #216a88;" href="<?= base_url('report_kirim'); ?>">Lihat Report</a>
        </div>
        <div class="column" style="margin-top: 20px; margin-bottom: -145px;">
            <h4 style="padding-bottom: 1px; font-size: 1.44em; color: #23527c;">Penjualan (SO) Dengan Status Selesai</h4>
            <span style="font-size: 14px;">Untuk Melihat Penjualan (SO) Yang Telah Selesai, Kamu Bisa Meng-klik Tombol Dibawah.</span>
            <br>
            <a class="btn btn-transparant btn-small" style="margin-top: 5px; display: inline-block; font-size: 0.9em; border: 2px solid #216a88; color: #216a88;" href="<?= base_url('report_selesai'); ?>">Lihat Report</a>
        </div>
      
        <div class="column" style="margin-top: 20px; margin-bottom: -145px;">
            <h4 style="padding-bottom: 1px; font-size: 1.44em; color: #23527c;">Penggunaan Harga</h4>
            <span style="font-size: 14px;">Untuk Melihat Harga Yang Sering Digunakan Oleh Sales, Kamu Bisa Meng-klik Tombol Dibawah.</span>
            <br>
            <a class="btn btn-transparant btn-small" style="margin-top: 5px; display: inline-block; font-size: 0.9em; border: 2px solid #216a88; color: #216a88;" href="<?= base_url('report_penggunaan_harga'); ?>">Lihat Report</a>
        </div>
        
        <div class="column" style="margin-top: 20px; margin-bottom: -145px;">
            <h4 style="padding-bottom: 1px; font-size: 1.44em; color: #23527c;">Aktifitas Persetujuan</h4>
            <span style="font-size: 14px;">Untuk Melihat aktifitas persetujuan harga barang, Kamu Bisa Meng-klik Tombol Dibawah.</span>
            <br>
            <a class="btn btn-transparant btn-small" style="margin-top: 5px; display: inline-block; font-size: 0.9em; border: 2px solid #216a88; color: #216a88;" href="<?= base_url('report_activity_approval'); ?>">Lihat Report</a>
        </div>
        

    </div>
</div>

</div>
<br><br>
<?= $this->endSection() ?>

<?= $this->Section("page_script") ?>

<?= $this->endSection() ?>