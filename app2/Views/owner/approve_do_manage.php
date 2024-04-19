<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Kelola Pengajuan
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('#'); ?>">Pengajuan</a></li>
<li class="breadcrumb-item active">Kelola Pengajuan</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>


<div class="clearfix"></div>


<div class="row">
    <div class="col-md-9">
        <div class="card">
            <div class="card-header bg-info">
                <h5 class="card-title">Data Penjualan</h5>
            </div>
            <div class="card-body">
            <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>No. Transaksi</label>
                            <br>
                            <?= $stages->sale_number ?>
                        </div>      
                        <div class="form-group">
                            <label>Pelanggan (Kontak)</label>
                            <br>
                            <?= $stages->contact_name ?>
                        </div>
                        <div class="form-group">
                            <label>Alamat Pelanggan</label>
                            <br>
                            <?= $stages->contact_address ?>
                        </div>                                  
                    </div> 
                    
                    <div class="col-md-7">
                        <div class="form-group">
                            <label>Nama User yang Mengajukan</label>
                            <br>
                            <?= $stages->admin_name ?>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Mengajukan</label>
                            <br>
                            <?= $stages->submit_date ?>
                        </div>
                        <div class="form-group">
                            <label>Alasan Mengajukan</label>
                            <br>
                            <?= $stages->reason ?>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div> 
                </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-header bg-info">
                <h5 class="card-title">Persetujuan</h5>
            </div>
            <div class="card-body">
                <div class="text-center">
                <a href="<?= base_url('approve/do/check/'.$stages->id) ?>" class="btn btn-sm btn-success">
                    <i class='fa fa-check'></i>
                </a>
                <a href="" class="btn btn-sm btn-danger">
                    <i class='fa fa-times'></i>
                </a>
                </div>
            </div>
            <div class="card-footer"></div>
        </div>

        <div class="card">
            <div class="card-header bg-info">
                <h5 class="card-title">Files</h5>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <a href="<?= base_url('public/submit_do/'.$stages->image_path) ?>" class="btn btn-sm btn-success">Lihat Data</a>
                </div>
            </div>
            <div class="card-footer"></div>
        </div>
    </div>
</div>

<div class="clearfix"></div>
<?= $this->endSection() ?>

<?= $this->section("page_script") ?>

<?= $this->endSection() ?>