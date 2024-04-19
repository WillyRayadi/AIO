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
        <h5 class="card-title">Report Pergerakan Barang</h5>
    </div>
    <div class="card-body">
        <div class="container align-items-center">
            <form action="<?= base_url('reports/pergerakan_barang')?>" method="get">
                <div class="row">

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">Nama Produk</label>
                        <select name="productName" class="select2bs4 form-control">
                            <option>-- Pilih Produk --</option>
                            <?php
                                foreach($prod_id as $product){
                                    echo "<option value='".$product->id."'>".$product->name."</option>";
                                }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-3 form-group">
                        <label class="font-weight-bold">Dari Tanggal</label>
                        <input type='date' name='tanggalawal' class='form-control'>
                    </div>

                    <div class="col-md-3 form-group">
                        <label class="font-weight-bold">Sampai Tanggal</label>
                        <input type="date" name="tanggalakhir" class="form-control">
                    </div>

                    <button class="col btn btn-success" type="submit" value="filters" style="width: 50%; height: 50%; margin-top: 32px;">
                        <i class="fas fa-file"></i>&nbsp; Cetak Laporan
                    </button>

                </div>
            </form>
        </div>
    </div>

 <br>
</div>
 
<?= $this->endSection() ?>

<?= $this->Section("page_script") ?>

<?= $this->endSection() ?>