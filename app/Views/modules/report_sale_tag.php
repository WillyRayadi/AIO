<?= $this->extend("general/template") ?>
<?= $this->section("page_title") ?>
Daftar Penjualan
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>

<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('reports'); ?>">Reports</a></li>
<li class="breadcrumb-item active">Report Sale Tag</li>

<?= $this->endSection(); ?>

<?= $this->section("page_content") ?>

<div class="card">
    <div class="card-header bg-info">
        <h5 class="card-title">Report Data Penjualan Berdasarkan Tag</h5>
    </div>
    <div class="card-body">
        <div class="container align-items-center">
            <form action="<?= base_url('export/sale/tag') ?>" method="get" target="_blank">
                <div class="row">
                    <div class="col form-group">
                        <label class="font-weight-bold">Tag</label>
                        <select class="select2bs4" name="tagname" required>
                            <option value="">-- Pilih Tag --</option>
                            <?php foreach($sales_tag as $tag){ ?>
                                <option value="<?= $tag->tag_name ?>"><?= $tag->tag_name ?></option>
                            <?php } ?>
                            <?php foreach($admins as $value){ ?>
                                <option value="<?= $value->id ?>"><?= $value->name ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    
                    <div class="col form-group">
                        <label class="font-weight-bold">Mulai Tanggal</label>
                        <input class="form-control" name="tanggalawal" type="date" required></input>
                    </div>

                    <div class="col form-group">
                        <label class="font-weight-bold font-weight-italic">Sampai Tanggal</label>
                        <input class="form-control" name="tanggalakhir" type="date" required=""></input>
                    </div>

                    <button class="col btn btn-success" onclick="<?= base_url('sales/reports') ?>" style="width: 50%; height: 50%; margin-top: 32px;">
                        <i class="fas fa-print"></i>&nbsp; Cetak Laporan
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