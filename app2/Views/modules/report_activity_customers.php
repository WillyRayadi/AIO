<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Reports
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>

<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('reports_'); ?>">Reports</a></li>
<li class="breadcrumb-item active">Report Aktifitas Pelanggan</li>

<?= $this->endSection(); ?>

<?= $this->section("page_content") ?>

<div class="card">
    <div class="card-header bg-info">
        <h5 class="card-title">Report Aktifitas Pelanggan</h5>
    </div>
    <div class="card-body">
        <div class="container align-items-center">
            <form action="<?= base_url('reports/report_activity_customer') ?>" method="get" target="_blank">
                <div class="row">
                
                    <div class="col form-group">
                        <label class="font-weight-bold">Nama Pelanggan</label>
                        <select name="customerName" class="select2bs4 form-control">
                            <option>-- Pilih Pelanggan --</option>
                            <?php
                                foreach($customers as $customer){
                                    echo "<option value='".$customer->id."'>".$customer->name."</option>";
                                }
                            ?>
                        </select>
                    </div>

                    <div class="col form-group">
                        <label class="font-weight-bold">Dari Tanggal</label>
                        <input type='date' name='tanggalawal' class='form-control'>
                    </div>

                    <div class="col form-group">
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