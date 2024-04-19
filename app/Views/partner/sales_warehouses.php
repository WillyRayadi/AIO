<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Pengiriman (DO)
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Pengiriman (DO)</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?> 

<div class="row">
<div class="col-lg">
    <div class="card">
        <div class="card-header bg-info">
            <h5 class="card-title">Data Pengiriman</h5>
        </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table-striped table-bordered table" id="datatables-default">
                        <thead>
                            <tr>
                                <th class="text-center">Nomer SO</th>
                                <th class="text-center">Nama Sales</th>
                                <th class="text-center">Status Penjualan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($sales as $sale) { ?>
                                <tr>
                                    <td class="text-center"><?= $sale->sale_number ?></td>
                                    <td class="text-center"><?= $sale->admin_name ?></td>
                                    <td class="text-center">
                                        <span class="badge badge-<?= config("App")->orderStatusColor[$sale->status] ?>"><?= config("App")->orderStatuses[$sale->status] ?></span>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('deliveries/data/manage/'. $sale->id) ?>" class="btn btn-sm btn-success">
                                            <i class="fas fa-cog"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section("page_script") ?>

<?= $this->endSection() ?>